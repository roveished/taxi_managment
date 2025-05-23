<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Http\Request;

class Destination extends Model
{
    use HasFactory;

    protected $fillable = [
        'origin',
        'destination',
        'distonce',
    ];


    protected $casts = [
        'date_of_birth' => 'date', 
    ];

    

}

