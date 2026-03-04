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
        Schema::table('users', function (Blueprint $table) {
           $table->integer('current_heart_rate')->nullable(); // لتخزين نبضات القلب الحالية
           $table->string('current_motion')->nullable();      // لتخزين الحالة (واقفة، بتجري، ثابتة)
           $table->integer('emergency_threshold')->default(120); // حد الخطر (لو زادت عنه يبعت SOS)
      });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
