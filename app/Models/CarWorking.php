<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CarWorking extends Model
{
    use HasFactory;

    protected $table = 'cars_working';

    protected $fillable = [
        'car_id',
        'driver_id',
        'work_status',
        'date',
        'hours_number',
        'description',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public function car()
    {
        return $this->belongsTo(Car::class);
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }
}
