<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{public function up(): void
{
    Schema::table('emergency_contacts', function (Blueprint $table) {
        $table->string('first_name')->after('user_id');
        $table->string('last_name')->after('first_name');
        $table->string('relation')->nullable()->after('phone');
        
        // السطر ده هو اللي بيمسح المشكلة
        $table->dropColumn('name'); 
    });

}

public function down(): void
{
    Schema::table('emergency_contacts', function (Blueprint $table) {
        $table->dropColumn(['first_name', 'last_name', 'relation']);
    });
}
};
