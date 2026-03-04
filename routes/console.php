<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule; // لازم نستدعي الـ Schedule

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// السطر السحري اللي بيشغل المراقبة كل دقيقة
Schedule::command('app:check-safety-timers')->everyMinute();