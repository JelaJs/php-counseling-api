<?php

use Core\App;
use Core\Database;

//premesti u container
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . "/../../");
$dotenv->load();

$email = $_POST['email'] ?? null;
$password = $_POST['password'] ?? null;

if(!trim($email) || !trim($password)) {
    errorResponse(400, "Missing parameter");
}

if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    errorResponse(400, "Invalid email format");
}

$db = App::resolve(Database::class);

$result = $db->query("SELECT * FROM users WHERE email = :email", [
    "email" => $email
])->find();

if(!$result) {
    errorResponse(400, "No user with this email");
}

$hashedPassword = ($result['password']);

if(!password_verify($password, $hashedPassword)) {
    errorResponse(400, "Invalid password");
}

view('loginView.php', [
    'username' => $result['username'],
    'email' => $result['email']
]);