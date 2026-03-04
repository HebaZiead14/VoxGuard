<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up(): void {
    Schema::create('voice_passwords', function (Blueprint $table) {
        $table->id();
        // ده بيربط الجدول بجدول المستخدمين (عشان نعرف كلمة السر دي بتاعة مين)
        $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); 
        
        // دي الكلمة اللي اليوزر هيقولها (الخطوة 7)
        $table->string('phrase'); 
        
        // ده الرقم اللي بييجي من الـ Slider (الحساسية)
        $table->integer('sensitivity')->default(50); 
        
        $table->timestamps(); // بيسجل وقت الإنشاء والتعديل تلقائي
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('voice_passwords');
    }
};
