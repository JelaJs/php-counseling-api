<?php

use Core\App;
use Core\Database;
use Core\Validator;


$username = $_POST['username'] ?? null; 
$email = $_POST['email'] ?? null;
$password = $_POST['password'] ?? null;
$type = $_POST['type'] ?? null;

if(!Validator::inputs($username, $email, $password, $type)) {
    errorResponse(400, "Missing parameter");
}

if(!Validator::email($email)) {
    errorResponse(400, "Invalid Email format");
}

if(Validator::type($type)) {
    errorResponse(400, "Type can be eather Advisor or Listener");
}

if(!Validator::string($password, 7, 255)) {
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

view('user/register.view.php');