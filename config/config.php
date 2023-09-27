<?php

/*
 * You can place your custom package configuration in here.
 */
return [
    // App Name
    "appName" => "Flight Admin",

    // Purpose
    "purpose" => "Flight Management",

    // Allow Social Login
    "sociallogin" => true,

    // Routes
    "adminRoute" => "admin",
    "blogRoute"  => "blog",

    // Modules
    "modules"   => [
        'flights' => true,
        'blog' => true,
        'shopping' => true,
    ],
];