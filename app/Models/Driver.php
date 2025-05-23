<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'last_name',
        'phone_number',
        'national_id',
        'date_of_birth',
        'status',
    ];


    protected $casts = [
        'date_of_birth' => 'date', 
    ];

    //رابطه با جدول car
    public function car()
    {
        return $this->hasOne(Car::class);
    }
}

