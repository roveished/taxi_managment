<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('destinations', function (Blueprint $table) {
            $table->id();
            $table->string('origin')->nullable(false);
            $table->string('destination')->nullable(false);
            $table->integer('distonce')->nullable(false);
            $table->timestamps();
        });
    }

   
    public function down(): void
    {
        Schema::dropIfExists('destinations');
    }
};
