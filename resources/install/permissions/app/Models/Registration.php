<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Registration extends Model
{
    use HasFactory;

    protected $fillable = [
        'registration', 
        'aircraft_type', 
        'airline_id'
    ];

    public function airline()
    {
        return $this->belongsTo(Airline::class);
    }
}
