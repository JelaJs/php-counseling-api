<?php

use Core\App;
use Core\Database;


$username = $_POST['username'] ?? null; 
$email = $_POST['email'] ?? null;
$password = $_POST['password'] ?? null;
$type = $_POST['type'] ?? null;

if(!trim($username) || !trim($email) || !trim($password) || !trim($type)) {
    errorResponse(400, "Missing parameter");
}

if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    errorResponse(400, "Invalid Email format");
}

if(strtolower($type) !== "advisor" && strtolower($type) !== "listener") {
    errorResponse(400, "Type can be eather Advisor or Listener");
}

if(strlen($password) < 7 || strlen($password) > 255) {
    errorResponse(400, "Add password with more than 7 and less than 255 characters");
}

$db = App::resolve(Database::class);

$result = $db->query("SELECT * FROM users WHERE email = :email", [
    "email" => $email
])->find();

if($result) {
    errorResponse(400, "User with this email already exist");
}

$hashedPassword = password_hash($password, PASSWORD_BCRYPT);

$db->query("INSERT INTO users (email, password, type, username) VALUES (:email, :password, :type, :username)", [
    "email" => $email,
    "password" => $hashedPassword,
    "type" => $type,
    "username" => $username
]);

view('registerView.php');