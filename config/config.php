<?php

declare(strict_types=1);

return [
    'app' => [
        'name'  => env('APP_NAME', 'App'),
        'debug' => env('APP_DEBUG', false),
    ],
    'db' => [
        'host'     => env('DB_HOST', '127.0.0.1'),
        'port'     => env('DB_PORT', '3306'),
        'database' => env('DB_DATABASE', 'blog'),
        'username' => env('DB_USERNAME', 'blog'),
        'password' => env('DB_PASSWORD', 'blog_secret'),
    ],
    'paths' => [
        'views'   => __DIR__ . '/../resources/views',
        'compile' => __DIR__ . '/../storage/smarty/compile',
        'cache'   => __DIR__ . '/../storage/smarty/cache',
    ],
];
