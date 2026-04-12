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
    
    public function start(Request $request)
    {
        $request->validate([
            'latitude' => 'required',
            'longitude' => 'required',
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
            'message' => 'تم بدء الاستغاثة، جاري رفع التسجيل الصوتي...',
            'sos_id' => $sos->id
        ]);
    }
    /**
     * 2. دالة تحديث الموقع وفحص المناطق التلقائية
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

        $automaticZones = \App\Models\GlobalZone::all();
        foreach ($automaticZones as $zone) {
            $distance = $this->calculateDistance($request->latitude, $request->longitude, $zone->latitude, $zone->longitude);

            if ($zone->type == 'danger' && $distance <= $zone->radius) {
                $alertMessage = "⚠️ *تنبيه تلقائي من VoxGuard* ⚠️\n\n";
                $alertMessage .= "بنتكم دخلت الآن منطقة مصنفة (خطيرة): *{$zone->name}*";

                $this->broadcastToAll($user, $alertMessage);
                break;
            }
        }

        return response()->json(['status' => true, 'message' => 'تم تحديث الموقع وفحص المناطق التلقائية']);
    }

    /**
     * 3. دالة رفع الصوت (تم إعادتها للعمل لإنهاء خطأ 500)
     */
    // public function uploadAudio(Request $request, $id)
    // {
    //     $request->validate([
    //         'audio_file' => 'required|file|max:20480',
    //     ]);

    //     $sos = SosAlert::findOrFail($id);
    //     $user = Auth::user();

    //     if ($request->hasFile('audio_file')) {
    //         // حفظ الملف بالاسم المحجوز مسبقاً في دالة start
    //         $path = $request->file('audio_file')->storeAs('recordings', "sos_{$id}.mp3", 'public');
    //         $audioUrl = asset(Storage::url($path));

    //         $sos->update(['audio_url' => $audioUrl]);

    //         $message = "🎤 *VoxGuard - تم رفع التسجيل الصوتي بنجاح*:\n";
    //         $message .= "للاستماع: {$audioUrl}";

    //         $this->broadcastToAll($user, $message);

    //         return response()->json(['status' => true, 'audio_url' => $audioUrl]);
    //     }
    // }
    public function uploadAudio(Request $request, $id)
    {
        $request->validate([
            'audio_file' => 'required|mimes:mp3,mp4,wav,aac,m4a|max:10000',
        ]);

        $sos = SosAlert::findOrFail($id);
        $user = Auth::user();

        if ($request->hasFile('audio_file')) {
            // حفظ الملف باسم الاستغاثة
            $path = $request->file('audio_file')->storeAs('recordings', "sos_{$id}.mp3", 'public');

            // تجهيز الرابط النهائي
            $audioUrl = "https://lesia-danceable-nettly.ngrok-free.dev/storage/recordings/sos_{$id}.mp3?ngrok-skip-browser-warning=1";
            $mapLink = "https://www.google.com/maps?q={$sos->latitude},{$sos->longitude}";

            $triggerText = ($sos->trigger_type == 'ai_voice') ? "🚨 خطر (تحليل صوتي)" :
                (($sos->trigger_type == 'voice_password') ? "كلمة سر صوتية" : "ضغط يدوي");

            // بناء الرسالة الشاملة "الواحدة"
            $message = "🚨 *تنبيه استغاثة VoxGuard* 🚨\n\n";
            $message .= " المستغيثة: *{$user->name}*\n";
            $message .= " السبب: *{$triggerText}*\n";

            $message .= "\n🏥 *الملف الطبي*:\n";
            $message .= "• فصيلة الدم: *" . ($user->blood_type ?? 'O+') . "*\n";
            $message .= "• الحساسية: *" . ($user->allergies ?? 'لا يوجد') . "*\n";
            $message .= "• أمراض مزمنة: *" . ($user->medical_conditions ?? 'سليمة') . "*\n";

            $message .= "\n📍 *الموقع الحالي*:\n{$mapLink}\n";
            $message .= "\n🎙️ *استمع للتسجيل الصوتي المباشر*:\n{$audioUrl}";

            // إرسال الرسالة الشاملة الآن
            $this->broadcastToAll($user, $message);

            return response()->json([
                'status' => true,
                'message' => 'تم رفع التسجيل وإرسال الاستغاثة الشاملة للأهل',
                'audio_url' => $audioUrl
            ]);
        }
    }

    /**
     * 4. دالة رفع الفيديو
     */
    // public function uploadVideo(Request $request, $id)
    // {
    //     $request->validate([
    //         'video_file' => 'required|file|mimetypes:video/mp4,video/quicktime|max:51200',
    //     ]);

    //     $sos = SosAlert::findOrFail($id);
    //     $user = Auth::user();

    //     if ($request->hasFile('video_file')) {
    //         $path = $request->file('video_file')->store('videos', 'public');
    //         $videoUrl = asset(Storage::url($path));

    //         $message = "🎥 *VoxGuard - تسجيل فيديو مباشر من الموقع*:\n";
    //         $message .= "اضغط للمشاهدة: {$videoUrl}";

    //         $this->broadcastToAll($user, $message);

    //         return response()->json(['status' => true, 'video_url' => $videoUrl]);
    //     }
    // }

    /**
     * 5. دالة إيقاف الاستغاثة
     */
    public function stop(Request $request, $id)
    {
        $sos = SosAlert::findOrFail($id);
        $user = Auth::user();

        $sos->update(['status' => 'resolved']);

        $message = "✅ *VoxGuard - إشارة أمان* ✅\n\n";
        $message .= "المستخدمة *{$user->name}* بخير الآن وتم إنهاء حالة الطوارئ.";

        $this->broadcastToAll($user, $message);

        return response()->json(['status' => true, 'message' => 'تم إنهاء الاستغاثة بنجاح']);
    }

    /**
     * 6. دالة البث الجماعي
     */
    private function broadcastToAll($user, $message)
    {
        $emergencyPhones = $user->emergencyContacts ? $user->emergencyContacts->pluck('phone') : collect();
        $trustedPhones = TrustedContact::where('user_id', $user->user_id)->pluck('phone');

        $uniquePhones = $emergencyPhones->merge($trustedPhones)->unique()->filter();

        foreach ($uniquePhones as $phone) {
            $this->sendWhatsApp($phone, $message);
        }
    }

    /**
     * 7. دالة إرسال واتساب عبر UltraMsg
     */
    private function sendWhatsApp($phone, $message)
    {
        $instanceId = "163774";
        $token = "sgb4t90qrh0wm9qo";
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

        echo "\n --- UltraMsg Response for ($phone): " . $response . " ---\n";
    }

    /**
     * 8. دالة حساب المسافة للمناطق التلقائية
     */
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