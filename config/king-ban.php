<?php

return [
    'banned' => [
        'endpoints' => env('BANNED_ENDPOINTS', 3),
        'ips' => env('BANNED_IPS', 1000),
        'iso_codes' => env('BANNED_ISO_CODES', 1000),
    ]
];
