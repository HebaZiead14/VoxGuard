<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FakeCall;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class FakeCallController extends Controller
{
    public function schedule(Request $request)
    {
        // 1. التحقق من البيانات المرسلة
        $request->validate([
            'caller_name' => 'required|string',
            'minutes' => 'required|integer',
            'ringtone' => 'required|string',
            'voice_script' => 'nullable|string', // اختياري (mom, police, dad, general)
        ]);

        // 2. التحقق من التوكن (Authentication)
        if (!Auth::guard('sanctum')->check()) {
            return response()->json([
                'status' => false,
                'message' => 'User not authenticated.'
            ], 401);
        }

        // 3. تحديد ملف الصوت بناءً على الـ script المختار
        // الميزة هنا إننا هنخزن اسم الملف في العمود الجديد audio_path
        $voiceFile = 'general_script.mp3';

        if ($request->voice_script == 'mom') {
            $voiceFile = 'mom_call.mp3';
        } elseif ($request->voice_script == 'police') {
            $voiceFile = 'police_call.mp3';
        } elseif ($request->voice_script == 'dad') {
            $voiceFile = 'dad_call.mp3';
        }

        // 4. إنشاء المكالمة في قاعدة البيانات
        $fakeCall = FakeCall::create([
            'user_id' => Auth::guard('sanctum')->id(),
            'caller_name' => $request->caller_name,
            'scheduled_at' => now()->addMinutes($request->minutes),
            'ringtone' => $request->ringtone,
            'status' => 'pending',
            'voice_script' => $request->voice_script ?? 'general',
            'audio_path' => $voiceFile, // تخزين اسم الملف في العمود الجديد اللي عملناه في الميجريشن
        ]);

        // 5. إضافة روابط الملفات كاملة للـ Response
        // تأكدي إن الملفات مرفوعة في storage/app/public/recordings
        $fakeCall->voice_url = asset('storage/recordings/' . $voiceFile);
        $fakeCall->ringtone_url = asset('storage/audio/ringtones/' . $request->ringtone . '.mp3');

        return response()->json([
            'status' => true,
            'message' => "The fake call is scheduled for {$request->minutes} minutes later.",
            'data' => $fakeCall
        ]);
    }

    public function updateStatus(Request $request, $id)
    {
        try {
            $call = FakeCall::where('user_id', Auth::guard('sanctum')->id())->findOrFail($id);
            $call->update(['status' => 'completed']);

            return response()->json([
                'status' => true,
                'message' => 'Call status updated successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Call not found or unauthorized'
            ], 404);
        }
    }
}