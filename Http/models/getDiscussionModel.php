<?php

use Core\App;
use Core\Database;

$id = (int) $_GET['id'] ?? null;

if(!$id) {
    errorResponse(400, "Product id needs to be type integer");
}

$db = App::resolve(Database::class);

$discussion = $db->query("SELECT * FROM discussions WHERE id = :id", [
    "id" => $id
])->find();

if(!$discussion) {
    errorResponse(400, "No product with this id");
}

$discussion['have_answer'] = (bool) $discussion['have_answer'];

view('getDiscussionView.php', [
    'data' => $discussion
]);