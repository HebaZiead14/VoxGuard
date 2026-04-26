<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Trip;
use App\Models\SosAlert;
use App\Models\TrustedContact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TripController extends Controller
{
    /**
     * 1. بدء الرحلة (ربطاً بسكرينة Start Trip في الفيجما)
     */
   public function startTrip(Request $request)
{
    // 1. التحقق من البيانات
    $request->validate([
        'destination_name' => 'required|string',
        'destination_lat' => 'required|numeric',
        'destination_long' => 'required|numeric',
        'estimated_time' => 'required|integer',
        'trusted_contact_id' => 'required|integer',
        'safety_notes' => 'nullable|string',
    ]);

    // 2. الحصول على ID المستخدم المسجل
    $userId = auth('sanctum')->id(); 

    if (!$userId) {
        return response()->json(['status' => false, 'message' => 'User not authenticated'], 401);
    }

    // 3. التحقق من وجود جهة الاتصال
    $contact = \App\Models\TrustedContact::find($request->trusted_contact_id);
    if (!$contact) {
        return response()->json([
            'status' => false, 
            'message' => "خطأ: رقم جهة الاتصال غير موجود في قاعدة البيانات."
        ], 422);
    }

    try {
        // 4. حفظ بيانات الرحلة كاملة
        $trip = Trip::create([
            'user_id' => $userId, // السطر ده أساسي عشان ميظهرش الخطأ اللي في الصورة
            'destination_name' => $request->destination_name,
            'destination_lat' => $request->destination_lat,
            'destination_long' => $request->destination_long,
            'estimated_time' => $request->estimated_time,
            'trusted_contact_id' => $request->trusted_contact_id,
            'safety_notes' => $request->safety_notes,
            'status' => 'started',
        ]);

        // 5. إرسال رسالة الواتساب للأهل فوراً (الربط المطلوب)
        $this->notifyContactAboutTrip(auth('sanctum')->user(), $trip, $contact);

        return response()->json(['status' => true, 'data' => $trip], 201);

    } catch (\Exception $e) {
        // لو حصل أي خطأ في قاعدة البيانات هيظهر هنا
        return response()->json(['status' => false, 'message' => 'Database Error: ' . $e->getMessage()], 500);
    }
}
    /**
     * 2. تحديث الحالة (ربطاً بسكرينة Are you okay? في الفيجما)
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string'
        ]);

        $trip = Trip::with(['user', 'trustedContact'])->findOrFail($id);

        // تحديث الحالة في قاعدة البيانات
        $trip->update(['status' => $request->status]);

        // إذا كانت الحالة طوارئ (نقطة 21 في المشروع)
        if ($request->status == 'emergency') {
            $sos = SosAlert::create([
                'user_id' => $trip->user_id,
                'latitude' => $trip->destination_lat,
                'longitude' => $trip->destination_long,
                'trigger_type' => 'manual',
                'status' => 'active'
            ]);

            $message = "🚨 *حالة طوارئ أثناء الرحلة!* 🚨\n";
            $message .= "المستخدمة *{$trip->user->first_name}* في خطر أثناء توجهها إلى *{$trip->destination_name}*.\n";
            $message .= "📍 تتبع الموقع الحي: " . url("/sos/track/{$sos->id}");

            $this->sendWhatsApp($trip->trustedContact->phone, $message);

            return response()->json([
                'status' => true,
                'message' => '🚨 تم تفعيل نظام الاستغاثة وإخطار جهة الاتصال',
                'sos_id' => $sos->id
            ]);
        }

        return response()->json(['status' => true, 'message' => 'Status updated to ' . $request->status]);
    }

    /**
     * 3. إنهاء الرحلة (ربطاً بسكرينة Stop Sharing في الفيجما)
     */
    public function endTrip($id)
    {
        // استخدام 'reached' بدلاً من 'completed' لتوافقها مع عمود الـ Enum في جدولك
        $trip = Trip::with(['user', 'trustedContact'])->where('user_id', auth()->id())->findOrFail($id);

        $trip->update(['status' => 'reached']); // القيمة الظاهرة في جدول phpMyAdmin الخاص بك

        $user = auth()->user();

        $message = "✅ *وصلت بالسلامة* ✅\n";
        $message .= "المستخدمة *{$user->first_name}* وصلت لوجهتها وأنهت تتبع الرحلة بنجاح.";
        
        $this->sendWhatsApp($trip->trustedContact->phone, $message);

        return response()->json([
            'status' => true, 
            'message' => 'Trip ended safely!'
        ]);
    }

    // --- الدوال المساعدة لإرسال الرسائل عبر UltraMsg ---

    private function notifyContactAboutTrip($user, $trip, $contact)
    {
        $message = "🛡️ *تنبيه رحلة آمنة - VoxGuard* 🛡️\n\n";
        $message .= "المستخدمة *{$user->first_name}* بدأت رحلة تتبع الآن.\n";
        $message .= "🏁 الوجهة: *{$trip->destination_name}*\n";
        $message .= "⏳ الوقت المتوقع: *{$trip->estimated_time} دقيقة*\n";

        if ($trip->safety_notes) {
            $message .= "📝 ملاحظة: \"{$trip->safety_notes}\"\n";
        }

        $this->sendWhatsApp($contact->phone, $message);
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
}