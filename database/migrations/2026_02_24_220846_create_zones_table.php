<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up() {
    Schema::create('zones', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade'); // البنت صاحبة الزون
        $table->string('name'); // اسم المكان (مثلاً "بيت ماما" أو "كافيه")
        $table->decimal('latitude', 10, 8); 
        $table->decimal('longitude', 11, 8);
        $table->integer('radius')->default(250); // القطر بالمتر زي اللي في الصورة (250m)
        $table->enum('type', ['safe', 'danger']); // أخضر (Safe) أو أحمر (Red)
        $table->boolean('notify_family')->default(true); // تنبيه الأهل عند الدخول
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('zones');
    }
};
