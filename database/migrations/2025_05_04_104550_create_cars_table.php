<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   
    public function up(): void
    {
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->string('car_plate');
            $table->unsignedBigInteger('driver_id');
            $table->foreign('driver_id')->references('id')->on('drivers');
            $table->date('manufacture_year');
            $table->string('car_model');
            $table->enum('car_type',['vip','passenger','truck']);
            $table->enum('status',['ٌinmission','active ','inactive']);
            $table->date('collaboration_end_date')->nullable()->default(null);
            $table->string('owner_name');
            $table->string('owner_lsetname');
            $table->string('owner_phonenumber');
            $table->bigInteger('owner_nationl_id');
            $table->timestamps();
        });
    }

   
    public function down(): void
    {
        Schema::dropIfExists('cars');
    }
};
