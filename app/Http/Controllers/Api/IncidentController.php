<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Incident;
use App\Models\SosAlert; // استدعاء موديل الاستغاثة للربط مع الساعة
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class IncidentController extends Controller
{
    /**
     * 1. إنشاء بلاغ جديد (Create Report) مع دعم الأدلة المتعددة
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'type' => 'required|string',
            'description' => 'required|string|min:5',
            'location_text' => 'required|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            // دعم صيغ أكثر للأدلة بناءً على Figma (Voice/Video/Photo)
            'media' => 'nullable|file|mimes:jpg,jpeg,png,mp4,mov,mp3,wav,m4a|max:20480',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation Error',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $incident = new Incident();
            $incident->user_id = auth()->id(); 
            $incident->type = $request->type;
            $incident->description = $request->description;
            $incident->location_text = $request->location_text;
            $incident->latitude = $request->latitude;
            $incident->longitude = $request->longitude;
            $incident->status = 'pending';

            if ($request->hasFile('media')) {
                $file = $request->file('media');
                $extension = $file->getClientOriginalExtension();
                
                // تحديد نوع الدليل آلياً (عشان يظهر في الـ History صح)
                $evidenceType = 'photo';
                if (in_array($extension, ['mp4', 'mov'])) $evidenceType = 'video';
                if (in_array($extension, ['mp3', 'wav', 'm4a'])) $evidenceType = 'voice';

                $fileName = time() . '_' . $file->getClientOriginalName();
                // الأفضل استخدام storage لسهولة التعامل مع الروابط لاحقاً
                $path = $file->storeAs('incidents', $fileName, 'public');
                
                $incident->media_path = 'storage/' . $path;
                $incident->evidence_type = $evidenceType; // تأكدي من إضافة هذا العمود في Migration الـ Incidents
            }

            $incident->save();

            return response()->json([
                'status' => true,
                'message' => 'Incident report submitted with evidence.',
                'data' => $incident
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Internal Server Error',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * 2. عرض تاريخ البلاغات (History)
     */
    public function history()
    {
        // جلب البلاغات مع إضافة رابط كامل للملفات لتسهيل العرض في Flutter
        $reports = Incident::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($report) {
                if ($report->media_path) {
                    $report->full_media_url = url($report->media_path) . "?ngrok-skip-browser-warning=1";
                }
                return $report;
            });

        return response()->json([
            'status' => true, 
            'reports' => $reports
        ], 200);
    }

    /**
     * 3. استقبال بيانات الساعة (Smart Watch / Pair Device)
     * هذا الجزء يغطي طلبك بخصوص ضربات القلب وربطها بالخوف
     */
    public function syncWatchData(Request $request)
    {
        $request->validate([
            'heart_rate' => 'required|integer',
            'activity' => 'nullable|string' // walking, standing, etc.
        ]);

        $user = auth()->user();
        $heartRate = $request->heart_rate;

        // المنطق: لو ضربات القلب زادت عن حد معين (خطر) نفعل SOS تلقائي
        if ($heartRate > 120) {
            // يمكننا هنا استدعاء SosController داخلياً أو إرجاع أمر للموبايل بتفعيل الاستغاثة
            return response()->json([
                'status' => true,
                'trigger_sos' => true,
                'message' => 'High heart rate detected! Emergency protocol suggested.'
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => 'Health data synced successfully',
            'current_heart_rate' => $heartRate
        ]);
    }
}