<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'student_parent_id',
        'class_id',
        'roll_number',
        'gender',
        'date_of_birth',
        'address',
    ];

    public function parent()
    {
        return $this->belongsTo(StudentParent::class, 'student_parent_id');
    }
    
    public function class()
    {
        return $this->belongsTo(ClassModel::class);
    }
}
