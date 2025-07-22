<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('missions', function (Blueprint $table) {
            $table->date('return_date')->nullable()->change();
            $table->time('return_time')->nullable()->change();
            $table->integer('distonce')->nullable()->change();
            $table->integer('breakfasts_count')->nullable()->change();
            $table->integer('lounch_count')->nullable()->change();
            $table->integer('dinner_count')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('missions', function (Blueprint $table) {
            $table->date('return_date')->nullable(false)->change();
            $table->time('return_time')->nullable(false)->change();
            $table->integer('distonce')->nullable(false)->change();
            $table->integer('breakfasts_count')->nullable(false)->change();
            $table->integer('lounch_count')->nullable(false)->change();
            $table->integer('dinner_count')->nullable(false)->change();
        });
    }
};