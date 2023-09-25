<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Airline extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 
        'iata_code', 
        'base',
        'base_iata_code'
    ];

    public function registration()
    {
        return $this->hasMany(Registration::class);
    }

    public function routes()
    {
        return $this->hasMany(Route::class);
    }

    public function delays()
    {
        return $this->hasMany(AirlineDelayCode::class);
    }
}