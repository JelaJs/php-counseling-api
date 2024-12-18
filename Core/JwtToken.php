<?php

namespace Core;

class JwtToken {
    private static $decodedJwt;
    
    public static function set($data) {
        self::$decodedJwt = $data;
    }
    
    public static function get() {
        return self::$decodedJwt;
    }
}