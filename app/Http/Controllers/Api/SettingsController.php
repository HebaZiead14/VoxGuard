<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class SettingsController extends Controller
{
    /**
     * 1. تحديث الزراير (Fake Call, Panic Button, Notifications, Voice Password)
     * هذا الروت يتحكم في تفعيل أو تعطيل المميزات الذكية
     */
    public function updateToggles(Request $request)
    {
        $user = Auth::user();
        
        // التحقق من البيانات المرسلة
        $data = $request->validate([
            'fake_call_enabled'      => 'nullable|boolean',
            'panic_button_enabled'   => 'nullable|boolean', // خاصية ضغطتين زر الباور
            'notifications_enabled'  => 'nullable|boolean',
            'voice_password_enabled' => 'nullable|boolean', // خاصية تفعيل كلمة السر الصوتية
        ]);

        $user->update($data);
        
        return response()->json([
            'status' => true, 
            'message' => 'Security settings updated successfully'
        ]);
    }

    /**
     * 2. شاشة اللغة (Language)
     * تغيير لغة التطبيق بناءً على القائمة المختارة في الـ UI
     */
    public function changeLanguage(Request $request)
    {
        $request->validate([
            'language' => 'required|string|in:English,French,Portuguese,Korea,Russia,China,Egypt'
        ]);

        Auth::user()->update(['language' => $request->language]);
        return response()->json(['status' => true, 'message' => 'Language changed successfully']);
    }

    /**
     * 3. شاشة تغيير الباسورد (Change Password)
     * التحقق من الباسورد القديم وتشفير الجديد
     */
    public function changePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:8|confirmed', // يتطلب حقل new_password_confirmation
        ]);

        $user = Auth::user();
        if (!Hash::check($request->old_password, $user->password)) {
            return response()->json(['status' => false, 'message' => 'Current password incorrect'], 400);
        }

        $user->update(['password' => Hash::make($request->new_password)]);
        return response()->json(['status' => true, 'message' => 'Password changed successfully']);
    }

    /**
     * 4. حذف الحساب (Delete Account)
     * مسح التوكينات والبيانات نهائياً من السيستم
     */
    public function deleteAccount()
    {
        try {
            $user = Auth::user();

            // مسح التوكينات لضمان الخروج من جميع الأجهزة
            $user->tokens()->delete();

            // حذف اليوزر نهائياً
            $user->delete();

            return response()->json([
                'status' => true,
                'message' => 'Account deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * 5. تسجيل الخروج (Log out)
     * إلغاء صلاحية التوكين الحالي فقط
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'status' => true,
            'message' => 'Logged out successfully'
        ]);
    }
}