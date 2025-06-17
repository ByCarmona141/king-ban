<?php

return [
    'banned' => [
        'seconds' => env('SECONDS_BANNED', 3600),
        'endpoints' => env('BANNED_ENDPOINTS', NULL),
        'ips' => env('BANNED_IPS', NULL),
        'iso_codes' => env('BANNED_ISO_CODES', NULL),
    ]
];
