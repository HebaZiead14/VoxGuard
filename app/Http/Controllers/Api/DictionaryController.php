<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EmergencyDictionary;
use Illuminate\Support\Facades\Auth;

class DictionaryController extends Controller
{
    public function checkSpeech(Request $request)
    {
        $request->validate([
            'text' => 'required|string'
        ]);

        $userId = Auth::id();
        $textIn = $request->text;

        $words = EmergencyDictionary::where('is_active', true)
            ->where(function ($query) use ($userId) {
                $query->whereNull('user_id')
                    ->orWhere('user_id', $userId);
            })
            ->pluck('word')
            ->toArray();

        $dangerWordDetected = null;
        $isDanger = false;

        foreach ($words as $word) {
            if (mb_strpos($textIn, $word) !== false) {
                $isDanger = true;
                $dangerWordDetected = $word;
                break; 
            }
        }

        return response()->json([
            'status' => true,
            'danger_detected' => $isDanger,
            'trigger_sos' => $isDanger, 
            'matched_word' => $dangerWordDetected,
            'message' => $isDanger ? 'Emergency word captured! Activate SOS and notify AI.' : 'Clear text.'
        ], 200);
    }
}