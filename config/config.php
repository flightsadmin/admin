<?php

/*
 * You can place your custom package configuration in here.
 */
return [
    // App Name
    "appName" => "School Admin",

    // Purpose
    "purpose" => "School Management",

    // Allow Social Login
    "sociallogin" => false,

    // Routes
    "adminRoute" => "admin",
    "blogRoute"  => "blog",

    // Modules
    "modules"   => [
        'flights'   => true,
        'blog'      => true,
        'shopping'  => true,
    ],
];