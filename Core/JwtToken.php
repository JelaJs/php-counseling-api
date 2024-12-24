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

    /*public static function checkTime($tokenTime) {
        $timeLimit = time() - 600;

        if($tokenTime < $timeLimit) {
            throw new \Exception("Token expired");
        }
    }*/
}