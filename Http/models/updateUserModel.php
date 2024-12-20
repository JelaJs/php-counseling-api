<?php

use Core\App;
use Core\Database;
use Core\Validator;
use Core\JwtToken;

$email = $_POST['email'] ?? null;
$username = $_POST['username'] ?? null;

$decodedJwt = JwtToken::get();
$decodedAssoc = json_decode(json_encode($decodedJwt), true);

if(!Validator::inputs($email, $username)) {
    errorResponse(400, "Missing parameter");
}

$db = App::resolve(Database::class);

$db->query('UPDATE users SET email = :email, username = :username WHERE id = :id', [
    'email' => $email,
    'username' => $username,
    'id' => $decodedAssoc['data']['id']
]);

view('updateUserView.php');