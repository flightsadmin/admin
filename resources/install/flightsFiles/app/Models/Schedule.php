<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeFetchRoster($query)
    {
        return $query->with('user')
            ->whereBetween('date', [now()->startOfMonth(), now()->endOfMonth()])
            ->orderBy('date')
            ->get()
            ->groupBy('user_id')
            ->toArray();
    }
}
