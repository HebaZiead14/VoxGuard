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
        Schema::create('trips', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->onDelete('cascade'); // البنت صاحبة الرحلة
    $table->string('destination_name'); // اسم المكان (مثلاً: الجامعة)
    $table->decimal('destination_lat', 10, 8); // إحداثيات الوصول
    $table->decimal('destination_long', 11, 8);
    $table->integer('estimated_time'); // الوقت المتوقع بالدقائق
    $table->text('safety_notes')->nullable(); // الملاحظات (safety notes)
    
    // ربط الرحلة بالشخص الموثوق (Trust Contact)
    $table->foreignId('trusted_contact_id')->constrained('trusted_contacts')->onDelete('cascade');
    // حالة الرحلة: بدأت، وصلت، توقفت، أو حالة طوارئ
    $table->enum('status', ['started', 'reached', 'stopped', 'emergency'])->default('started');
    
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trips');
    }
};
