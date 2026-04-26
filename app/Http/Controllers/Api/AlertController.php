<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TrustedContact;
use App\Models\AlertLog; 
use Illuminate\Support\Facades\Auth;

class AlertController extends Controller
{
    /**
     * إرسال استغاثة شاملة (Panic Button / AI / Sensors)
     */
    public function sendAlert(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['status' => false, 'message' => 'Unauthenticated'], 401);
        }

        // 1. التعديل الأول: ضمان الـ ID الصحيح (عشان الـ Null Error اللي واجهناه)
        $userId = $user->id ?? $user->user_id;

        // 2. التعديل الثاني: استقبال نوع المحفز (Trigger Type) 
        // عشان الـ Log يوضح هل الخطر من (Manual, Sentiment, Voice, or Trip)
        $triggerType = $request->trigger_type ?? 'Panic Button';

        if (isset($user->panic_button_enabled) && !$user->panic_button_enabled) {
            return response()->json([
                'status' => false,
                'message' => 'Alert could not be sent because Panic Button is disabled.'
            ], 403);
        }

        // 3. الموقع الجغرافي
        $lat = $request->lat ?? $request->latitude;
        $lng = $request->long ?? $request->longitude;
        $liveLocationUrl = "https://www.google.com/maps?q={$lat},{$lng}";

        // 4. جلب المنقذين بدقة
        $contacts = TrustedContact::where('user_id', $userId)->get()->unique('phone');

        if ($contacts->isEmpty()) {
            return response()->json(['status' => false, 'message' => 'No emergency contacts found.'], 404);
        }

        // 5. رسالة احترافية تحتوي على المصدر (Source) والبيانات الطبية
        $messageBody = "🚨 *VoxGuard Emergency Alert!* 🚨\n\n";
        $messageBody .= "👤 User: *{$user->first_name} {$user->last_name}*\n";
        $messageBody .= "⚠️ Source: *{$triggerType}*\n";
        $messageBody .= "🩸 Blood Type: *{$user->blood_type}*\n";
        $messageBody .= "📍 Track Location: {$liveLocationUrl}";

        // 6. الإرسال الفعلي
        foreach ($contacts as $contact) {
            $this->sendWhatsAppViaUltraMsg($contact->phone, $messageBody);
        }

        // 7. تحديث حالة المستخدم وتسجيل اللوج
        $user->update(['is_in_danger' => true]);

        AlertLog::create([
            'user_id' => $userId,
            'lat' => $lat,
            'long' => $lng,
            'status' => "Emergency triggered via {$triggerType}"
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Emergency mode activated. Alert sent to contacts.',
            'source' => $triggerType,
            'sos_status' => 'Active'
        ], 200);
    }

    /**
     * عرض سجل الاستغاثات (Alert History)
     */
    public function history()
    {
        $user = Auth::user();
        $userId = $user->id ?? $user->user_id;

        $history = AlertLog::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        return response()->json([
            'status' => true,
            'history' => $history
        ], 200);
    }

    /**
     * دالة الإرسال الموحدة (استخدمنا الـ Instance والـ Token بتوعك)
     */
    private function sendWhatsAppViaUltraMsg($phone, $message)
    {
        $instanceId = "instance171200"; 
        $token = "1bajiprv1swk00sy"; 
        $url = "https://api.ultramsg.com/{$instanceId}/messages/chat";

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
        
        return $response;
    }
}