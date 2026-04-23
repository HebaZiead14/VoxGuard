<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FakeCall extends Model
{
    use HasFactory;

    /**
     * الحقول اللي مسموح نعدلها (Mass Assignment)
     */
    protected $fillable = [
        'user_id',
        'caller_name',
        'scheduled_at',
        'ringtone',
        'status',
        'voice_script',
        'audio_path'
    ];

    /**
     * تحويل الحقول لأنواع بيانات معينة تلقائياً
     */
    protected $casts = [
        'scheduled_at' => 'datetime',
        'status' => 'string',
    ];

    /**
     * القيم الافتراضية للحقول
     */
    protected $attributes = [
        'status' => 'pending',
        'ringtone' => 'default_ringtone.mp3',
    ];

    /**
     * علاقة تربط المكالمة باليوزر (صاحبة الحساب)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope: عشان تجيبي المكالمات المنتظرة بس بسهولة
     * مثال: FakeCall::pending()->get();
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * دالة مساعدة للتأكد إذا كانت المكالمة اكتملت
     */
    public function isCompleted()
    {
        return $this->status === 'completed';
    }
}