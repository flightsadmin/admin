<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FlightDelay extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'duration',
        'description',
        'flight_id',
        'airline_id'
    ];

    public function delay()
    {
        return $this->belongsTo(FlightDelay::class);
    }
}