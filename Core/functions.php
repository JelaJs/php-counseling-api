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