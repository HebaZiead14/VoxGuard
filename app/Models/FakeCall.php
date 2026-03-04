<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FakeCall extends Model
{
    // ضفنا 'status' هنا عشان نقدر نغيرها من pending لـ completed
    protected $fillable = [
        'user_id', 
        'caller_name', 
        'scheduled_at', 
        'ringtone', 
        'status',
        'voice_script',
    ];

    // علاقة تربط المكالمة بصاحبها (اليوزر)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}