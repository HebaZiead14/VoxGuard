<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * إضافة عمود audio_path لتخزين رابط ملفات الصوت المسجلة
     */
    public function up(): void
    {
        Schema::table('fake_calls', function (Blueprint $table) {
            // إضافة العمود بعد الـ voice_script ويكون nullable عشان لو فيه مكالمات قديمة
            $table->string('audio_path')->nullable()->after('voice_script');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('fake_calls', function (Blueprint $table) {
            // حذف العمود في حالة عمل rollback للميجريشن
            if (Schema::hasColumn('fake_calls', 'audio_path')) {
                $table->dropColumn('audio_path');
            }
        });
    }
};