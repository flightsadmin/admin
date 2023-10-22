<?php

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

function setting($key)
{
    $defaultSettings = [
        'site_title'        => config('admin.appName', config('app.name')),
        'site_name'         => config('admin.appName', config('app.name')),
        'site_email'        => config('mail.from.address'),
        'site_short_code'   => 'DT',
        'site_theme'        => 'light',
        'site_logo'         => 'sites/default.png',
        'site_description'  => config('admin.description', config('app.name')),
        'footer_text'       => config('admin.footer_text', 'Made with 💖'),
    ];

    $setting = Cache::rememberForever('setting', function () use ($defaultSettings) {
        $firstSetting = Setting::first();
        return $firstSetting ?? (object) $defaultSettings;
    });

    return $setting->{$key} ?? $defaultSettings[$key] ?? null;
}