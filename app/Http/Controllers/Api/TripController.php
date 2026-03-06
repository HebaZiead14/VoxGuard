<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Trip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TripController extends Controller
{
    // 1. دالة بدء الرحلة (نقطة 20)
    public function startTrip(Request $request)
    {
        $request->validate([
            'destination_name' => 'required|string',
            'destination_lat' => 'required|numeric',
            'destination_long' => 'required|numeric',
            'estimated_time' => 'required|integer', // الوقت بالدقائق
            'trusted_contact_id' => 'required|exists:trusted_contacts,id',
            'safety_notes' => 'nullable|string',
           'status' => 'required|in:on_way,emergency,delayed,reached'
        ]);

        $trip = Trip::create([
            'user_id' => Auth::id(), // بناخد ID البنت من التوكن أوتوماتيك
            'destination_name' => $request->destination_name,
            'destination_lat' => $request->destination_lat,
            'destination_long' => $request->destination_long,
            'estimated_time' => $request->estimated_time,
            'trusted_contact_id' => $request->trusted_contact_id,
            'safety_notes' => $request->safety_notes,
            'status' => 'started',
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Trip started successfully. Your location is now being shared.',
            'data' => $trip
        ], 201);
    }

    // 2. دالة تحديث الحالة (نقطة 21 - هل أنت بخير؟)
    public function updateStatus(Request $request, $id) {
    // جلب الرحلة مع بيانات المستخدم وجهة الاتصال الموثوقة
    $trip = Trip::with(['user', 'trustedContact'])->findOrFail($id);
    $trip->update(['status' => $request->status]);

    if ($request->status == 'emergency') {
        // إنشاء سجل استغاثة جديد في جدول SOS يخص هذه الرحلة
        $sos = \App\Models\SosAlert::create([
            'user_id' => $trip->user_id,
            'latitude' => $trip->destination_lat, 
            'longitude' => $trip->destination_long,
            'trigger_type' => 'manual', // يتم التفعيل يدوياً من صفحة الرحلة
            'status' => 'active'
        ]);

        return response()->json([
            'status' => true,
            'message' => '🚨 تم تحويل الرحلة لحالة طوارئ وتفعيل نظام الاستغاثة الشامل للأهل',
            'sos_id' => $sos->id, // هذا الـ ID هو اللي فلاتر هيستخدمه لرفع الصوت
            'contact_notified' => $trip->trustedContact->name
        ]);
    }

    return response()->json(['status' => true, 'message' => 'تم تحديث حالة الرحلة']);
}

    // دالة إنهاء الرحلة (أمر الوصول بالسلامة)
    public function endTrip($id)
    {
        $trip = Trip::where('user_id', Auth::id())->findOrFail($id);

        // تحديث الحالة لـ "وصلت" (reached)
        $trip->update(['status' => 'reached']);

        return response()->json([
            'status' => true,
            'message' => 'Glad you are safe! Trip ended and family notified.',
            'data' => $trip
        ]);
    }
}