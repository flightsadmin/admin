<?php

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

function setting($key)
{
    $defaultSettings = [
        'site_title'        => 'Default Title',
        'site_name'         => 'Default Name',
        'site_email'        => 'default@gmail.com',
        'site_short_code'   => 'DT',
        'site_theme'        => 'light',
        'site_description'  => 'Default Site Description',
        'footer_text'       => 'default footer text',
    ];

    $setting = Cache::rememberForever('setting', function () use ($defaultSettings) {
        $firstSetting = Setting::first();
        return $firstSetting ?? (object) $defaultSettings;
    });

    return $setting->{$key} ?? $defaultSettings[$key] ?? null;
}