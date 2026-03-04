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
    Schema::create('global_zones', function (Blueprint $table) {
        $table->id();
        $table->string('name'); // اسم المنطقة (مثل: مركز شرطة)
        $table->decimal('latitude', 10, 8); // خط العرض
        $table->decimal('longitude', 11, 8); // خط الطول
        $table->integer('radius')->default(500); // القطر الافتراضي للمنطقة بالمتر
        $table->enum('type', ['safe', 'danger']); // نوع المنطقة: أمان (أخضر) أم خطر (أحمر)
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('global_zones');
    }
};
