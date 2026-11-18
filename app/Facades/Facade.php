<?php

declare(strict_types=1);

namespace App\Facades;

use InvalidArgumentException;
use RuntimeException;

abstract class Facade
{
    protected static ?Facade $instance = null;

    /**
     * @param static $instance
     */
    final public static function register(Facade $instance): void
    {
        if (!$instance instanceof static) {
            throw new InvalidArgumentException(sprintf(
                '%s can only register an instance of %s, %s given.',
                static::class,
                static::class,
                $instance::class,
            ));
        }

        if (static::$instance !== null) {
            throw new RuntimeException(sprintf('%s is already registered.', static::class));
        }

        static::$instance = $instance;
    }

    final public static function instance(): static
    {
        if (static::$instance === null) {
            throw new RuntimeException(sprintf('%s is not registered.', static::class));
        }

        return static::$instance;
    }
}
