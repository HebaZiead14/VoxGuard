<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VoicePassword;
use App\Models\FakeCall;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class VoicePasswordController extends Controller
{
    /**
     * تسجيل بصمة الصوت وحفظ إعدادات الأمان (Enrollment)
     */
    public function store(Request $request)
    {
        // 1. التحقق من البيانات والملفات الصوتية
        $validator = Validator::make($request->all(), [
            'phrase' => 'required|string|min:2',
            'sensitivity' => 'required|integer|between:0,100',
            'timer_duration' => 'required|integer|between:1,60',
            'voice1' => 'required|file|mimes:wav,mp3,m4a',
            'voice2' => 'required|file|mimes:wav,mp3,m4a',
            'voice3' => 'required|file|mimes:wav,mp3,m4a',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation Error',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // استخدام الـ ID اللي ظهر في تجربتك بنجاح (13) أو المستخدم المسجل حالياً
            $currentUserId = Auth::id() ?? 13;

            // 2. إرسال الملفات لسيرفر الـ AI الخاص بعبد الحميد
            $aiUrl = 'https://cytoplasm-disburse-stardust.ngrok-free.dev/enroll';

            $aiResponse = Http::withHeaders([
                'ngrok-skip-browser-warning' => 'true'
            ])
                ->attach('audio_1', file_get_contents($request->file('voice1')), 'v1.wav')
                ->attach('audio_2', file_get_contents($request->file('voice2')), 'v2.wav')
                ->attach('audio_3', file_get_contents($request->file('voice3')), 'v3.wav')
                ->post($aiUrl, [
                    'user_id' => $currentUserId
                ]);

            if (!$aiResponse->successful()) {
                throw new \Exception('AI Server Error: ' . $aiResponse->body());
            }

            // استلام الـ Embedding من الـ AI
            $embedding = $aiResponse->json('embedding');

            // 3. حفظ البيانات في جدول voice_passwords
            $voice = VoicePassword::updateOrCreate(
                ['user_id' => $currentUserId],
                [
                    'phrase' => $request->phrase,
                    'sensitivity' => $request->sensitivity,
                    'timer_duration' => $request->timer_duration,
                    'embedding' => $embedding ? json_encode($embedding) : null
                ]
            );

            $voice->refresh();

            // 4. جدولة المكالمة الوهمية التلقائية
            FakeCall::updateOrCreate(
                ['user_id' => $currentUserId, 'status' => 'pending'],
                [
                    'caller_name' => 'Emergency Security',
                    'scheduled_at' => now()->addSeconds(5),
                    'ringtone' => 'Default Ringtone',
                    'status' => 'pending'
                ]
            );

            return response()->json([
                'status' => true,
                'message' => 'Voice Security Fully Activated!',
                'data' => [
                    'voice_settings' => $voice,
                    'ai_sync' => 'Success',
                    'fake_call' => 'Scheduled'
                ]
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'System Error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * عرض الإعدادات الحالية للمستخدم
     */
    public function show()
    {
        $userId = Auth::id() ?? 13;
        $voice = VoicePassword::where('user_id', $userId)->first();

        if (!$voice) {
            return response()->json([
                'status' => false,
                'message' => 'No settings found'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'data' => $voice
        ]);
    }

    /**
     * التحقق من الصوت وقت الخطر (Verification)
     */
    public function verify(Request $request)
    {
        // 1. استلام الريكورد الجديد من الموبايل
        $validator = Validator::make($request->all(), [
            'emergency_audio' => 'required|file|mimes:wav,mp3,m4a',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()], 422);
        }

        try {
            $currentUserId = Auth::id() ?? 13;

            // 2. جلب البصمة المسجلة مسبقاً من الداتا بيز
            $storedVoice = VoicePassword::where('user_id', $currentUserId)->first();

            if (!$storedVoice || !$storedVoice->embedding) {
                return response()->json(['status' => false, 'message' => 'No voice fingerprint found'], 404);
            }

            // 3. إرسال الصوت الجديد مع البصمة القديمة لسيرفر عبد الحميد
            $aiVerifyUrl = 'https://cytoplasm-disburse-stardust.ngrok-free.dev/verify'; // تأكدي من الرابط مع عبد الحميد
// جوه دالة verify في الـ Controller
            $aiResponse = Http::withHeaders(['ngrok-skip-browser-warning' => 'true'])
                ->attach('audio', file_get_contents($request->file('emergency_audio')), 'emergency.wav') // تأكدي الاسم هنا audio بس
                ->post($aiVerifyUrl, [
                    'stored_embedding' => json_decode($storedVoice->embedding), // ده الاسم اللي في الخريطة
                ]);

            if (!$aiResponse->successful()) {
                throw new \Exception('AI Verification Failed: ' . $aiResponse->body());
            }

            $isMatch = $aiResponse->json('match'); // الـ AI هيرد بـ true أو false

            // 4. الرد على تطبيق الموبايل بالأمر النهائي
            return response()->json([
                'status' => true,
                'match' => $isMatch,
                'trigger_sos' => $isMatch, // لو تطابق، اضرب سرينة فوراً
                'message' => $isMatch ? 'Identity Verified! Activating SOS...' : 'Voice does not match.'
            ]);

        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        }
    }
}