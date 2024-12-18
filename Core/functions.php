<?php

function dd($value) {
    echo "<pre>";
    var_dump($value);
    echo "</pre>";

    die();
}

function base_path($path) {
    return BASE_PATH . $path;
 }
 
function view($path, $attributes = []) {
    extract($attributes);

    require base_path('views/' . $path);
}

function errorResponse($code, $message) {
    http_response_code($code);
    echo json_encode(["error" => $message]);
    die();
}

function dataResponse($data) {
    echo json_encode([
        "data" => $data
    ]);

    die();
}

function successMessage($message) {
    echo json_encode(["message" => $message]);
    die();
}

function convertToBool(&$arr, $row) {
    foreach($arr as &$data) {
        $data[$row] = (bool) $data[$row];
    }
}

//converting decoded jwt token data into assoc. arr.
function objectToArray($obj) {
    // If it's an object, cast it to an array
    if (is_object($obj)) {
        $obj = get_object_vars($obj);
    }
    // If it's an array, recursively process each element
    if (is_array($obj)) {
        return array_map('objectToArray', $obj);
    }
    return $obj; // Return scalar values as is
}