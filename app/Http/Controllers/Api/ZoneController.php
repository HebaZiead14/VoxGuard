<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\GlobalZone; // للمناطق التلقائية
use App\Models\Zone;       // للمناطق الخاصة بالبنت
use Illuminate\Http\Request;

class ZoneController extends Controller
{
    // 1. جلب المناطق التلقائية (أقسام، مناطق خطر)
    public function getAutomaticZones()
    {
        try {
            $zones = GlobalZone::all(); 
            return response()->json([
                'status' => true,
                'message' => 'Automatic zones retrieved successfully',
                'data' => $zones
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    // 2. جلب المناطق الخاصة بالبنت (بيتي، جامعتي)
    public function getPersonalZones()
    {
        $user = auth()->user();
        // جلب المناطق المرتبطة بالبنت فقط
        $zones = Zone::where('user_id', $user->user_id)->get(); 

        return response()->json([
            'status' => true,
            'data' => $zones
        ]);
    }

    // 3. حفظ منطقة جديدة (لما البنت تختار الـ Radius بالسلايدر وتدوس حفظ)
    public function storePersonalZone(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'latitude' => 'required',
            'longitude' => 'required',
            'radius' => 'required|integer', // الرقم من السلايدر
            'type' => 'required|in:safe,danger'
        ]);

        $zone = Zone::create([
            'user_id' => auth()->user()->user_id,
            'name' => $request->name,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'radius' => $request->radius,
            'type' => $request->type
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Zone saved successfully!',
            'data' => $zone
        ]);
    }
}