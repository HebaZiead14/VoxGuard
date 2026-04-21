<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Http;
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

    // ---------------- 3. Social Login (جوجل وفيسبوك) ----------------
    public function socialLogin(Request $request)
    {
        $request->validate([
            'social_id' => 'required|string',
            'social_type' => 'required|in:google,facebook',
            'email' => 'required|email',
            'first_name' => 'nullable|string',
            'last_name' => 'nullable|string',
        ]);

        $column = $request->social_type == 'google' ? 'google_id' : 'facebook_id';
        $user = User::where($column, $request->social_id)->first();

        if (!$user) {
            $user = User::where('email', $request->email)->first();

            if ($user) {
                $user->update([$column => $request->social_id]);
            } else {
                $user = User::create([
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'email' => $request->email,
                    'password' => Hash::make(Str::random(16)),
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

        if (filter_var($request->email_or_phone, FILTER_VALIDATE_EMAIL)) {
            try {
                Mail::raw("كود التحقق الخاص بك هو: {$otp}", function ($message) use ($user) {
                    $message->to($user->email)->subject('إعادة تعيين كلمة المرور - VoxGuard');
                });
                $status_message = 'OTP sent to your email successfully';
            } catch (\Exception $e) {
                return response()->json(['status' => false, 'message' => 'Email Error: ' . $e->getMessage()], 500);
            }
        } else {
            try {
                $sent = $this->sendWhatsApp($user->phone_number, "كود التحقق الخاص بك هو: {$otp}");
                if ($sent) {
                    $status_message = 'OTP sent to your WhatsApp successfully';
                } else {
                    throw new \Exception("UltraMsg Service Error");
                }
            } catch (\Exception $e) {
                return response()->json(['status' => false, 'message' => 'WhatsApp Error: ' . $e->getMessage()], 500);
            }
        }

        return response()->json([
            'status' => true,
            'message' => $status_message,
            'otp' => $otp
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
        if ($user) {
            $user->update(['password' => Hash::make($request->password)]);
            DB::table('password_reset_tokens')->where('email', $request->email)->delete();
            return response()->json(['status' => true, 'message' => 'Password reset successfully']);
        }

        return response()->json(['status' => false, 'message' => 'User not found'], 404);
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
            'user' => Auth::user()
        ], 200);
    }

    // ---------------- 8. Update Emergency Info ----------------
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

    //-------------------------------------------------------
    public function updateLiveLocation(Request $request)
    {
        // فلاتر بيبعت الأرقام دي من الـ GPS بتاع الموبايل
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $user = Auth::user();
        $user->update([
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'last_seen' => now() // تحديث الوقت لـ "الآن"
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Your location and status are now live.'
        ]);
    }
    //     // ---------------- مساعد إرسال واتساب ----------------
//     private function sendWhatsApp($phone, $message)
//     {
//         $params = [
//             'token' => '1bajiprv1swk00sy',
//             'instance_id' => 'instance171200',
//             'to' => $phone,
//             'body' => $message
//         ];
//         $response = Http::post("https://api.ultramsg.com/instance171200//messages/chat", $params);



    //         return $response->successful();
//     }
// }


    private function sendWhatsApp($phone, $message)
    {
        $params = [
            'token' => '1bajiprv1swk00sy',
            'to' => $phone,
            'body' => $message
        ];

        // الرابط المظبوط لخدمة UltraMsg
        $response = Http::post("https://api.ultramsg.com/instance171200/messages/chat", $params);

        return $response->successful();
    }
}

//------------------------------------------------------------------
