<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. إنشاء جدول المستخدمين بالشكل الجديد
        Schema::create('users', function (Blueprint $table) {
            $table->id('user_id'); 
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('phone')->unique();   
            $table->string('password');
            $table->string('blood_type')->nullable(); // مجهز لبيانات الطوارئ
            $table->text('allergies')->nullable();    // مجهز لبيانات الطوارئ
            $table->text('medical_conditions')->nullable(); // مجهز لبيانات الطوارئ
            $table->rememberToken();
            $table->timestamps();
        });

        // 2. إنشاء جدول التوكنز (اللازم لعمل الـ API)
        Schema::create('personal_access_tokens', function (Blueprint $table) {
            $table->id();
            $table->morphs('tokenable'); // يربط التوكن باليوزر
            $table->string('name');
            $table->string('token', 64)->unique();
            $table->text('abilities')->nullable();
            $table->timestamp('last_used_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('personal_access_tokens');
        Schema::dropIfExists('users');
    }
};