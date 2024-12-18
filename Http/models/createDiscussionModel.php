<?php

use Core\App;
use Core\Database;
use Core\Validator;

$topic = $_POST['discussion_topic'] ?? null;
$question = $_POST['question'] ?? null;

if(!Validator::inputs($topic, $question)) {
    errorResponse(400, "Missing parameter");
}

$db = App::resolve(Database::class);

$db->query("INSERT INTO discussions (user_id, topic) VALUES (:user_id, :topic)", [
    'user_id' => ,
    'topic' => $topic
]);