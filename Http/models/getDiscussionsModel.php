<?php

use Core\App;
use Core\Database;

$db = App::resolve(Database::class);

$discussions = $db->query("SELECT * FROM discussions")->get();

if(!$discussions) {
    errorResponse(400, "Discussion not found");
}

view('getDiscussionsview.php', [
    'data' => $discussions
]);