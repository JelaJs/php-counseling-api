<?php

use Core\App;
use Core\Database;

//premesti u container
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . "/../../");
$dotenv->load();

$json = file_get_contents('php://input');

$data = json_decode($json, true);

$email = $data['email'] ?? null;
$password = $data['password'] ?? null;

if(!trim($email) || !trim($password)) {
    http_response_code(401);
    echo "Missing parameter";
    die();
}

if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(401);
    echo "Invalid Email format";
    die();
}

$db = App::resolve(Database::class);

$result = $db->query("SELECT * FROM users WHERE email = :email", [
    "email" => $email
])->find();

if(!$result) {
    http_response_code(401);
    echo "No user with this email";
    die();
}

$hashedPassword = ($result['password']);

if(!password_verify($password, $hashedPassword)) {
    http_response_code(401);
    echo "Invalid password";
    die();
}

$key = $_ENV["KEY"];

$issuedAt = time();

$payload = [
    "iat" => $issuedAt,
    "nbf" => $issuedAt,
    "data" => [
        "username" => $result['username'],
        "email" => $result['email']
    ],
];

$jwt = \Firebase\JWT\JWT::encode($payload, $key, "HS256");

echo json_encode([
    'success' => true,
    'message' => 'Login successful',
    'token' => $jwt
]); 