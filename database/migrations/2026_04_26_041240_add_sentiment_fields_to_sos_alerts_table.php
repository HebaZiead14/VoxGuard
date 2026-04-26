<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('sos_alerts', function (Blueprint $table) {
            // لو العمود مش موجود ضيفيه
            if (!Schema::hasColumn('sos_alerts', 'emotion_state')) {
                $table->string('emotion_state')->nullable()->after('trigger_type');
            }
            // لو حابة تتأكدي إن الـ audio_path موجود أو تعدلي مكانه
            if (!Schema::hasColumn('sos_alerts', 'audio_path')) {
                $table->string('audio_path')->nullable()->after('emotion_state');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sos_alerts', function (Blueprint $table) {
            //
        });
    }
};
