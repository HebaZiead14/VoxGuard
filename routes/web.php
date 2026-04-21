<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Api\SosController;

// 1. الصفحة الرئيسية
Route::get('/', function () {
    return view('welcome');
}); // هنا كان ناقص قوس وإغلاق للسهم

// 2. مسار صفحة التتبع الحي للأهل (الرابط اللي بيتبعت في الواتساب)
Route::get('/sos/track/{id}', [SosController::class, 'showMap']);

/*
|--------------------------------------------------------------------------
| Admin Dashboard Routes
|--------------------------------------------------------------------------
*/
// هنا تقدري تكملي باقي مسارات الأدمن