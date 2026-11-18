<?php

declare(strict_types=1);

namespace App\Facades;

use PDO;

final class DB extends Facade
{
    protected static ?Facade $instance = null;

    private PDO $pdo;

    public function __construct(
        string $host,
        string $port,
        string $database,
        string $username,
        string $password,
    ) {
        $dsn = sprintf(
            'mysql:host=%s;port=%s;dbname=%s;charset=utf8mb4',
            $host,
            $port,
            $database,
        );

        $this->pdo = new PDO($dsn, $username, $password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]);
    }

    public static function pdo(): PDO
    {
        return self::instance()->pdo;
    }
}
