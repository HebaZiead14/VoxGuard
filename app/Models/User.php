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
     */
    protected $fillable = [
    'name',
    'email',
    'password',
    'phone_number', 
    'phone', // إضافة هذا الحقل لأنه مستخدم في الـ AuthController
    'otp',   // إضافة هذا الحقل ليتمكن الـ Laravel من حفظ كود التحقق
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
    'current_motion',
    // --- حقول تسجيل الدخول الاجتماعي المضافة ---
    'google_id',
    'facebook_id',
    'social_type',
    // --- حقول الحالة والموقع الحية (إضافة للمناقشة والربط الذكي) ---
    'last_seen',
    'latitude',
    'longitude'
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
     */
    protected function casts(): array {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'fake_call_enabled' => 'boolean',
            'panic_button_enabled' => 'boolean',
            'notifications_enabled' => 'boolean',
            'wearable_active' => 'boolean',
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