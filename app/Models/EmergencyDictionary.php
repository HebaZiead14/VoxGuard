<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EmergencyDictionary extends Model
{
    use HasFactory;

    // 1. تحديد اسم الجدول في الداتا بيز
    protected $table = 'emergency_dictionary';

    // 2. تحديد الخانات المسموح بحفظها وتعديلها (Mass Assignment)
    protected $fillable = [
        'user_id',
        'word',
        'is_active',
    ];

    // 3. (اختياري) علاقة الموديل مع جدول المستخدمين (User) 
    // عشان لو حبيتوا في أي وقت تعرفوا الكلمة المخصصة دي تبع أنهي مستخدم
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}