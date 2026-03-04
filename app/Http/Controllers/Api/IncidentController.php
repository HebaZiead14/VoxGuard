<?php

namespace App\Http\Controllers\Api; // تعديل الـ Namespace ليتطابق مع الفولدر

use App\Http\Controllers\Controller; // استدعاء الكنترولر الأساسي
use App\Models\Incident;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class IncidentController extends Controller
{
    /**
     * إنشاء بلاغ جديد (Create Report)
     */
    public function store(Request $request)
    {
        // 1. التحقق من البيانات (Validation)
        $validator = Validator::make($request->all(), [
            'type' => 'required|string',
            'description' => 'required|string|min:5',
            'location_text' => 'required|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'media' => 'nullable|file|mimes:jpg,jpeg,png,mp4,mp3,wav|max:20480',
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
                $fileName = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('uploads/incidents'), $fileName);
                $incident->media_path = 'uploads/incidents/' . $fileName;
            }

            $incident->save();

            return response()->json([
                'status' => true,
                'message' => 'Incident report has been submitted successfully.',
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

    public function history()
    {
        $reports = Incident::where('user_id', auth()->id())->orderBy('created_at', 'desc')->get();
        return response()->json(['status' => true, 'reports' => $reports], 200);
    }
}