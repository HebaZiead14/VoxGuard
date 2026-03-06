<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Zone;
use App\Models\TrustedContact;
use Illuminate\Http\Request;

class ZoneController extends Controller
{
    public function index(Request $request)
    {
        try {
            $user = auth()->user();
            $currentHour = now()->hour;

            $zones = Zone::where('is_automatic', true)
                ->orWhere('user_id', $user->id)
                ->get();

            $zones->transform(function ($zone) use ($currentHour) {
                if ($zone->is_automatic && ($currentHour >= 23 || $currentHour <= 5)) {
                    if ($zone->lighting == 'poor' || $zone->category == 'Industrial') {
                        $zone->type = 'high_alert';
                    }
                }
                return $zone;
            });

            return response()->json([
                'status' => true,
                'message' => 'All map zones retrieved successfully',
                'data' => $zones
            ], 200);

        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        // 1. التحقق من البيانات المرسلة
        $request->validate([
            'name' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'radius' => 'required|integer',
            'type' => 'required|in:safe,moderate,high_alert',
            'notify_family' => 'nullable|boolean',
            'user_id' => 'nullable|integer' // ضفت ده عشان لو حبيتي تبعتيه يدوي من Postman
        ]);

        // 2. تحديد الـ User ID (الأولوية للتوكن، ولو فشل ياخد اللي باعتينه في الـ Body، ولو مفيش خالص يحط 15)
        $finalUserId = auth()->id() ?: ($request->user_id ?: 15);

        // 3. إنشاء المنطقة
        $zone = Zone::create([
            'user_id' => $finalUserId,
            'name' => $request->name,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'radius' => $request->radius,
            'type' => $request->type,
            'is_automatic' => false,
            'notify_family' => $request->notify_family ?? true,
            'category' => 'Personal'
        ]);

        // 4. الربط مع الأهل وإرسال الواتساب
        if ($zone->notify_family) {
            // بنجيب الأهل المربوطين بنفس الـ User ID اللي سجلنا بيه المنطقة
            $contacts = TrustedContact::where('user_id', $finalUserId)->get();

            foreach ($contacts as $contact) {
                $this->sendZoneAlertToFamily($contact, $zone);
            }
        }

        // 5. الرد النهائي
        return response()->json([
            'status' => true,
            'message' => 'Zone saved and family notified via WhatsApp!',
            'data' => $zone,
            'debug_user_id' => $finalUserId // ضفت ده عشان تتأكدي في Postman الرقم كام
        ], 201);
    }

    /**
     * دالة إرسال تنبيه المنطقة للأهل (WhatsApp)
     */
    private function sendZoneAlertToFamily($contact, $zone)
    {
        $userName = auth()->user()->name;
        $mapLink = "https://www.google.com/maps?q={$zone->latitude},{$zone->longitude}";

        $messageBody = "🛡️ *تنبيه منطقة آمنة من VoxGuard* 🛡️\n\n";
        $messageBody .= "قامت المودموزيل: *{$userName}* بإضافة منطقة جديدة.\n";
        $messageBody .= "📍 *اسم المنطقة*: {$zone->name}\n";
        $messageBody .= "📏 *المدى*: {$zone->radius} متر\n";
        $messageBody .= "🔗 *موقع المنطقة*: {$mapLink}\n\n";
        $messageBody .= "تطمني، سيتم إخطارك فور دخولها هذا النطاق.";

        $params = array(
            'token' => 'sgb4t90qrh0wm9qo', // حطي التوكن بتاعك هنا
            'instance_id' => 'instance163774', // حطي الأي دي بتاعك هنا
            'to' => $contact->phone,
            'body' => $messageBody
        );

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.ultramsg.com/" . $params['instance_id'] . "/messages/chat",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => http_build_query($params),
            CURLOPT_HTTPHEADER => array("content-type: application/x-www-form-urlencoded"),
        ));

        curl_exec($curl);
        curl_close($curl);
    }

    public function destroy($id)
    {
        $zone = Zone::where('id', $id)
            ->where('user_id', auth()->id())
            ->where('is_automatic', false)
            ->first();

        if (!$zone) {
            return response()->json(['status' => false, 'message' => 'Zone not found'], 404);
        }

        $zone->delete();
        return response()->json(['status' => true, 'message' => 'Zone deleted successfully']);
    }
}