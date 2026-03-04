<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SafetyTimer;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class SafetyTimerController extends Controller
{
    // 1. بدأ تايمر جديد
    public function startTimer(Request $request)
    {
        $user = Auth::user();
        
        // اليوزر يبعت الوقت بالدقائق (مثلاً 10 دقائق)
        $minutes = $request->minutes ?? 5; 

        // حساب وقت الانتهاء = الوقت الحالي + الدقائق
        $expiresAt = Carbon::now()->addMinutes($minutes);

        // كنسلة أي تايمر قديم شغال لليوزر ده
        SafetyTimer::where('user_id', $user->user_id)->where('status', 'active')->update(['status' => 'canceled']);

        $timer = SafetyTimer::create([
            'user_id' => $user->user_id,
            'expires_at' => $expiresAt,
            'status' => 'active'
        ]);

        return response()->json([
            'status' => true,
            'message' => "Safety timer started for $minutes minutes.",
            'expires_at' => $expiresAt
        ]);
    }

    // 2. إلغاء التايمر (لو اليوزر وصل بالسلامة)
    public function cancelTimer()
    {
        $user = Auth::user();
        SafetyTimer::where('user_id', $user->user_id)->where('status', 'active')->update(['status' => 'canceled']);

        return response()->json([
            'status' => true,
            'message' => 'Safety timer canceled. Glad you are safe!'
        ]);
    }
}