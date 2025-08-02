<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DestinationMission extends Model
{
    use HasFactory;

    protected $table = 'destination_mission';

    protected $fillable = [
        'mission_id',
        'destinations_id',
        'order',
        'canceled',
    ];

    // روابط
    public function mission()
    {
        return $this->belongsTo(Mission::class);
    }

    public function destination()
    {
        return $this->belongsTo(Destination::class, 'destinations_id');
    }
}
