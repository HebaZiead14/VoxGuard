<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('incidents', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade'); // البنت اللي بلغت
        $table->string('type'); // نوع الحادثة (Harassment, Unsafe Area)
        $table->text('description')->nullable(); // وصف الحادثة
        $table->string('location_text')->nullable(); // العنوان المكتوب
        $table->decimal('latitude', 10, 8)->nullable(); // الإحداثيات
        $table->decimal('longitude', 11, 8)->nullable();
        $table->string('media_path')->nullable(); // مسار الصورة أو الصوت
        $table->enum('status', ['pending', 'reviewed', 'action_taken', 'closed'])->default('pending'); // حالة البلاغ
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incidents');
    }
};
