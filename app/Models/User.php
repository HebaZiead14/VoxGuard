<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    // تعريف اسم الجدول والمفتاح الأساسي المخصص
    protected $table = 'users'; 
    protected $primaryKey = 'user_id'; 

    /**
     * الحقول المسموح بتعديلها (Mass Assignable)
     * تشمل بيانات الملف الشخصي، المعلومات الطبية، وإعدادات التطبيق
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone_number',              // تعديل: غيريها من phone_number لـ phone
        'first_name',
        'last_name',
        'profile_image',
        'blood_type',
        'allergies',
        'medical_conditions',
        'language',
        'fake_call_enabled',
        'panic_button_enabled',
        'notifications_enabled',
        'wearable_device_name', 
        'wearable_device_id', 
        'wearable_active',
        'current_heart_rate',
        'current_motion'
    ];

    /**
     * الحقول المخفية من الاستعلامات
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * تحويل البيانات (Casting)
     * نضمن هنا أن القيم المنطقية ترجع كـ Boolean وليس أرقام
     */
    protected function casts(): array {
        return [
            'password' => 'hashed',
            'fake_call_enabled' => 'boolean',
            'panic_button_enabled' => 'boolean',
            'notifications_enabled' => 'boolean',
        ];
    }

    /* |--------------------------------------------------------------------------
    | العلاقات البرمجية (Relationships)
    |--------------------------------------------------------------------------
    */

    /**
     * الحصول على جهات اتصال الطوارئ
     */
    public function emergencyContacts()
    {
        return $this->hasMany(EmergencyContact::class, 'user_id', 'user_id');
    }

    /**
     * الحصول على سجل الاستغاثات (SOS Alerts)
     * قمت بتعديل الاسم ليتوافق مع جداول نظام الاستغاثة
     */
    public function sosAlerts()
    {
        return $this->hasMany(SosAlert::class, 'user_id', 'user_id');
    }

    /**
     * الحصول على سجل المكالمات الوهمية
     */
    public function fakeCalls()
    {
        return $this->hasMany(FakeCall::class, 'user_id', 'user_id');
    }

    /**
     * الحصول على التايمر الخاص بالمستخدم
     */
    public function safetyTimers()
    {
        return $this->hasMany(SafetyTimer::class, 'user_id', 'user_id');
    }
}