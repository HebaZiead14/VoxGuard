
<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// استدعاء كل الـ Controllers (القديم والجديد وكل التخصصات)
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\EmergencyContactController; 
use App\Http\Controllers\Api\TrustedContactController;   
use App\Http\Controllers\Api\VoicePasswordController;
use App\Http\Controllers\Api\AlertController; 
use App\Http\Controllers\Api\SafetyTimerController;
use App\Http\Controllers\Api\FakeCallController;
use App\Http\Controllers\Api\SosController;
use App\Http\Controllers\Api\ProfileController; 
use App\Http\Controllers\Api\SettingsController; 
use App\Http\Controllers\Api\WearableController; // إضافة الكنترولر الجديد للساعة
use App\Http\Controllers\Api\IncidentController;
use App\Http\Controllers\Api\ZoneController;
/*
|--------------------------------------------------------------------------
| API Routes - VoxGuard Project
|--------------------------------------------------------------------------
*/

/* 1. المسارات العامة (Public Routes) */
// متاحة للجميع بدون تسجيل دخول
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
Route::post('/reset-password', [AuthController::class, 'resetPassword']);

/* 2. المسارات المحمية (Protected Routes) */
// تتطلب وجود Bearer Token (Sanctum)
Route::middleware('auth:sanctum')->group(function () {

    // --- نظام البروفايل والمعلومات الطبية ---
    Route::prefix('profile')->group(function () {
        Route::get('/', [ProfileController::class, 'show']);
        Route::post('/update', [ProfileController::class, 'update']);
        Route::get('/activity-log', [ProfileController::class, 'activityLog']);
        // تحديث معلومات الطوارئ الطبية
        Route::post('/update-emergency-info', [AuthController::class, 'updateEmergencyInfo']); 
    });

    // --- نظام جهات الاتصال الموثوقة (Trusted Contacts) ---
    Route::prefix('trusted-contacts')->group(function () {
        Route::get('/', [TrustedContactController::class, 'index']);
        Route::post('/store', [TrustedContactController::class, 'store']);
        Route::post('/send-location', [TrustedContactController::class, 'sendLocation']);
        Route::delete('/{id}', [TrustedContactController::class, 'destroy']);
    });

    // --- جهات اتصال الطوارئ (الأهل والمنقذين) ---
    Route::prefix('emergency-contacts')->group(function () {
        Route::get('/', [EmergencyContactController::class, 'index']);
        Route::post('/', [EmergencyContactController::class, 'store']);
        Route::delete('/{id}', [EmergencyContactController::class, 'destroy']);
    });

    // --- نظام الساعة الذكية (Wearable System) ---
    // هذا الجزء هو المسؤول عن استقبال بيانات النبض من الساعة لإطلاق التنبيه أوتوماتيكياً
    Route::prefix('wearable')->group(function () {
        Route::post('/connect', [WearableController::class, 'connectDevice']);      // ربط الساعة (Pairing)
        Route::post('/update-health', [WearableController::class, 'updateHealthData']); // تحديث النبض واللوكيشن
    });

    // --- نظام التنبيهات الفورية (Alerts & Panic Button) ---
    // هذا الروت هو الذي يناديه زرار الباور (Panic Button) أو الـ AI عند انتهاء الـ 5 ثواني
    Route::prefix('alerts')->group(function () {
        Route::post('/send', [AlertController::class, 'sendAlert']); // إرسال اللوكيشن الحي فوراً
        Route::get('/history', [AlertController::class, 'history']); // سجل الاستغاثات السابقة
    });

    // --- نظام الإعدادات (Settings & Toggles) ---
    // هنا يتم تفعيل أو تعطيل الـ Panic Button والـ Voice Password
    Route::prefix('settings')->group(function () {
        Route::post('/toggles', [SettingsController::class, 'updateToggles']);
        Route::post('/language', [SettingsController::class, 'changeLanguage']);
        Route::post('/change-password', [SettingsController::class, 'changePassword']);
        Route::delete('/delete-account', [SettingsController::class, 'deleteAccount']);
        Route::post('/logout', [SettingsController::class, 'logout']); // تسجيل الخروج
    });

    // --- ميزة الكلمة السرية الصوتية (Voice Password) ---
    Route::post('/voice-password/save', [VoicePasswordController::class, 'store']);
    Route::get('/voice-password', [VoicePasswordController::class, 'show']); 


    // --- نظام الاستغاثة المستمر (SOS Mode) ---
    // يبدأ بعد إرسال الـ Alert الأول لمتابعة التسجيلات الصوتية
    Route::prefix('sos')->group(function () {
        Route::post('/start', [SosController::class, 'start']);           
        Route::post('/{id}/update-location', [SosController::class, 'updateLocation']); 
        Route::post('/{id}/upload-audio', [SosController::class, 'uploadAudio']);    
        Route::post('/{id}/stop', [SosController::class, 'stop']);        
    });

    // --- نظام التوقيت الآمن والمكالمة الوهمية (Timer & Fake Call) ---
    Route::post('/timer/start', [SafetyTimerController::class, 'startTimer']);   
    Route::post('/timer/cancel', [SafetyTimerController::class, 'cancelTimer']); 
    Route::post('/fake-call/schedule', [FakeCallController::class, 'schedule']); 

    // --- نظام البلاغات والحوادث (Incidents / Create Report) ---
    // هذا الجزء خاص بشاشة التبليغ عن حادثة وحفظ السجل
    Route::prefix('incidents')->group(function () {
        Route::post('/create', [IncidentController::class, 'store']); // إنشاء بلاغ جديد
        Route::get('/history', [IncidentController::class, 'history']); // عرض سجل البلاغات
    });

     Route::prefix('zones')->group(function () {
        // 1. جلب المناطق التلقائية (الأوتوماتيك - أحمر وأخضر)
        Route::get('/automatic', [ZoneController::class, 'getAutomaticZones']);
        
        // 2. إدارة المناطق الخاصة بالبنت (Manage Zones) [تجهيز للخطوة القادمة]
        Route::get('/personal', [ZoneController::class, 'getPersonalZones']);
        Route::post('/store', [ZoneController::class, 'storePersonalZone']);
    });

});