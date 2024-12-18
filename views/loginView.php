<?php

$key = $_ENV["KEY"];

$issuedAt = time();

$payload = [
    "iat" => $issuedAt,
    "nbf" => $issuedAt,
    "data" => [
        "username" => $username,
        "id" => $id
    ],
];

$jwt = \Firebase\JWT\JWT::encode($payload, $key, "HS256");

dataResponse([
    'success' => true,
    'message' => 'Login successful',
    'token' => $jwt
]);