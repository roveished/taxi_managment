<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('missions', function (Blueprint $table) {
            $table->id();
            $table->date('departure_date');
            $table->date('return_date');
            $table->time('departure_time');
            $table->time('return_time');
            $table->text('description')->nullable(false);
            $table->enum('car_type',['vip','passenger','truck']);
            $table->unsignedBigInteger('car_id');
            $table->foreign('car_id')->references('id')->on('cars');
            $table->unsignedBigInteger('driver_id');
            $table->foreign('driver_id')->references('id')->on('drivers');
            $table->enum('status',['ٌwait','inprogress ','finish']);
            $table->integer('distonce');
            $table->integer('breakfasts_count');
            $table->integer('lounch_count');
            $table->integer('dinner_count');
            $table->timestamps();
        });
    }

   
    public function down(): void
    {
        Schema::dropIfExists('missions');
    }
};
