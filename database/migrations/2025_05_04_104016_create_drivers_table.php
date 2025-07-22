<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('drivers', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable(false);
            $table->string('last_name')->nullable(false);
            $table->string('phone_number')->nullable(false);
            $table->bigInteger('national_id');
            $table->date('date_of_birth');
            $table->enum('status',['active','inactive'])->default('active');
            $table->timestamps();
        });
    }

    
    public function down(): void
    {
        Schema::dropIfExists('drivers');
    }
};
