<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * تشغيل الميجريشن لإضافة خانة الحالة
     */
    public function up(): void
    {
        Schema::table('fake_calls', function (Blueprint $table) {
            // إضافة خانة status وتخلي قيمتها الافتراضية pending
            $table->string('status')->default('pending')->after('ringtone');
        });
    }

    /**
     * التراجع عن الإضافة في حال احتجنا لذلك
     */
    public function down(): void
    {
        Schema::table('fake_calls', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
