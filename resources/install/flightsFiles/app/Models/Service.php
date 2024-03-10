<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_id',
        'flight_id',
        'start',
        'finish',
    ];

    public function flight()
    {
        return $this->belongsTo(Flight::class);
    }

    public function service()
    {
        return $this->belongsTo(ServiceList::class);
    }
}