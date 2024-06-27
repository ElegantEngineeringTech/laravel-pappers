<?php

// config for Elegantly/Pappers

return [

    'france' => [
        'token' => env('PAPPERS_FRANCE_TOKEN'),
        'version' => env('PAPPERS_FRANCE_VERSION'),
    ],

    'international' => [
        'token' => env('PAPPERS_INTERNATIONAL_TOKEN'),
        'version' => env('PAPPERS_INTERNATIONAL_VERSION'),
    ],

    'cache' => [
        'enabled' => true,
        'driver' => env('PAPPERS_CACHE_DRIVER', env('CACHE_DRIVER', 'file')),
        'expiry_seconds' => 604_800, // 1 week
    ],

    'rate_limit' => [
        'enabled' => false,
        'driver' => env('PAPPERS_RATE_LIMIT_DRIVER', env('CACHE_DRIVER', 'file')),
        'every_minute' => 30,
    ],
];
