<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlertLog extends Model
{
    use HasFactory;

    /**
     * تحديد الأعمدة المسموح بالكتابة فيها (Mass Assignment)
     * user_id: معرف المستخدمة اللي حصل عندها الخطر
     * lat & long: إحداثيات الموقع وقت الاستغاثة
     * status: حالة الاستغاثة (مثلاً: تم الإرسال بنجاح)
     */
    protected $fillable = [
        'user_id',
        'lat',
        'long',
        'status'
    ];
}