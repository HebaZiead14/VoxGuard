<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
public function up(): void
{
    Schema::create('alert_logs', function (Blueprint $table) {
        $table->id();
        
        // التعديل هنا: نحدد اسم العمود واسم الجدول واسم الـ Primary Key بوضوح
        $table->foreignId('user_id')
              ->constrained('users', 'user_id') // تحديد إن الجدول اسمه users والعمود اسمه user_id
              ->onDelete('cascade'); 
        
        $table->string('lat')->nullable();
        $table->string('long')->nullable();
        $table->string('status')->default('sent');
        $table->timestamps();
    });
}
};
