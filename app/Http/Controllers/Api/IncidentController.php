<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Incident;
use App\Models\SosAlert; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class IncidentController extends Controller
{
    /**
     * 1. إنشاء بلاغ جديد (Create Report)
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'type' => 'required|string',
            'description' => 'required|string|min:5',
            'location_text' => 'required|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
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

                $evidenceType = 'photo';
                if (in_array($extension, ['mp4', 'mov'])) $evidenceType = 'video';
                if (in_array($extension, ['mp3', 'wav', 'm4a'])) $evidenceType = 'voice';

                $fileName = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('incidents', $fileName, 'public');

                $incident->media_path = 'storage/' . $path;
                $incident->evidence_type = $evidenceType; 
            }

            $incident->save();

            // إضافة الرابط الكامل هنا أيضاً لراحة بتوع فلاتر
            if ($incident->media_path) {
                $incident->full_media_url = url($incident->media_path) . "?ngrok-skip-browser-warning=1";
            }

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
     * 3. استقبال بيانات الساعة (Smart Watch)
     */
    public function syncWatchData(Request $request)
    {
        $request->validate([
            'heart_rate' => 'required|integer',
            'activity' => 'nullable|string'
        ]);

        $heartRate = $request->heart_rate;

        if ($heartRate > 120) {
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