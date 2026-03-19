<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrustedContact extends Model
{
    use HasFactory;

    /**
     * الحقول المسموح بتخزينها (Fillable)
     */
    protected $fillable = [
        'user_id',    
        'name',       
        'phone',      
        'relation',   
        'image',      // <--- لازم تضيفي السطر ده هنا عشان الصورة تتخزن
        'is_online',  
        'status',     
        'lat',        
        'lng'         
    ];

    /**
     * علاقة تربط جهة الاتصال بالمستخدم (البنت)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}