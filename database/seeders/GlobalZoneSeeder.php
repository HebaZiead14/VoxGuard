<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GlobalZoneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // إضافة منطقة أمان (مثلاً قسم شرطة أو مستشفى)
        \App\Models\GlobalZone::create([
            'name' => 'Safe Zone - Police Station',
            'latitude' => 30.0444, // إحداثيات افتراضية للقاهرة
            'longitude' => 31.2357,
            'radius' => 500, // القطر بالمتر
            'type' => 'safe'
        ]);

        // إضافة منطقة خطر (منطقة مشبوهة أو غير آمنة)
        \App\Models\GlobalZone::create([
            'name' => 'Danger Area - Warning',
            'latitude' => 30.0500,
            'longitude' => 31.2400,
            'radius' => 300,
            'type' => 'danger'
        ]);
    }
}
