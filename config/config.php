<?php

/*
 * You can place your custom package configuration in here.
 */
return [
    'default' => [
        'site_name'         => config('app.name'),
        'site_short_code'   => 'DT',
        'site_email'        => config('mail.from.address'),
        'site_phone'        => '+254722000000',
        'site_logo'         => 'sites/default.png',
        'site_theme'        => 'light',
        'site_currency'     => 'kes',
        'date_format'       => 'd/m/Y',
        'time_format'       => 'H:i:s',
        'footer_text'       => 'Made with 💖',
        'site_description'  => 'Schedule Management',
    ],

    // Allow Social Login
    "sociallogin" => false,

    // Routes
    "adminRoute"   => "admin",

    // Modules
    "modules"   => [
        'flights'   => true,
    ],
];