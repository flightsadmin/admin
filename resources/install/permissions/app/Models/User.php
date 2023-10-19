<?php

namespace App\Models;

use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
	use HasRoles, SoftDeletes;
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
		'phone',
		'photo',
		'title',
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function likes() {
        return $this->belongsToMany(Product::class, 'product_like')->withTimestamps();
    }
    
    public function hasLiked(Product $product) {
        return $this->likes()->where('product_id', $product->id)->exists();
    }
    
    public function cartItems() {
        return $this->belongsToMany(Product::class, 'carts', 'user_id', 'product_id')->withTimestamps();
    }
    
    public function hasAdded(Product $product) {
        return $this->cartItems()->where('product_id', $product->id)->exists();
    }
}
