<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TrustedContact;
use App\Models\AlertLog; // استدعاء موديل السجل
use Illuminate\Support\Facades\Auth;

class AlertController extends Controller
{
    /**
     * إرسال استغاثة لجميع المنقذين وتسجيلها في السجل
     * هذا الروت يتم مناداته بعد انتهاء مؤقت الـ 5 ثواني (سواء من AI أو Panic Button)
     * يرسل رسالة واتساب واحدة تحتوي على رابط المتابعة الحية
     */
    public function sendAlert(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['status' => false, 'message' => 'Unauthenticated'], 401);
        }

        // 1. التحقق من تفعيل ميزة الـ Panic Button من الإعدادات قبل التنفيذ
        if (isset($user->panic_button_enabled) && !$user->panic_button_enabled) {
            return response()->json([
                'status' => false,
                'message' => 'Alert could not be sent because Panic Button is disabled in settings.'
            ], 403);
        }

        // 2. استقبال اللوكيشن وتجهيز رابط المتابعة الحية (Live Location)
        $lat = $request->lat ?? $request->latitude;
        $lng = $request->long ?? $request->longitude;

        // الرابط التجريبي لجوجل ماب (Static) - يمكن استبداله بالرابط الحي لاحقاً
        $liveLocationUrl = "https://www.google.com/maps?q={$lat},{$lng}";

        // 3. جلب المنقذين المرتبطين باليوزر (Emergency + Trusted)
        $contacts = TrustedContact::where('user_id', $user->user_id)->get()->unique('phone');

        if ($contacts->isEmpty()) {
            return response()->json([
                'status' => false,
                'message' => 'No emergency contacts found.'
            ], 404);
        }

        // 4. تحضير رسالة الاستغاثة الموحدة
        $messageBody = "🚨 *VoxGuard Live Alert!* 🚨\n";
        $messageBody .= "Emergency from: *{$user->name}*!\n";
        $messageBody .= "I am in danger, track my location here:\n" . $liveLocationUrl;

        // 5. الإرسال لجميع الجهات المسجلة عبر WhatsApp
        foreach ($contacts as $contact) {
            $this->sendWhatsAppViaUltraMsg($contact->phone, $messageBody);

            // رابط الإرسال اليدوي كخطة بديلة
            $encodedMessage = urlencode($messageBody);
            $contact->whatsapp_manual_link = "https://wa.me/" . str_replace(['+', ' '], '', $contact->phone) . "?text={$encodedMessage}";
        }

        // 6. تحديث حالة المستخدم في السيرفر ليكون "In Danger" لتفعيل الـ SOS والـ AI
        $user->update(['is_in_danger' => true]);

        // 7. تسجيل الاستغاثة في الـ Alert Logs (History)
        AlertLog::create([
            'user_id' => $user->user_id,
            'lat' => $lat,
            'long' => $lng,
            'status' => 'Live Alert Triggered via Panic Button'
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Emergency mode activated. Alert sent to contacts.',
            'live_tracking_url' => $liveLocationUrl,
            'sos_status' => 'Active',
            'data' => $contacts
        ], 200);
    }

    /**
     * عرض سجل الاستغاثات الخاص بالمستخدم (Alert History)
     */
    public function history()
    {
        $user = Auth::user();

        $history = AlertLog::where('user_id', $user->user_id)
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        return response()->json([
            'status' => true,
            'history' => $history
        ], 200);
    }

    /**
     * دالة مساعدة للإرسال عبر UltraMsg
     */
    //     private function sendWhatsAppViaUltraMsg($phone, $message)
//     {
//         $instanceId = "163774";
//         $token = "sgb4t90qrh0wm9qo";
//        $url = "https://api.ultramsg.com/instance" . $instanceId . "/messages/chat";
//         $params = [
//             'token' => $token,
//             'to' => $phone,
//             'body' => $message,
//             'priority' => 10
//         ];

    //         $curl = curl_init();
//         curl_setopt_array($curl, [
//             CURLOPT_URL => $url,
//             CURLOPT_RETURNTRANSFER => true,
//             CURLOPT_POST => true,
//             CURLOPT_POSTFIELDS => http_build_query($params),
//         ]);
//         curl_exec($curl);
//         curl_close($curl);
//     }
// }

    private function sendWhatsAppViaUltraMsg($phone, $message)
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

        // السطر ده هو اللي هيعرفنا الغلط فين
        echo "\n --- UltraMsg Response for ($phone): " . $response . " ---\n";
    }
}