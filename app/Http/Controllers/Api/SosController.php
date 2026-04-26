<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SosAlert;
use App\Models\TrustedContact;
use App\Models\Zone; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class SosController extends Controller
{
    /**
     * 1. بدء الاستغاثة (معدل لاستقبال تحليل المشاعر)
     */
    public function start(Request $request)
    {
        $request->validate([
            'latitude' => 'nullable', 
            'longitude' => 'nullable',
            // أضفنا sentiment_analysis كنوع محفز جديد
            'trigger_type' => 'required|in:manual,ai_voice,voice_password,sentiment_analysis',
            'emotion' => 'nullable|string' // استقبال حالة المشاعر (Input 2 من طلب الدكتورة)
        ]);

        $user = Auth::user();
        $userId = $user->id ?? $user->user_id;

        // فحص لو الموقع الحالي في منطقة خطر
        $zoneStatus = 'normal';
        if ($request->latitude && $request->longitude) {
            $dangerZone = Zone::where('type', 'high_alert')->get()->filter(function($zone) use ($request) {
                return $this->calculateDistance($request->latitude, $request->longitude, $zone->latitude, $zone->longitude) <= $zone->radius;
            })->first();
            
            if ($dangerZone) $zoneStatus = 'danger_zone';
        }

        // إنشاء التنبيه مع تخزين حالة المشاعر إذا وجدت
        $sos = SosAlert::create([
            'user_id' => $userId,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'trigger_type' => $request->trigger_type,
            'status' => 'active',
            'zone_status' => $zoneStatus,
            'emotion_state' => $request->emotion // حفظ الحالة (خايف، حزين، صراخ)
        ]);

        return response()->json([
            'status' => true,
            'message' => 'تم بدء الاستغاثة بنجاح',
            'sos_id' => $sos->id,
            'trigger' => $request->trigger_type,
            'emotion_detected' => $request->emotion,
            'in_danger_zone' => ($zoneStatus == 'danger_zone')
        ]);
    }

    /**
     * 2. تحديث الموقع الحي (لا تغيير)
     */
    public function updateLocation(Request $request, $id)
    {
        $request->validate(['latitude' => 'required', 'longitude' => 'required']);
        $sos = SosAlert::findOrFail($id);
        $user = Auth::user();

        $sos->update(['latitude' => $request->latitude, 'longitude' => $request->longitude]);

        if ($sos->status == 'active') {
            $liveTrackingUrl = url("/sos/track/{$id}");
            $message = "🚨 *تنبيه موقع VoxGuard* 🚨\n";
            $message .= "👤 المستغيثة: *{$user->first_name}*\n";
            $message .= "📍 *رابط التتبع الحي*:\n🔗 {$liveTrackingUrl}";

            $this->broadcastToAll($user, $message);
            $sos->update(['status' => 'processing']);
        }

        return response()->json(['status' => true]);
    }

    /**
     * 3. رفع الصوت وإرسال الرسالة الشاملة (Input 1 من طلب الدكتورة)
     */
    public function uploadAudio(Request $request, $id)
    {
        $sos = SosAlert::findOrFail($id);
        $user = Auth::user();

        // استقبال ورفع الملف الصوتي (Record)
        $audioUrl = null;
        if ($request->hasFile('audio_file')) {
            // حفظ الملف في السيرفر (Path)
            $path = $request->file('audio_file')->storeAs('recordings', "sos_{$id}_evidence.mp3", 'public');
            
            // إضافة معامل لتخطي تحذير ngrok كما في الكود السابق
            $audioUrl = asset('storage/' . $path) . "?ngrok-skip-browser-warning=1";
            
            // تحديث المسار في قاعدة البيانات كدليل (Evidence)
            $sos->update(['audio_path' => $path]);
        }

        $liveTrackingUrl = url("/sos/track/{$id}");

        // بناء الرسالة النهائية الشاملة (اسم + بيانات طبية + حالة مشاعر + صوت)
        $message = "🚨 *نداء استغاثة شامل من VoxGuard* 🚨\n\n";
        $message .= "👤 الاسم: *{$user->first_name} {$user->last_name}*\n";
        $message .= "🩸 فصيلة الدم: *{$user->blood_type}*\n";
        
        // إظهار حالة المشاعر في الرسالة إذا كان التنبيه ذكياً
        if ($sos->emotion_state) {
            $message .= "🧠 تحليل المشاعر: *{$sos->emotion_state}*\n";
        }

        if ($user->emergency_question) {
            $message .= "❓ *سؤال الطوارئ*: {$user->emergency_question}\n";
            $message .= "🔑 *الإجابة*: {$user->emergency_answer}\n";
        }

        if ($sos->latitude) {
            $message .= "\n📍 *تتبع الموقع*:\n{$liveTrackingUrl}\n";
        }

        if ($audioUrl) {
            $message .= "\n🎙️ *التسجيل الصوتي كدليل*:\n{$audioUrl}";
        }

        $this->broadcastToAll($user, $message);
        $sos->update(['status' => 'notified']);

        return response()->json([
            'status' => true, 
            'audio_url' => $audioUrl,
            'emotion' => $sos->emotion_state
        ]);
    }

    /**
     * 4. إنهاء الاستغاثة (لا تغيير)
     */
    public function stop(Request $request, $id)
    {
        $sos = SosAlert::findOrFail($id);
        $user = Auth::user();
        $sos->update(['status' => 'resolved']);

        $message = "✅ *VoxGuard - إشارة أمان* ✅\n";
        $message .= "المستخدمة *{$user->first_name}* بخير الآن.";

        $this->broadcastToAll($user, $message);
        return response()->json(['status' => true]);
    }

    private function broadcastToAll($user, $message)
    {
        $userId = $user->id ?? $user->user_id;
        $trustedPhones = TrustedContact::where('user_id', $userId)->pluck('phone');
        foreach ($trustedPhones as $phone) {
            $this->sendWhatsApp($phone, $message);
        }
    }

    private function sendWhatsApp($phone, $message)
    {
        $params = [
            'token' => '1bajiprv1swk00sy',
            'to' => $phone,
            'body' => $message
        ];
        
        $url = "https://api.ultramsg.com/instance171200/messages/chat";
        
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query($params),
        ]);
        curl_exec($curl);
        curl_close($curl);
    }

    private function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371000;
        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);
        $a = sin($dLat / 2) * sin($dLat / 2) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLon / 2) * sin($dLon / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        return $earthRadius * $c;
    }
}