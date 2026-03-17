<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite; // إضافة المكتبة الجديدة
use Illuminate\Support\Facades\Http; // لازم تضيفي السطر ده فوق خالص

use Illuminate\Support\Str;

class AuthController extends Controller
{
    // ---------------- 1. Register (التسجيل العادي) ----------------
    public function register(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'email' => 'required|email|unique:users',
            'phone_number' => 'required|string|unique:users,phone_number',
            'password' => 'required|string|min:8|confirmed'
        ]);

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
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

    // ---------------- 2. Login (تسجيل الدخول العادي) ----------------
    public function login(Request $request)
    {
        $request->validate([
            'email_or_phone' => 'required|string',
            'password' => 'required|string'
        ]);

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

    // ---------------- 3. Social Login (جديد: جوجل وفيسبوك) ----------------
    public function socialLogin(Request $request)
    {
        $request->validate([
            'social_id' => 'required|string',
            'social_type' => 'required|in:google,facebook',
            'email' => 'required|email',
            'first_name' => 'nullable|string',
            'last_name' => 'nullable|string',
        ]);

        // البحث عن المستخدم بالـ ID الخاص بجوجل أو فيسبوك
        $column = $request->social_type == 'google' ? 'google_id' : 'facebook_id';
        $user = User::where($column, $request->social_id)->first();

        if (!$user) {
            // لو مش موجود بالـ ID، ندور بالإيميل (ممكن تكون سجلت عادي قبل كدة)
            $user = User::where('email', $request->email)->first();

            if ($user) {
                // نحدث بياناته بالـ ID الجديد للربط
                $user->update([$column => $request->social_id]);
            } else {
                // لو يوزر جديد خالص، نكريه
                $user = User::create([
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'email' => $request->email,
                    'password' => Hash::make(Str::random(16)), // باسورد عشوائي لأنه داخل بجوجل
                    $column => $request->social_id,
                    'social_type' => $request->social_type,
                ]);
            }
        }

        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'status' => true,
            'message' => 'Social login successful',
            'token' => $token,
            'user' => $user
        ]);
    }

    // ---------------- 4. Forgot Password ----------------
    public function forgotPassword(Request $request)
    {
        $request->validate(['email_or_phone' => 'required|string']);

        $user = User::where('email', $request->email_or_phone)
            ->orWhere('phone_number', $request->email_or_phone)
            ->first();

        if (!$user) {
            return response()->json(['status' => false, 'message' => 'User not found'], 404);
        }

        $otp = rand(1000, 9999);

        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $user->email],
            ['token' => $otp, 'created_at' => now()]
        );

        // --- الجزء الخاص بـ UltraMsg ---
        $instance_id = "instance165616"; // حطي الـ Instance ID بتاعك هنا
        $token = "4lymfep8kl3apijw";    // حطي الـ Token بتاعك هنا

        // إرسال الرسالة للواتساب
        Http::post("https://api.ultramsg.com/{$instance_id}/messages/chat", [
            'token' => $token,
            'to' => $user->phone_number,
            'body' => "كود التحقق الخاص بك في VoxGuard هو: {$otp}\nبرجاء استخدامه لإعادة تعيين كلمة السر."
        ]);

        // ----------------------------------------------------------

        return response()->json([
            'status' => true,
            'message' => 'OTP generated successfully and sent to WhatsApp',
            'otp' => $otp // بنسيبه هنا عشان تقدري تجربيه في Postman برضه
        ]);
    }
    // ---------------- 5. Reset Password ----------------
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

    // ---------------- 6. Logout ----------------
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'status' => true,
            'message' => 'Logged out successfully'
        ]);
    }

    // ---------------- 7. Get Profile ----------------
    public function getProfile(Request $request)
    {
        return response()->json([
            'status' => true,
            'user' => $request->user()
        ], 200);
    }

    // ---------------- 8. updateEmergencyInfo ----------------
    public function updateEmergencyInfo(Request $request)
    {
        $request->validate([
            'blood_type' => 'nullable|string',
            'allergies' => 'nullable|string',
            'medical_conditions' => 'nullable|string',
        ]);

        $user = Auth::user();
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


    public function sendWhatsApp($phone, $message)
    {
        $params = array(
            'token' => '4lymfep8kl3apijw',
            'instance_id' => 'instance165616',
            'to' => $phone,
            'body' => $message
        );

        // إرسال الطلب لـ UltraMsg
        $response = Http::post("https://api.ultramsg.com/{$params['instance_id']}/messages/chat", $params);

        return $response->successful();
    }
}