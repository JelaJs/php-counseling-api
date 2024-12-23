<?php

$key = $_ENV["KEY"];

$issuedAt = time();
$expTime = $issuedAt + 600;

$payload = [
    "iat" => $issuedAt,
    "nbf" => $issuedAt,
    "expireAt" => $expTime,
    "data" => [
        "username" => $username,
        "id" => $id,
        "type" => $type
    ],
];

$jwt = \Firebase\JWT\JWT::encode($payload, $key, "HS256");

dataResponse([
    'success' => true,
    'message' => 'Login successful',
    'token' => $jwt
]);