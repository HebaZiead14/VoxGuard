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
            'device_id' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()], 422);
        }

        $user = Auth::user();
        $user->update([
            'wearable_device_name' => $request->device_name,
            'wearable_device_id' => $request->device_id,
            'wearable_active' => true,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Smartwatch connected successfully and monitoring started!'
        ]);
    }

    /**
     * 2. استقبال بيانات الصحة (Monitoring)
     */
    public function updateHealthData(Request $request)
    {
        $user = auth('sanctum')->user();

        if (!$user) {
            return response()->json(['status' => false, 'message' => 'Token Error'], 401);
        }

        $currentUserId = $user->id ?? $user->user_id;

        // تحديث بيانات النبض في جدول الـ users
        $user->update([
            'current_heart_rate' => $request->heart_rate,
            'current_motion' => $request->motion,
        ]);

        // شرط الطوارئ (نبض عالي أو منخفض جداً)
        if ($request->heart_rate >= 120 || $request->heart_rate <= 50) {

            SosAlert::create([
                'user_id' => $currentUserId,
                'latitude' => $request->lat,
                'longitude' => $request->lng,
                'trigger_type' => 'health_auto',
                'status' => 'active'
            ]);

            // صياغة الرسالة الكاملة (احترافية)
            $message = "🚨 *VoxGuard: تنبيه صحي طارئ* 🚨\n\n";
            $message .= "👤 المستخدمة: *{$user->first_name} {$user->last_name}*\n";
            $message .= "💓 نبض القلب الحالي: *{$request->heart_rate} BPM*\n";
            $message .= "🩸 فصيلة الدم: *{$user->blood_type}*\n";
            $message .= "📋 الحالة الطبية: *{$user->medical_conditions}*\n";
            $message .= "📍 الموقع الحالي: https://www.google.com/maps?q={$request->lat},{$request->lng}";

            // استدعاء دالة الإرسال
            $this->broadcastToAll($user, $message);

            return response()->json(['emergency' => true, 'message' => 'SOS Created and complete details sent!']);
        }

        return response()->json(['status' => 'Healthy', 'heart_rate' => $request->heart_rate]);
    }

    private function broadcastToAll($user, $message)
    {
        $currentUserId = $user->id ?? $user->user_id;
        $emergency = $user->emergencyContacts ?? collect();
        $trusted = TrustedContact::where('user_id', $currentUserId)->get() ?? collect();

        foreach ([$emergency, $trusted] as $group) {
            foreach ($group as $contact) {
                $targetPhone = $contact->phone ?? $contact->phone_numder;
                if ($targetPhone) {
                    $this->sendWhatsApp($targetPhone, $message);
                }
            }
        }
    }

    private function sendWhatsApp($phone, $message)
    {
        $params = array(
            'token' => '1bajiprv1swk00sy',
            'to' => $phone,
            'body' => $message
        );

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.ultramsg.com/instance171200/messages/chat",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => http_build_query($params),
        ));
        curl_exec($curl);
        curl_close($curl);
    }
}