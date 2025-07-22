<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable(false);
            $table->string('last_name')->nullable(false);
            $table->bigInteger('username')->nullable(false)->unique();
            $table->string('password',255)->nullable(false);
            $table->enum('role',['taxi_management','inspector'])->nullable(false);
            $table->enum('status',['active','inactive'])->default('active');
            $table->string('phone_number')->nullable(false);
            $table->rememberToken();
            $table->timestamps();
        });
    }

   
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
