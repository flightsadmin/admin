<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Timetable extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "start_time",
        "end_time",
        "grade_id",
    ];

    public function grade()
    {
        return $this->belongsTo(Grade::class);
    }
}
