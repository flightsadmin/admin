<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'guardian_id',
        'grade_id',
        'gender',
        'date_of_birth',
        'address',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function parent()
    {
        return $this->belongsTo(Guardian::class, 'guardian_id');
    }

    public function grade()
    {
        return $this->belongsTo(Grade::class);
    }
}