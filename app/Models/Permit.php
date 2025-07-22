<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permit extends Model
{
    use HasFactory;
    protected $table = 'permit';

    protected $fillable = [
        'driver_id',
        'issue_date',
        'expiration_date',
        'status',
    ];

   
    public function driver()
    {
        return $this->belongsTo(Driver::class, 'driver_id');
    }
}
