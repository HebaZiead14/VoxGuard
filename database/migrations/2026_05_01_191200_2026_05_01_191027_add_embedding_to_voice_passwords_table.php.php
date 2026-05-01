<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // لازم نحدد اسم الجدول هنا وهو voice_passwords
        Schema::table('voice_passwords', function (Blueprint $table) {
            // إضافة عمود الـ embedding بعد عمود الـ timer_duration
            $table->longText('embedding')->nullable()->after('timer_duration');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('voice_passwords', function (Blueprint $table) {
            // حذف العمود في حالة عمل rollback
            $table->dropColumn('embedding');
        });
    }
};