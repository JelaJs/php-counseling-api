<?php

use Core\App;
use Core\Database;

$json = file_get_contents('php://input');

$data = json_decode($json, true);

$username = $data['username'] ?? null; 
$email = $data['email'] ?? null;
$password = $data['password'] ?? null;
$type = $data['type'] ?? null;

if(!trim($username) || !trim($email) || !trim($password) || !trim($type)) {
    http_response_code(401);
    echo "Missing parameter";
    die();
}

if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(401);
    echo "Invalid Email format";
    die();
}

if(strtolower($type) !== "advisor" && strtolower($type) !== "listener") {
    http_response_code(401);
    echo "Type can be eather Advisor or Listener";
    die();
}

if(strlen($password) < 7 || strlen($password) > 255) {
    http_response_code(401);
    echo "Add password with more than 7 and less that 255 characters";
    die();
}

$db = App::resolve(Database::class);

$result = $db->query("SELECT * FROM users WHERE email = :email", [
    "email" => $email
])->find();

if($result) {
    http_response_code(401);
    echo "User with this email already exist.";
    die();
}

$hashedPassword = password_hash($password, PASSWORD_BCRYPT);

$db->query("INSERT INTO users (email, password, type, username) VALUES (:email, :password, :type, :username)", [
    "email" => $email,
    "password" => $hashedPassword,
    "type" => $type,
    "username" => $username
]);

echo "User successfully register";