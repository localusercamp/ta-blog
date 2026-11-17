<?php

declare(strict_types=1);

namespace App\Core;

use PDO;

final class Database
{
    public static function connect(
        string $host,
        string $port,
        string $database,
        string $username,
        string $password,
    ): PDO {
        $dsn = sprintf(
            'mysql:host=%s;port=%d;dbname=%s;charset=utf8mb4',
            $host,
            $port,
            $database,
        );

        return new PDO($dsn, $username, $password);
    }
}
