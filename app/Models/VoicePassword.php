<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VoicePassword extends Model
{
    // الخانات اللي مسموح نملأها (زي ما بتوع الـ UI طلبوا)
    protected $fillable = [
        'user_id',
        'phrase',
        'sensitivity',
        'timer_duration' // لازم تضاف هنا عشان تتحفظ

    ];

    // علاقة تربط الكلمة بالمستخدم (كل كلمة تخص يوزر واحد)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}