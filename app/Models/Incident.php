<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Incident extends Model
{
    use HasFactory;

    /**
     * الخانات المسموح بتعبئتها (Mass Assignment)
     * دي اللي الـ Controller بيستخدمها عشان يسيف الداتا
     */
    protected $fillable = [
    'user_id',
    'type',
    'description',
    'location_text',
    'latitude',
    'longitude',
    'media_path',     // مسار الملف الصوتي أو الصورة
    'evidence_type',  // نوع الدليل (voice, photo, video)
    'status'
];

    /**
     * علاقة البلاغ بالمستخدم (User)
     * كل بلاغ ينتمي لمستخدم واحد
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}