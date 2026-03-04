<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::create('fake_calls', function (Blueprint $table) {
        $table->id(); // الرقم التعريفي
        
        // ربط المكالمة باليوزر (علاقة ForeignKey)
        $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
        
        $table->string('caller_name'); // (Police, Mom, Dad)
        $table->dateTime('scheduled_at'); // الوقت اللي هترن فيه
        $table->string('ringtone')->default('default_ringtone'); // النغمة
        $table->string('status')->default('pending'); // عشان نعرف هل المكالمة رنت ولا لسه
        $table->string('trigger_type')->default('manual'); // عشان نعرف هل اليوزر طلبها يدوي ولا اشتغلت أوتوماتيك بسبب الاستغاثة
        
        $table->timestamps(); // created_at & updated_at
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fake_calls');
    }
};
