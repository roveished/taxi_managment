<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mission extends Model
{
    use HasFactory;

    protected $fillable = [
        'departure_date',
        'return_date',
        'departure_time',
        'return_time',
        'description',
        'car_type',
        'car_id',
        'driver_id',
        'status',
        'distonce',
        'breakfasts_count',
        'lounch_count',
        'dinner_count',
    ];

   
    public function car()
    {
        return $this->belongsTo(Car::class);
    }

   
    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }
    public function destinations()
{
    return $this->belongsToMany(Destination::class, 'destination_mission', 'mission_id', 'destinations_id');
}

}
