<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GlobalZone extends Model
{
    use HasFactory;

    // دي أهم حتة: بنعرف لارافل إيه الخانات اللي مسموح نملأها بيانات
    protected $fillable = [
        'name',
        'latitude',
        'longitude',
        'radius',
        'type'
    ];
}
