<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'guardian_id',
        'grade_id',
        'roll_number',
        'gender',
        'date_of_birth',
        'address',
    ];

    public function parent()
    {
        return $this->belongsTo(Guardian::class, 'guardian_id');
    }
    
    public function grade()
    {
        return $this->belongsTo(Grade::class);
    }
}