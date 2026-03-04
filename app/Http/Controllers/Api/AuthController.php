<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // ---------------- 1. Register (التسجيل) ----------------
    public function register(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'email' => 'required|email|unique:users',
            'phone_number' => 'required|string|unique:users,phone_number', // التأكد من التفرد في العمود الصحيح
            'password' => 'required|string|min:8|confirmed'
        ]);

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone_number' => $request->phone_number, // حفظ القيمة في عمود phone_number
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'status' => true,
            'message' => 'User registered successfully',
            'token' => $token,
            'user' => $user
        ], 201);
    }

    // ---------------- 2. Login (تسجيل الدخول) ----------------
    public function login(Request $request)
    {
        $request->validate([
            'email_or_phone' => 'required|string',
            'password' => 'required|string'
        ]);

        // البحث في الإيميل أو عمود phone_number الجديد
        $user = User::where('email', $request->email_or_phone)
            ->orWhere('phone_number', $request->email_or_phone)
            ->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => false,
                'message' => 'The provided credentials are incorrect.'
            ], 401);
        }

        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'status' => true,
            'message' => 'Login successful',
            'token' => $token,
            'user' => $user
        ]);
    }

    // ---------------- 3. Forgot Password (نسيان كلمة السر) ----------------
    public function forgotPassword(Request $request)
    {
        $request->validate(['email_or_phone' => 'required|string']);

        $user = User::where('email', $request->email_or_phone)
            ->orWhere('phone_number', $request->email_or_phone) // تحديث هنا أيضاً
            ->first();

        if (!$user) {
            return response()->json(['status' => false, 'message' => 'User not found'], 404);
        }

        $otp = rand(1000, 9999);

        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $user->email],
            ['token' => $otp, 'created_at' => now()]
        );

        return response()->json([
            'status' => true,
            'message' => 'OTP generated successfully',
            'otp' => $otp
        ]);
    }

    // ---------------- 4. Reset Password (إعادة تعيين السر) ----------------
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|digits:4',
            'password' => 'required|string|min:8|confirmed'
        ]);

        $record = DB::table('password_reset_tokens')->where('email', $request->email)->first();

        if (!$record || $record->token != $request->otp) {
            return response()->json(['status' => false, 'message' => 'Invalid OTP'], 400);
        }

        $user = User::where('email', $request->email)->first();
        $user->update(['password' => Hash::make($request->password)]);

        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return response()->json(['status' => true, 'message' => 'Password reset successfully']);
    }

    // ---------------- 5. Logout (تسجيل الخروج) ----------------
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'status' => true,
            'message' => 'Logged out successfully'
        ]);
    }

    // ---------------- 6. Get Profile (بيانات الملف الشخصي) ----------------
    public function getProfile(Request $request)
    {
        return response()->json([
            'status' => true,
            'user' => $request->user()
        ], 200);
    }

           // ---------------- 7.updateEmergencyInfo ----------------

    public function updateEmergencyInfo(Request $request)
{
    // التأكد من البيانات اللي جاية من الشاشة (Blood Type, Allergies, etc)
    $request->validate([
        'blood_type' => 'nullable|string',
        'allergies' => 'nullable|string',
        'medical_conditions' => 'nullable|string',
    ]);

    $user = Auth::user(); // نجيب اليوزر اللي عامل Login حالياً
    $user->update([
        'blood_type' => $request->blood_type,
        'allergies' => $request->allergies,
        'medical_conditions' => $request->medical_conditions,
    ]);

    return response()->json([
        'status' => true,
        'message' => 'Emergency information updated successfully!'
    ]);
}
}