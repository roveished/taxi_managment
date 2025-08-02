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
        Schema::table('missions', function (Blueprint $table) {
            $table->integer('sleep_count')->default(0)->after('dinner_count');
        });
    }
    
    public function down()
    {
        Schema::table('missions', function (Blueprint $table) {
            $table->dropColumn('sleep_count');
        });
    }
    
};
