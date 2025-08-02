<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('missions', function (Blueprint $table) {
            $table->boolean('canceled')->default(false)->after('status');
        });

        Schema::table('destination_mission', function (Blueprint $table) {
            $table->boolean('canceled')->default(false)->after('order');
        });
    }

    public function down(): void
    {
        Schema::table('missions', function (Blueprint $table) {
            $table->dropColumn('canceled');
        });

        Schema::table('destination_mission', function (Blueprint $table) {
            $table->dropColumn('canceled');
        });
    }
};
