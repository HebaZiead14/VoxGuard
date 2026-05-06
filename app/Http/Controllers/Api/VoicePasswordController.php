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
     * 1. مرحلة التسجيل (Enrollment)
     * الغرض: إرسال 3 ملفات للـ AI لجلب البصمة (Embedding) وحفظ الإعدادات محلياً.
     */
    public function store(Request $request)
    {
        // التحقق من البيانات والملفات الصوتية (Validation)
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
            // تحديد الـ User ID (استخدام 13 للتجربة أو المستخدم الحالي)
            $currentUserId = Auth::id() ?? 13;

            // رابط سيرفر عبد الحميد (تأكدي من تحديثه دائماً من ngrok)
            $aiUrl = 'http://127.0.0.1:5000/enroll';

            // إرسال الملفات الـ 3 فقط للـ AI كما هو مطلوب
            $aiResponse = Http::withHeaders([
                'ngrok-skip-browser-warning' => 'true'
            ])
                ->timeout(120) // زيادة الوقت لمعالجة الملفات الكبيرة
                ->attach('audio_1', file_get_contents($request->file('voice1')), 'v1.wav')
                ->attach('audio_2', file_get_contents($request->file('voice2')), 'v2.wav')
                ->attach('audio_3', file_get_contents($request->file('voice3')), 'v3.wav')
                ->post($aiUrl, [
                    'user_id' => $currentUserId // نبعت الـ ID عشان الـ AI يسجله عنده
                ]);

            if (!$aiResponse->successful()) {
                throw new \Exception('AI Server Error: ' . $aiResponse->body());
            }

            // استلام الـ Embedding من الـ AI واستخراج البيانات
            $embedding = $aiResponse->json('ai_response.embedding') ?? $aiResponse->json('embedding');

            // حفظ كل البيانات في جدولك (التوثيق اللي الدكتورة عايزاه)
            $voice = VoicePassword::updateOrCreate(
                ['user_id' => $currentUserId],
                [
                    'phrase' => $request->phrase,
                    'sensitivity' => $request->sensitivity,
                    'timer_duration' => $request->timer_duration,
                    'embedding' => $embedding ? json_encode($embedding) : null
                ]
            );

            return response()->json([
                'status' => true,
                'message' => 'Voice Security Profile Created Successfully!',
                'data' => $voice
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'System Error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * 2. مرحلة التحقق وقت الخطر (Verification)
     * الغرض: إرسال الـ User ID والملف الجديد للـ AI لمعرفة هل هو نفس الشخص أم لا.
     */
    public function verify(Request $request)
    {
        // 1. التحقق من البيانات المرسلة من تطبيق فلاتر (أميرة)
        $validator = Validator::make($request->all(), [
            'emergency_audio' => 'required|file|mimes:wav,mp3,m4a',
            'user_id' => 'nullable' // اختياري لتسهيل التجربة من Postman
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()], 422);
        }

        try {
            // 2. تحديد المعرف الخاص بالمستخدم
            $currentUserId = $request->user_id ?? (Auth::id() ?? 28);

            // 3. جلب بصمة الصوت المخزنة في قاعدة البيانات لهذا المستخدم
            $storedVoice = \App\Models\VoicePassword::where('user_id', $currentUserId)->first();

            if (!$storedVoice || !$storedVoice->embedding) {
                return response()->json([
                    'status' => false,
                    'message' => 'No voice profile found for this user. Please enroll first.'
                ], 404);
            }

            // 4. تعريف رابط سيرفر الـ AI (يجب تحديثه عند كل تشغيل لـ ngrok)
            $aiVerifyUrl = 'http://127.0.0.1:5000/verify';
            // 5. إرسال ملف الصوت والبصمة المخزنة لسيرفر عبد الحميد (AI)
            // ملاحظة: أرسلنا الـ embedding كما هو (String) بناءً على طلب فريق الـ AI للتوافق
            $aiResponse = Http::withHeaders([
                'ngrok-skip-browser-warning' => 'true'
            ])
                ->timeout(60)
                ->attach('audio', file_get_contents($request->file('emergency_audio')), 'emergency.wav')
                ->post($aiVerifyUrl, [
                    'user_id' => (string) $currentUserId,
                    'embedding' => $storedVoice->embedding,
                ]);

            // التحقق من نجاح الاتصال بسيرفر الـ AI
            if (!$aiResponse->successful()) {
                throw new \Exception('AI Verification Failed: ' . $aiResponse->body());
            }

            $result = $aiResponse->json();
            $isMatch = $result['match'] ?? false;

            // 6. الرد النهائي لتطبيق فلاتر لتفعيل حالة الطوارئ (SOS)
            return response()->json([
                'status' => true,
                'match' => $isMatch,
                'trigger_sos' => $isMatch,
                'ai_score' => $result['score'] ?? 0,
                'message' => $isMatch ? 'Identity Confirmed. SOS Triggered!' : 'Identity Mismatch.'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'System Error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * 3. عرض البيانات (للتأكد من التخزين)
     */
    public function show()
    {
        $userId = Auth::id() ?? 13;
        $voice = VoicePassword::where('user_id', $userId)->first();

        if (!$voice) {
            return response()->json(['status' => false, 'message' => 'No settings found'], 404);
        }

        return response()->json(['status' => true, 'data' => $voice]);
    }
}



// $aiVerifyUrl = 'https://cytoplasm-disburse-stardust.ngrok-free.dev/verify';
// $aiUrl = 'https://cytoplasm-disburse-stardust.ngrok-free.dev/enroll';
