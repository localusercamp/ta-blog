<?php

declare(strict_types=1);

return [
    'app' => [
        'name' => 'Логос',
        'debug' => filter_var(getenv('APP_DEBUG') ?: '0', FILTER_VALIDATE_BOOL),
    ],
    'db' => [
        'host' => getenv('DB_HOST') ?: '127.0.0.1',
        'port' => (int) (getenv('DB_PORT') ?: 3306),
        'database' => getenv('DB_DATABASE') ?: 'blog',
        'username' => getenv('DB_USERNAME') ?: 'blog',
        'password' => getenv('DB_PASSWORD') ?: 'blog_secret',
    ],
    'paths' => [
        'templates' => __DIR__ . '/../templates',
        'compile' => __DIR__ . '/../storage/smarty/compile',
        'cache' => __DIR__ . '/../storage/smarty/cache',
    ],
];
