<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('permit', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('driver_id');
            $table->foreign('driver_id')->references('id')->on('drivers');
            $table->date('issue_date');
            $table->date('expiration_date');
            $table->enum('status',['valid','invalid']);
            $table->timestamps();
        });
    }

    
    public function down(): void
    {
        Schema::dropIfExists('permit');
    }
};
