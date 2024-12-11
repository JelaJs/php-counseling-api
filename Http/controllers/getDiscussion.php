<?php

use Core\App;
use Core\Database;

$id = (int) $_GET['id'] ?? null;

if(!$id) {
    http_response_code(400);
    echo json_encode(["message" => "Product id needs to be type integer"]);
    return;
}

$db = App::resolve(Database::class);

$discussion = $db->query("SELECT * FROM discussions WHERE id = :id", [
    "id" => $id
])->find();

if(!$discussion) {
    http_response_code(404);
    echo json_encode(["message" => "No product with this id"]);
    return;
}

echo json_encode([
    "data" => $discussion
]);

die();