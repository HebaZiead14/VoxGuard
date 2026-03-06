<?php

use Illuminate\Http\Request; // الخط الأورنج هنا طبيعي لأن الكلمة مش مستخدمة تحت، سيبيه عادي
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
use App\Http\Controllers\Api\WearableController;
use App\Http\Controllers\Api\IncidentController;
use App\Http\Controllers\Api\ZoneController;
use App\Http\Controllers\Api\TripController;

/*
|--------------------------------------------------------------------------
| API Routes - VoxGuard Project
|--------------------------------------------------------------------------
*/

/* 1. المسارات العامة (Public Routes) */
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
Route::post('/reset-password', [AuthController::class, 'resetPassword']);

/* 2. المسارات المحمية (Protected Routes) */
Route::middleware('auth:sanctum')->group(function () {

    // --- نظام البروفايل والمعلومات الطبية ---
    Route::prefix('profile')->group(function () {
        Route::get('/', [ProfileController::class, 'show']);
        Route::post('/update', [ProfileController::class, 'update']);
        Route::get('/activity-log', [ProfileController::class, 'activityLog']);
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
    Route::prefix('wearable')->group(function () {
        Route::post('/connect', [WearableController::class, 'connectDevice']);
        Route::post('/update-health', [WearableController::class, 'updateHealthData']);
    });

    // --- نظام التنبيهات الفورية (Alerts & Panic Button) ---
    Route::prefix('alerts')->group(function () {
        Route::post('/send', [AlertController::class, 'sendAlert']);
        Route::get('/history', [AlertController::class, 'history']);
    });

    // --- نظام الإعدادات (Settings & Toggles) ---
    Route::prefix('settings')->group(function () {
        Route::post('/toggles', [SettingsController::class, 'updateToggles']);
        Route::post('/language', [SettingsController::class, 'changeLanguage']);
        Route::post('/change-password', [SettingsController::class, 'changePassword']);
        Route::delete('/delete-account', [SettingsController::class, 'deleteAccount']);
        Route::post('/logout', [SettingsController::class, 'logout']);
    });

    // --- ميزة الكلمة السرية الصوتية (Voice Password) ---
    Route::post('/voice-password/save', [VoicePasswordController::class, 'store']);
    Route::get('/voice-password', [VoicePasswordController::class, 'show']);

    // --- نظام الاستغاثة المستمر (SOS Mode) ---
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

    // --- نظام البلاغات والحوادث (Incidents) ---
    Route::prefix('incidents')->group(function () {
        Route::post('/create', [IncidentController::class, 'store']);
        Route::get('/history', [IncidentController::class, 'history']);
    });

    // --- نظام المناطق (Zones System) ---
    Route::prefix('zones')->group(function () {
        Route::get('/', [ZoneController::class, 'index']);
        Route::post('/', [ZoneController::class, 'store']);
        Route::delete('/{id}', [ZoneController::class, 'destroy']);
    });

    // --- نظام تتبع الرحلات (Trip Tracking) - جديد ومهم جداً ---
    Route::prefix('trips')->group(function () {
        Route::post('/start', [TripController::class, 'startTrip']);       // بدء الرحلة
        Route::post('/{id}/update-location', [TripController::class, 'updateLocation']); // تحديث اللوكيشن لايف
        Route::post('/{id}/update-status', [TripController::class, 'updateStatus']); // التنبيه و SOS
        Route::post('/{id}/end', [TripController::class, 'endTrip']);         // الوصول بالسلامة
        Route::get('/test-api', function (Request $request) {
            return response()->json(['message' => 'API is working!']);
        });
    });

});
