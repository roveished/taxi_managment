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
        Schema::create('cars_performance', function (Blueprint $table) {
            $table->id();
            $table->date('from_date')->nullable(false);
            $table->date('to_date')->nullable(false);
            $table->time('from_time')->nullable(false);
            $table->time('to_time')->nullable(false);
            $table->integer('total_distance_traveled');
            $table->integer('total_breakfast_count');
            $table->integer('total_lunch_count');
            $table->integer('total_dinner_count');
            $table->unsignedBigInteger('car_id');
            $table->foreign('car_id')->references('id')->on('cars');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cars_performance');
    }
};
