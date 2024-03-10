<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Relations\HasMany;
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

    public function likes() {
        return $this->belongsToMany(User::class, 'post_like')->withTimestamps();
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}