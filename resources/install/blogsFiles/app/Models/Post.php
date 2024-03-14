<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'body',
        'image',
        'published_at',
        'featured',
        'user_id',
    ];

    protected $casts = [
        'published_at'  => 'datetime',
        'featured'      => 'boolean',
    ];

    public function getExcerpt()
    {
        return Str::limit(strip_tags($this->body), 200);
    }

    public function getAdminExcerpt()
    {
        return Str::limit(strip_tags($this->body), 1000);
    }

    public function getReadingTime()
    {
        $minutes = ceil(str_word_count(strip_tags($this->body)) / 250);
        return max(1, $minutes);
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function categories()
    {
        return $this->morphToMany(Category::class, 'taggable');
    }
    public function likes() {
        return $this->morphMany(Like::class, 'likeable', 'likes');
    }
    
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
}