<?php

use Core\App;
use Core\Database;
use Core\Validator;

//premesti u container
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . "/../../");
$dotenv->load();

$email = $_POST['email'] ?? null;
$password = $_POST['password'] ?? null;

if(!Validator::inputs($email, $password)) {
    errorResponse(400, "Missing parameter");
}

if(!Validator::email($email)) {
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
    'id' => $result['id'],
    'type' => $result['type']
]);