<?php

return [
    'mode' => env('KASHIER_MODE', 'test'),
    
    'live' => [
        'base_url' => 'https://checkout.kashier.io',
        'api_key' => env('KASHIER_LIVE_API_KEY', ''),
        'mid' => env('KASHIER_LIVE_MID', ''),
    ],
    
    'test' => [
        'base_url' => 'https://checkout.kashier.io',
        'api_key' => env('KASHIER_TEST_API_KEY', '49c02cfa-8a4e-4120-8aa2-b154a6d08573'),
        'mid' => env('KASHIER_TEST_MID', 'MID-3552-454'),
    ],
];
