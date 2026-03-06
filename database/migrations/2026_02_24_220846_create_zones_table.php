<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up() {
    Schema::create('zones', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade'); 
        $table->string('name'); 
        $table->decimal('latitude', 10, 8); 
        $table->decimal('longitude', 11, 8);
        $table->integer('radius')->default(250); 
        $table->enum('type', ['safe', 'moderate', 'high_alert']); 
        $table->string('category')->nullable(); // (Home, Work, Commercial, Industrial)
        $table->string('crowd_level')->default('medium'); 
        $table->string('lighting')->default('medium');    
        $table->boolean('is_automatic')->default(false); // لو true يبقى أوتوماتيك، لو false يبقى البنت اللي ضايفاه
        $table->boolean('notify_family')->default(true); 
        $table->timestamps();
    });
}

    public function down(): void
    {
        Schema::dropIfExists('zones');
    }
};