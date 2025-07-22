<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    protected $fillable = [
        'car_plate',
        'driver_id',
        'manufacture_year',
        'car_model',
        'car_type',
        'status',
        'collaboration_end_date',
        'owner_name',
        'owner_lsetname',
        'owner_phonenumber',
        'owner_nationl_id',
    ];

    protected $casts = [
        'manufacture_year' => 'date',
        'collaboration_end_date' => 'date',
    ];

  
    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }
}
