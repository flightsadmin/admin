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

    public function classes()
    {
        return $this->belongsToMany(Grade::class, 'grade_teacher')->withTimestamps();
    }
    
    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'subject_teacher')->withTimestamps();
    }
}