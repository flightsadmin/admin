<?php

return [
    'default' => [
        'site_name'         => config('app.name'),
        'site_short_code'   => 'DT',
        'site_email'        => 'admin@site.com',
        'site_phone'        => '+254722000000',
        'site_logo'         => 'sites/default.png',
        'site_theme'        => 'light',
        'site_currency'     => 'kes',
        'date_time_format'  => 'F j, Y, g:i A',
        'date_format'       => 'd/m/Y',
        'time_format'       => 'H:i:s',
        'week_start'        => 'monday',
        'min_no_of_staff'   => 3,
        'max_no_of_staff'   => 8,
        'footer_text'       => 'Made with 💖',
        'site_description'  => 'Schedule Management',
    ],

    // Allow Social Login
    "sociallogin" => false,

    // Routes
    "adminRoute"  => "admin",
    "flightRoute" => "flight",
    "rosterRoute" => "roster",
    "schoolRoute" => "school",
    "blogRoute"   => "blog",
    "shopRoute"   => "shop",

    // Modules
    "modules"   => [
        'flights'  => true,
        'rosters'  => true,
        'school'   => true,
        'shop'     => true,
        'blog'     => true,
    ],
];