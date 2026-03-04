<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmergencyContact extends Model
{
    use HasFactory;

    /**
     * الخانات المسموح بتخزينها (Mass Assignment)
     */
    protected $fillable = ['user_id', 'first_name', 'last_name', 'phone', 'relation'];
    /**
     * علاقة تربط جهة الاتصال بالمستخدم
     * كل رقم طوارئ ينتمي لمستخدم واحد
     */
    public function user()
    {
        // تأكدي إن المفتاح الأساسي في جدول اليوزر هو user_id
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
} // قفلة الكلاس اللي كانت ناقصة