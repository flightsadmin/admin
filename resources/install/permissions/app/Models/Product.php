<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'description',
        'image',
        'published_at',
        'featured',
        'user_id',
    ];

    protected $casts = [
        'published_at'  => 'datetime',
        'featured'      => 'boolean',
    ];

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function likes() {
        return $this->belongsToMany(User::class, 'product_like')->withTimestamps();
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function cartItems() {
        return $this->belongsToMany(User::class, 'carts')->withTimestamps();
    }
}