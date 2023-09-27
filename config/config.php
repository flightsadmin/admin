<?php

/*
 * You can place your custom package configuration in here.
 */
return [
    // App Name
    "appName" => "My App",

    // Purpose
    "purpose" => "Flight Management",

    // Allow Social Login
    "sociallogin" => true,

    // Routes
    "adminRoute" => "admin",
    "blogRoute"  => "posts",

    // Modules
    "modules"   => [
        'flights' => true,
        'blog' => true,
        'shopping' => true,
    ],
];