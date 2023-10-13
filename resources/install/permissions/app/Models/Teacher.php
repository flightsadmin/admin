<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'subject_id',
        'grade_id',
        'staff_number',
        'gender',
        'date_of_birth',
        'address',
    ];

    public function class()
    {
        return $this->belongsTo(Grade::class);
    }

    public function subjects()
    {
        return $this->hasMany(Subject::class);
    }
}
