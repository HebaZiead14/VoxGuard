<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SosAlert extends Model
{
    protected $fillable = [
    'user_id',
    'latitude',
    'longitude',
    'status',
    'trigger_type',
    'audio_path',
    'emotion_state' // لازم تضيفي السطر ده هنا ضروري جداً
];

    /**
     * العلاقة بين الاستغاثة والمستخدم
     * دي اللي بتخلي صفحة التتبع تعرض اسم البنت وبياناتها
     */
    public function user()
    {
        // بنربط الـ user_id اللي في جدول الاستغاثات بالـ user_id اللي في جدول الـ Users
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}