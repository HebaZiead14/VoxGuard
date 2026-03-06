<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\TrustedContact;

class Trip extends Model
{
    use HasFactory;

    // الخانات المسموح بكتابتها (Mass Assignment)
    protected $fillable = [
        'user_id',
        'destination_name',
        'destination_lat',
        'destination_long',
        'estimated_time',
        'safety_notes',
        'trusted_contact_id',
        'status',
    ];

    // علاقة الرحلة بالمستخدم (البنت)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // علاقة الرحلة بجهة الاتصال الموثوقة
    public function trustedContact()
    {
        return $this->belongsTo(TrustedContact::class, 'trusted_contact_id');
    }
}