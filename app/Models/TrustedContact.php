<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrustedContact extends Model
{
    use HasFactory;

    /**
     * الحقول المسموح بتخزينها (Fillable)
     * تم تعديلها لتطابق شاشات التصميم والـ Postman الخاص بك
     */
    protected $fillable = [
        'user_id',    // معرف البنت اللي ضافت الرقم
        'name',       // الاسم بالكامل (First + Last Name)
        'phone',      // رقم الموبايل اللي هيتبعتله الـ Live Location
        'relation',   // اللقب أو صلة القرابة (Dad, Brother, Friend)
        'is_online',  // حالة الاتصال (True/False) لتلوين الدائرة في الـ UI
        'status',     // الحالة النصية (Online, Offline, Nearby)
        'lat',        // خط العرض (لو حبيتوا تخزنوا موقع الشخص)
        'lng'         // خط الطول
    ];

    /**
     * علاقة تربط جهة الاتصال بالمستخدم (البنت)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}