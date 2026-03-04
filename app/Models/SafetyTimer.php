<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// تأكدي من السطر ده لو طلع لك خطأ إن User غير موجود
use App\Models\User; 

class SafetyTimer extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'expires_at',
        'status'
    ];

    // علاقة لربط التايمر باليوزر
    public function user()
    {
        // بنحدد إن المفتاح في جدول users هو user_id
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}