<?php

/*
 * You can place your custom package configuration in here.
 */
return [
    // App Name
    "appName" => "Shop Admin",

    // Description
    "description" => "Shop Management",

    // Footer
    "footer_text" => "Scaling Shopping Experience",

    // Allow Social Login
    "sociallogin" => false,

    // Routes
    "adminRoute" => "admin",
    "shopRoute"  => "shop",

    // Modules
    "modules"   => [
        'flights'   => true,
        'shop'      => true,
        'school'    => true,
    ],
];