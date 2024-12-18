<?php

use Core\App;
use Core\Database;

$db = App::resolve(Database::class);

$discussions = $db->query("SELECT * FROM discussions")->get();

if(!$discussions) {
    http_response_code(404);
    echo json_encode(["message" => "Product not found"]);
    return;
}

view('getDiscussionsview.php', [
    'data' => $discussions
]);