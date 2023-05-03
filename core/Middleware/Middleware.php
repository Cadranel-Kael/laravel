<?php

namespace Core\Middleware;

use Exception;

class Middleware
{
    protected const MAP = [
        'guest' => Guest::class,
        'authenticated' => Authenticated::class,
    ];

    public static function resolve(string|null $name = null): void
    {

        if (!array_key_exists($name, self::MAP)) {
            throw new Exception("This middleware doesn't exist");
        }
        $middleware = self::MAP[$name];
        (new $middleware())->handle();
    }
}
