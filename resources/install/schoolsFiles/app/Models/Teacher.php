<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Teacher extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'gender',
        'date_of_birth',
        'address',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function classes()
    {
        return $this->belongsToMany(Grade::class)->withTimestamps();
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class)->withTimestamps();
    }
}