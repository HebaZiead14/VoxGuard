<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('voice_passwords', function (Blueprint $table) {
            // إضافة خانة للـ Timer بقيمة افتراضية 10 ثواني
            $table->integer('timer_duration')->default(10)->after('sensitivity');
        });
    }

    public function down(): void
    {
        Schema::table('voice_passwords', function (Blueprint $table) {
            // حذف الخانة في حال احتجنا نرجع في كلامنا
            $table->dropColumn('timer_duration');
        });
    }
};
