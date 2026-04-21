<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SosAlert;
use App\Models\TrustedContact;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SosController extends Controller
{
    /**
     * 1. بدء الاستغاثة
     */
    public function start(Request $request)
    {
        $request->validate([
            'latitude' => 'nullable', // خليناها nullable عشان لو البنت قافلة مشاركة الموقع
            'longitude' => 'nullable',
            'trigger_type' => 'required|in:manual,ai_voice,voice_password'
        ]);

        $user = Auth::user();

        $sos = SosAlert::create([
            'user_id' => $user->user_id,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'trigger_type' => $request->trigger_type,
            'status' => 'active'
        ]);

        return response()->json([
            'status' => true,
            'message' => 'تم بدء الاستغاثة، جاري معالجة البيانات...',
            'sos_id' => $sos->id
        ]);
    }

    /**
     * 2. تحديث الموقع الحي (Live Update)
     */
    public function updateLocation(Request $request, $id)
    {
        $request->validate([
            'latitude' => 'required',
            'longitude' => 'required',
        ]);

        $sos = SosAlert::findOrFail($id);
        $user = Auth::user();

        $sos->update([
            'latitude' => $request->latitude,
            'longitude' => $request->longitude
        ]);

        // --- إضافة: إرسال واتساب فوراً باللوكيشن حتى لو مفيش صوت ---
        if ($sos->status == 'active') {
            $liveTrackingUrl = url("/sos/track/{$id}");
            $message = "🚨 *تنبيه موقع VoxGuard* 🚨\n\n";
            $message .= "👤 المستغيثة: *{$user->first_name}*\n";
            $message .= "📍 *رابط التتبع الحي*:\n🔗 {$liveTrackingUrl}";

            // بنبعت الرسالة
            $this->broadcastToAll($user, $message);

            // بنغير الحالة لـ processing عشان ما يبعتش واتساب مع كل خطوة (زحمة)
            $sos->update(['status' => 'notified']);
        }

        return response()->json(['status' => true, 'message' => 'تم تحديث الموقع وإرسال التنبيه']);
    }

    /**
     * 3. رفع الصوت وإرسال الرسالة الشاملة (تدعم تفعيل/تعطيل الميزات)
     */
    public function uploadAudio(Request $request, $id)
    {
        // 1. التأكد من وجود ملف (اختياري حسب رغبة اليوزر)
        if ($request->hasFile('audio_file')) {
            $request->validate([
                'audio_file' => 'mimes:mp3,mp4,wav,aac,m4a|max:10000',
            ]);
        }

        $sos = SosAlert::findOrFail($id);
        $user = Auth::user();

        $audioUrl = null;
        if ($request->hasFile('audio_file')) {
            $path = $request->file('audio_file')->storeAs('recordings', "sos_{$id}.mp3", 'public');
            $audioUrl = url(\Storage::url($path)) . "?ngrok-skip-browser-warning=1";
            $sos->update(['audio_path' => $path]); // حفظ المسار في الداتا بيز
        }

        $liveTrackingUrl = url("/sos/track/{$id}");

        // 2. بناء الرسالة (بتاخد المتاح حالياً)
        $message = "🚨 *تنبيه استغاثة VoxGuard* 🚨\n\n";
        $message .= "👤 المستغيثة: *{$user->first_name} {$user->last_name}*\n";

        // لو فيه لوكيشن مبعوث قبل كدة أو دلوقتي
        if ($sos->latitude && $sos->longitude) {
            $message .= "\n📍 *رابط التتبع الحي*:\n🔗 {$liveTrackingUrl}\n";
        }

        // لو فيه صوت ارفع دلوقتي
        if ($audioUrl) {
            $message .= "\n🎙️ *التسجيل الصوتي*:\n🔗 {$audioUrl}";
        }

        // 3. إرسال الواتساب
        $this->broadcastToAll($user, $message);

        // تحديث الحالة عشان السيستم يعرف إننا بلغنا الأهل خلاص
        $sos->update(['status' => 'notified']);

        return response()->json([
            'status' => true,
            'message' => 'تم رفع الصوت وإرسال التنبيه بنجاح',
            'audio_url' => $audioUrl
        ]);
    }
    /**
     * 4. إنهاء الاستغاثة
     */
    public function stop(Request $request, $id)
    {
        $sos = SosAlert::findOrFail($id);
        $user = Auth::user();

        $sos->update(['status' => 'resolved']);

        $message = "✅ *VoxGuard - إشارة أمان* ✅\n\n";
        $message .= "المستخدمة *{$user->first_name}* بخير الآن وتم إنهاء حالة الطوارئ.";

        $this->broadcastToAll($user, $message);

        return response()->json(['status' => true, 'message' => 'تم إنهاء الاستغاثة بنجاح']);
    }

    /**
     * 5. عرض صفحة الخريطة للأهل
     */
    public function showMap($id)
    {
        $sos = SosAlert::with('user')->findOrFail($id);
        return view('track', compact('sos'));
    }

    private function broadcastToAll($user, $message)
    {
        $emergencyPhones = $user->emergencyContacts ? $user->emergencyContacts->pluck('phone') : collect();
        $trustedPhones = TrustedContact::where('user_id', $user->user_id)->pluck('phone');

        $uniquePhones = $emergencyPhones->merge($trustedPhones)->unique()->filter();

        foreach ($uniquePhones as $phone) {
            $this->sendWhatsApp($phone, $message);
        }
    }

    private function sendWhatsApp($phone, $message)
    {
        $instanceId = "171200";
        $token = "1bajiprv1swk00sy";
        $url = "https://api.ultramsg.com/instance" . $instanceId . "/messages/chat";

        $params = [
            'token' => $token,
            'to' => $phone,
            'body' => $message,
            'priority' => 10
        ];

        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query($params),
        ]);

        $response = curl_exec($curl);
        curl_close($curl);
        error_log("\n --- UltraMsg Response: " . $response);
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