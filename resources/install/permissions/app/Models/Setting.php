<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    public $fillable = [
        'site_email',
        'site_name',
        'site_title',
        'site_short_code',
        'site_description',
        'site_theme',
        'footer_text',
    ];
}