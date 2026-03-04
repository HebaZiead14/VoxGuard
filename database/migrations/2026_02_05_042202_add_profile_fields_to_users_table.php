<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * تشغيل التعديلات على قاعدة البيانات
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // 1. بيانات البروفايل الأساسية (شاشة Edit Profile)
            if (!Schema::hasColumn('users', 'first_name')) {
                $table->string('first_name')->nullable()->after('name');
            }
            if (!Schema::hasColumn('users', 'last_name')) {
                $table->string('last_name')->nullable()->after('first_name');
            }
            if (!Schema::hasColumn('users', 'phone_number')) {
                $table->string('phone_number')->nullable()->after('email');
            }
            if (!Schema::hasColumn('users', 'profile_image')) {
                $table->string('profile_image')->nullable()->after('phone_number');
            }

            // 2. معلومات الطوارئ (Emergency Information - شاشة Profile)
            if (!Schema::hasColumn('users', 'blood_type')) {
                $table->string('blood_type')->nullable(); // فصيلة الدم
            }
            if (!Schema::hasColumn('users', 'allergies')) {
                $table->string('allergies')->nullable();  // الحساسية
            }
            if (!Schema::hasColumn('users', 'medical_conditions')) {
                $table->text('medical_conditions')->nullable(); // الأمراض المزمنة
            }

            // 3. الإعدادات (Settings - شاشة Settings)
            if (!Schema::hasColumn('users', 'language')) {
                $table->string('language')->default('en'); 
            }
            if (!Schema::hasColumn('users', 'fake_call_enabled')) {
                $table->boolean('fake_call_enabled')->default(false);
            }
            if (!Schema::hasColumn('users', 'panic_button_enabled')) {
                $table->boolean('panic_button_enabled')->default(true);
            }
            if (!Schema::hasColumn('users', 'notifications_enabled')) {
                $table->boolean('notifications_enabled')->default(true);
            }
        });
    }

    /**
     * التراجع عن التعديلات
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'first_name', 'last_name', 'phone_number', 'profile_image',
                'blood_type', 'allergies', 'medical_conditions',
                'language', 'fake_call_enabled', 'panic_button_enabled', 'notifications_enabled'
            ]);
        });
    }
};