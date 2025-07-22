<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('cars_inspection', function (Blueprint $table) {
            $table->boolean('front_glass')->default(false)->after('status');
            $table->boolean('rear_glass')->default(false)->after('front_glass');
            $table->boolean('toolbox')->default(false)->after('rear_glass');
            $table->boolean('first_aid_kit')->default(false)->after('toolbox');
            $table->boolean('spare_tire')->default(false)->after('first_aid_kit');
            $table->boolean('front_tires')->default(false)->after('spare_tire');
            $table->boolean('rear_tires')->default(false)->after('front_tires');
            $table->boolean('front_lights')->default(false)->after('rear_tires');
            $table->boolean('rear_lights')->default(false)->after('front_lights');
            $table->boolean('front_fog_lights')->default(false)->after('rear_lights');
            $table->boolean('rear_fog_lights')->default(false)->after('front_fog_lights');
            $table->boolean('brake_system')->default(false)->after('rear_fog_lights');
            $table->boolean('mechanical_condition')->default(false)->after('brake_system');
            $table->boolean('cabin_appearance')->default(false)->after('mechanical_condition');
            $table->boolean('body_appearance')->default(false)->after('cabin_appearance');
        });
    }

    public function down(): void
    {
        Schema::table('cars_inspection', function (Blueprint $table) {
            $table->dropColumn([
                'front_glass',
                'rear_glass',
                'toolbox',
                'first_aid_kit',
                'spare_tire',
                'front_tires',
                'rear_tires',
                'front_lights',
                'rear_lights',
                'front_fog_lights',
                'rear_fog_lights',
                'brake_system',
                'mechanical_condition',
                'cabin_appearance',
                'body_appearance',
            ]);
        });
    }
};
