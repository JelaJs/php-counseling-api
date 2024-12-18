<?php

namespace Core;

class Validator {
    public static function email($value) {
       return filter_var($value, FILTER_VALIDATE_EMAIL);
    }

    public static function string($value, $min = 1, $max = INF) {
        $value = trim($value);

        return strlen($value) >= $min && strlen($value) <= $max;
    }

    public static function inputs(...$values) {
        foreach($values as $value) {
            if(trim($value) === "" || $value === null) {
                return false;
            }
        }
        return true;
    }

    public static function type($value) {
        return strtolower($value) !== "advisor" && strtolower($value) !== "listener";
    }
}