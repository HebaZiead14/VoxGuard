<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FakeCallSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
   public function run()
{
    // مكالمة ماما
    \App\Models\FakeCall::create([
        'caller_name' => 'ماما',
        'audio_url' => url('audio/fake_calls/mom_call.mp3'),
        'image_url' => url('images/mom_avatar.png'),
    ]);

    // مكالمة بابا
    \App\Models\FakeCall::create([
        'caller_name' => 'بابا',
        'audio_url' => url('audio/fake_calls/dad_call.mp3'), // جهزي الملف ده بالاسم ده
        'image_url' => url('images/dad_avatar.png'),
    ]);

    // مكالمة النجدة
    \App\Models\FakeCall::create([
        'caller_name' => 'النجدة',
        'audio_url' => url('audio/fake_calls/police_call.mp3'),
        'image_url' => url('images/police_logo.png'),
    ]);
}
}