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
    Schema::table('trusted_contacts', function (Blueprint $table) {
        // ده السطر اللي هيضيف العمود "image" بعد خانة الـ relation
        $table->string('image')->after('relation')->nullable(); 
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
{
    Schema::table('trusted_contacts', function (Blueprint $table) {
        $table->dropColumn('image'); // ده الأمر اللي بيمسح العمود لو عملتي rollback
    });
}
};
