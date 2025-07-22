<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::table('cars_working', function (Blueprint $table) {
            $table->integer('hours_number')->after('work_status'); 
        });
    }

    
    public function down(): void
    {
        Schema::table('cars_working', function (Blueprint $table) {
            $table->dropColumn('hours_number');
        });
    }
};
