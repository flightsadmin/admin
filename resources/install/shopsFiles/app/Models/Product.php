<?php

namespace App\Models;

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
        'quantity',
        'user_id',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'featured' => 'boolean',
    ];

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function categories()
    {
        return $this->morphToMany(Category::class, 'taggable');
    }
    
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function replies()
    {
        return $this->morphMany(Reply::class, 'replieable');
    }

    public function likes()
    {
        return $this->morphMany(Like::class, 'likeable');
    }
    
    public function cartItems()
    {
        return $this->belongsToMany(User::class, 'carts')->withTimestamps();
    }
}