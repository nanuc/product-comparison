<?php

return [
    'database' => 'mysql',
    'deep-l' => [
        'endpoint' => env('DEEP_L_ENDPOINT', 'https://api-free.deepl.com/v2/translate'),
        'auth-key' => env('DEEP_L_AUTH_KEY'),
    ],
];
