<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarInspection extends Model
{
    use HasFactory;

    protected $table = 'cars_inspection';

    protected $fillable = [
        'car_id',
        'driver_id',
        'description',
        'inspection_date',
        'expiration_date',
        'status',
        'user_id',

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
    ];

    protected $casts = [
        'inspection_date' => 'date',
        'expiration_date' => 'date',

        'front_glass' => 'boolean',
        'rear_glass' => 'boolean',
        'toolbox' => 'boolean',
        'first_aid_kit' => 'boolean',
        'spare_tire' => 'boolean',
        'front_tires' => 'boolean',
        'rear_tires' => 'boolean',
        'front_lights' => 'boolean',
        'rear_lights' => 'boolean',
        'front_fog_lights' => 'boolean',
        'rear_fog_lights' => 'boolean',
        'brake_system' => 'boolean',
        'mechanical_condition' => 'boolean',
        'cabin_appearance' => 'boolean',
        'body_appearance' => 'boolean',
    ];

    public function car()
    {
        return $this->belongsTo(Car::class);
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
