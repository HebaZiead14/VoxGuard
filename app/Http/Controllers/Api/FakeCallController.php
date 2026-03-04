<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FakeCall;
use Illuminate\Support\Facades\Auth;

class FakeCallController extends Controller
{
    public function schedule(Request $request)
    {
        $request->validate([
            'caller_name' => 'required|string', 
            'minutes'     => 'required|integer',
            'ringtone'    => 'required|string',
        ]);

        if (!Auth::guard('sanctum')->check()) {
            return response()->json([
                'status' => false,
                'message' => 'User not authenticated.'
            ], 401);
        }

        $fakeCall = FakeCall::create([
    'user_id'      => Auth::guard('sanctum')->id(),
    'caller_name'  => $request->caller_name,
    'scheduled_at' => now()->addMinutes($request->minutes), 
    'ringtone'     => $request->ringtone,
    'status'       => 'pending',
    'voice_script' => $request->voice_script ?? 'general', // بياخد القيمة من الريكويست أو يحط 'general' كافتراضي
        ]);

        return response()->json([
            'status'  => true,
            'message' => "The fake call is scheduled for {$request->minutes} minutes later.",
            'data'    => $fakeCall
        ]);
    }

    public function updateStatus(Request $request, $id) 
    {
        // استخدام Auth::id() لضمان المزامنة مع التوكن
        $call = FakeCall::where('user_id', Auth::guard('sanctum')->id())->findOrFail($id);
        $call->update(['status' => 'completed']);

        return response()->json([
            'status' => true,
            'message' => 'Call status updated successfully'
        ]);
    }
}