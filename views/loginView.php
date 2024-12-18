<?php

$key = $_ENV["KEY"];

$issuedAt = time();

$payload = [
    "iat" => $issuedAt,
    "nbf" => $issuedAt,
    "data" => [
        "username" => $username,
        "email" => $email
    ],
];

$jwt = \Firebase\JWT\JWT::encode($payload, $key, "HS256");

dataResponse([
    'success' => true,
    'message' => 'Login successful',
    'token' => $jwt
]);