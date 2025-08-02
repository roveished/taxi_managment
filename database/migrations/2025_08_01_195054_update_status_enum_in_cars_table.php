<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateStatusEnumInCarsTable extends Migration
{
    public function up()
    {
        Schema::table('cars', function (Blueprint $table) {
            $table->enum('status', ['active', 'inactive', 'inmission'])->default('active')->change();
        });
    }

    public function down()
    {
        Schema::table('cars', function (Blueprint $table) {
            $table->enum('status', ['ٌinmission', 'active ', 'inactive'])->change();
        });
    }
}
