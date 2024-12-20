<?php

use Core\App;
use Core\Database;

$id = (int) $_GET['id'] ?? null;

if(!$id) {
    errorResponse(400, "Product id needs to be type integer");
}

$db = App::resolve(Database::class);

$db->query('DELETE FROM discussions WHERE id = :id', [
    'id' => $id
]);

view('deleteDiscussionView.php');