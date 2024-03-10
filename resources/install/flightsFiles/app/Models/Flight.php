<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Flight extends Model
{
    use HasFactory;

    protected $fillable = [
        'airline_id',
        'flight_no',
        'registration',
        'origin',
        'destination',
        'scheduled_time_arrival',
        'scheduled_time_departure',
        'flight_type'
    ];

    public function service()
    {
        return $this->hasMany(Service::class);
    }

    public function movement()
    {
        return $this->hasMany(Movement::class);
    }

    public function delays()
    {
        return $this->hasMany(FlightDelay::class);
    }

    public function airline()
    {
        return $this->belongsTo(Airline::class);
    }
}