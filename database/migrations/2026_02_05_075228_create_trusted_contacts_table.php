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
    Schema::create('trusted_contacts', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade'); // ربط بصاحب الحساب
        $table->string('name');
        $table->string('phone');
        $table->string('relation')->nullable();
        $table->boolean('is_online')->default(false); // عشان ميزة الـ Online
        $table->string('status')->default('Nearby');  // عشان ميزة الـ Nearby
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trusted_contacts');
    }
};
