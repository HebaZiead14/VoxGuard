<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VoicePassword;
use App\Models\FakeCall; // استدعاء موديل المكالمة الوهمية
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class VoicePasswordController extends Controller
{
    /**
     * حفظ إعدادات الكلمة الصوتية وربطها بجدولة المكالمة الوهمية التلقائية
     */
    public function store(Request $request)
    {
        // 1. التأكد من البيانات (الكلمة، الحساسية، ومدة التايمر)
        $validator = Validator::make($request->all(), [
            'phrase' => 'required|string|min:2',
            'sensitivity' => 'required|integer|between:0,100',
            'timer_duration' => 'required|integer|between:1,60', 
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation Error',
                'errors' => $validator->errors()
            ], 422);
        }

        // 2. حفظ أو تحديث بيانات الكلمة الصوتية والتايمر
        $voice = VoicePassword::updateOrCreate(
            ['user_id' => Auth::id()],
            [
                'phrase' => $request->phrase,
                'sensitivity' => $request->sensitivity,
                'timer_duration' => $request->timer_duration 
            ]
        );

        // 3. إضافة "جدولة تلقائية" لمكالمة وهمية مرتبطة بهذا الإعداد
        // الهدف: أول ما اليوزر يفعل الكلمة الصوتية، السيستم يجهز سجل المكالمة اللي هتظهر كتمويه
        FakeCall::updateOrCreate(
            ['user_id' => Auth::id(), 'status' => 'pending'], // لو فيه مكالمة قديمة لسه مارنتش بنحدثها
            [
                'caller_name' => 'Emergency Security', // اسم المتصل التمويهي
                'scheduled_at' => now()->addSeconds(5), // تظهر فوراً تقريباً بعد تفعيل الحماية
                'ringtone' => 'Default Ringtone',
                'status' => 'pending'
            ]
        );

        // 4. الرد بالنجاح (كامل وشامل لكل البيانات)
        return response()->json([
            'status' => true,
            'message' => 'Voice Password and Safety Call plan saved successfully!',
            'data' => [
                'voice_settings' => $voice,
                'auto_fake_call' => 'Enabled'
            ]
        ], 200);
    }
}