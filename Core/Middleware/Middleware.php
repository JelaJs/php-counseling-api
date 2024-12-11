<?php

namespace Core\Middleware;

class Middleware {
    public const MAP = [
        'guest' => Guest::class,
        'auth' => Auth::class
    ];

    public static function resolve($key) {

        if(!$key) {
            return;
        }

        //ako saljemo nepostojeci key, vr. ce biti false
        $middleware = static::MAP[$key] ?? false;

        if(!$middleware) {
            throw new \Exception("No matching middleware for key {$key}.");
        }

        (new $middleware)->handle();
    }
}