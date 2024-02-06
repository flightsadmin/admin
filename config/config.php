<?php

/*
 * You can place your custom package configuration in here.
 */
return [
    // App Name
    "appName" => "Blog Admin",

    // Purpose
    "purpose" => "Blog Management",

    // Allow Social Login
    "sociallogin" => true,

    // Routes
    "adminRoute" => "admin",
    "blogRoute"  => "blog",

    // Modules
    "modules"   => [
        'blog'      => true,
        'flights'   => true,
        'shopping'  => true,
    ],
];