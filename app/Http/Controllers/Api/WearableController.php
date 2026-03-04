<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\SosAlert;
use App\Models\TrustedContact;
use Illuminate\Support\Facades\Validator;

class WearableController extends Controller
{
    /**
     * 1. ربط الساعة بالحساب (Pairing)
     */
    public function connectDevice(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'device_name' => 'required|string',
            'device_id'   => 'required|string', 
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()], 422);
        }

        $user = Auth::user();
        $user->update([
            'wearable_device_name' => $request->device_name,
            'wearable_device_id'   => $request->device_id,
            'wearable_active'      => true, 
        ]);

        return response()->json([
            'status'  => true,
            'message' => 'Smartwatch connected successfully and monitoring started!'
        ]);
    }

    /**
     * 2. استقبال بيانات الصحة (Monitoring)
     */
    public function updateHealthData(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'heart_rate' => 'required|integer',
            'motion'     => 'required|string',
            'lat'        => 'nullable|numeric',
            'lng'        => 'nullable|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()], 422);
        }

        $user = Auth::user();
        
        $user->update([
            'current_heart_rate' => $request->heart_rate,
            'current_motion'     => $request->motion,
        ]);

        // فحص حالة الطوارئ
        if ($request->heart_rate >= 120 || $request->heart_rate <= 50) {
            
            $statusLabel = ($request->heart_rate >= 120) ? "ارتفاع شديد" : "انخفاض شديد";
            $googleMapsLink = "https://www.google.com/maps/?q=" . ($request->lat ?? $user->lat ?? 0) . "," . ($request->lng ?? $user->lng ?? 0);
            
            $message = "🚨 *VoxGuard - استغاثة صحية تلقائية* 🚨\n\n";
            $message .= "⚠️ تم رصد {$statusLabel} في نبضات قلب: *{$user->name}*\n";
            $message .= "💓 معدل النبض الحالي: *{$request->heart_rate} BPM*\n";
            $message .= "🏃 الحالة الحركية: *{$request->motion}*\n";
            $message .= "📍 الموقع الحالي: {$googleMapsLink}";

            // نداء الدالة الموجودة بالأسفل للإرسال للكل
            $this->broadcastToAll($user, $message);

            return response()->json([
                'status' => true,
                'emergency' => true,
                'message' => 'Emergency detected! Alerts sent to family and trusted contacts.'
            ]);
        }

        return response()->json(['status' => true, 'message' => 'Normal heart rate']);
    }

    /**
     * 3. دالة الإرسال الجماعي (عشان الخط اللي كان في الصورة يختفي)
     */
    private function broadcastToAll($user, $message)
    {
        // تجنب الخطأ لو العلاقات غير معرفة (استخدام الصور 2 و 4 كمرجع)
        $emergency = $user->emergencyContacts ?? collect(); 
        $trusted = TrustedContact::where('user_id', $user->id)->get() ?? collect();

        foreach ([$emergency, $trusted] as $group) {
            foreach ($group as $contact) {
                // التأكد من اسم العمود (phone) كما في الموديل الخاص بك
                $targetPhone = $contact->phone ?? $contact->phone_numder;
                
                if ($targetPhone) {
                    $this->sendWhatsApp($targetPhone, $message);
                }
            }
        }
    }

    /**
     * 4. دالة إرسال الواتساب (تأكدي من وضع بيانات UltraMsg الخاصة بك هنا)
     */
    private function sendWhatsApp($phone, $message)
    {
        $params = array(
            'token' => 'YOUR_ULTRAMSG_TOKEN', // ضعي التوكن الخاص بك هنا
            'to' => $phone,
            'body' => $message
        );

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.ultramsg.com/YOUR_INSTANCE_ID/messages/chat",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => http_build_query($params),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
    }
}