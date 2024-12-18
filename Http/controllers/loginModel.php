<?php

use Core\App;
use Core\Database;

//premesti u container
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . "/../../");
$dotenv->load();

$email = $_POST['email'] ?? null;
$password = $_POST['password'] ?? null;

if(!trim($email) || !trim($password)) {
    http_response_code(401);
    echo json_encode(["error" => "Missing parameter"]);
    die();
}

if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(401);
    echo json_encode(["error" => "Invalid Email format"]);
    die();
}

$db = App::resolve(Database::class);

$result = $db->query("SELECT * FROM users WHERE email = :email", [
    "email" => $email
])->find();

if(!$result) {
    http_response_code(401);
    echo json_encode(["error" => "No user with this email"]);
    die();
}

$hashedPassword = ($result['password']);

if(!password_verify($password, $hashedPassword)) {
    http_response_code(401);
    echo json_encode(["error" => "Invalid password"]);
    die();
}

view('loginView.php', [
    'username' => $result['username'],
    'email' => $result['email']
]);