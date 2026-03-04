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
    Schema::create('safety_timers', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained('users', 'user_id')->onDelete('cascade');
        $table->dateTime('expires_at'); // الوقت اللي الاستغاثة هتتبعت فيه لو اليوزر مأكدش سلامته
        $table->enum('status', ['active', 'completed', 'triggered', 'canceled'])->default('active');
        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('safety_timers');
    }
};
