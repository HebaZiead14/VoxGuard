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
    Schema::table('users', function (Blueprint $table) {
        $table->timestamp('last_seen')->nullable(); // عشان نعرف هو Online ولا لأ
        $table->decimal('latitude', 10, 8)->nullable(); // إحداثيات الموقع (العرض)
        $table->decimal('longitude', 11, 8)->nullable(); // إحداثيات الموقع (الطول)
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
