<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    // 1. جلب بيانات البروفايل (عشان شاشة الـ Profile الرئيسية)
    public function show()
    {
        $user = Auth::user();
        return response()->json([
            'status' => true,
            'data' => [
                'full_name' => $user->first_name . ' ' . $user->last_name,
                'email' => $user->email,
                'phone' => $user->phone_number,
                'profile_image' => $user->profile_image,
                'emergency_info' => [
                    'blood_type' => $user->blood_type,
                    'allergies' => $user->allergies,
                    'medical_conditions' => $user->medical_conditions,
                ]
            ]
        ]);
    }

    // 2. تحديث بيانات البروفايل ورفع الصورة (عشان شاشة Edit Profile)
    public function update(Request $request)
    {
        $user = Auth::user();

        $data = $request->validate([
            'first_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'phone_number' => 'nullable|string',
            'blood_type' => 'nullable|string',
            'allergies' => 'nullable|string',
            'medical_conditions' => 'nullable|string',
            'profile_image' => 'nullable|image|mimes:jpg,png,jpeg|max:2048'
        ]);

        // التعامل مع رفع الصورة وتحديث الرابط
        if ($request->hasFile('profile_image')) {
            // حذف الصورة القديمة إذا كانت موجودة لتوفير المساحة
            if ($user->profile_image) {
                $oldPath = str_replace(asset('storage/'), '', $user->profile_image);
                Storage::disk('public')->delete($oldPath);
            }
            
            $path = $request->file('profile_image')->store('profiles', 'public');
            $data['profile_image'] = asset('storage/' . $path);
        }

        $user->update($data);

        return response()->json([
            'status' => true,
            'message' => 'Profile updated successfully!',
            'user' => $user
        ]);
    }

    public function activityLog()
{
    try {
        $user_id = auth()->id();

        // التأكد من القراءة من جدول sos_alerts اللي ظهر في phpMyAdmin
        $sos = \DB::table('sos_alerts')
            ->where('user_id', $user_id)
            ->select('created_at', \DB::raw("'SOS Event Triggered' as title"), \DB::raw("'Alert sent to emergency contacts' as description"))
            ->get();

        // سجل المكالمات الوهمية (تأكدي أن اسم الجدول fake_calls كما في الصورة)
        $fakeCalls = \DB::table('fake_calls')
            ->where('user_id', $user_id)
            ->select('created_at', \DB::raw("'Fake Call Initiated' as title"), \DB::raw("'Scheduled fake call received successfully' as description"))
            ->get();

        // دمج وترتيب
        $allLogs = $sos->concat($fakeCalls)->sortByDesc('created_at')->values();

        return response()->json([
            'status' => true,
            'logs' => $allLogs
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => false,
            'message' => 'Error: ' . $e->getMessage()
        ], 500);
    }
}
}