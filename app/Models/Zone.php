<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Zone extends Model
{

   protected $fillable = [
    'user_id', 
    'name', 
    'latitude', 
    'longitude', 
    'radius', 
    'type', 
    'category', 
    'crowd_level', 
    'lighting', 
    'is_automatic', 
    'notify_family' ,
    
    // ضيفي دي عشان التنبيهات تشتغل صح
];
}
