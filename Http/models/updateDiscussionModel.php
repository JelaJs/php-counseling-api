<?php

use Core\App;
use Core\Database;
use Core\Validator;

$id = (int) $_GET['id'] ?? null;
$topic = $_POST['topic'] ?? null;

if(!Validator::inputs($email, $username, $id)) {
    errorResponse(400, "Missing parameter");
}

if(!$id) {
    errorResponse(400, "Product id needs to be type integer");
}

$db = App::resolve(Database::class);

$db->query('UPDATE discussions SET topic = :topic WHERE id = :id', [
    'topic' => $topic,
    'id' => $id
]);

view('updateDiscussionView.php');