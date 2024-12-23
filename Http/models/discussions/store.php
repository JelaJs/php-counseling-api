<?php

use Core\App;
use Core\Database;
use Core\Validator;
use Core\JwtToken;

$topic = $_POST['discussion_topic'] ?? null;
$question = $_POST['question'] ?? null;

$decodedJwt = JwtToken::get();
$decodedAssoc = json_decode(json_encode($decodedJwt), true);

if(!Validator::inputs($topic, $question)) {
    errorResponse(400, "Missing parameter");
}

$db = App::resolve(Database::class);

$result = $db->query("INSERT INTO discussions (listener_id, topic) VALUES (:listener_id, :topic)", [
    'listener_id' => $decodedAssoc['data']['id'],
    'topic' => $topic
]);

$discussionId = $db->lastInsertId();

$result = $db->query("INSERT INTO questions (user_id, question, discussion_id) VALUES (:user_id, :question, :discussion_id)", [
    'user_id' => $decodedAssoc['data']['id'],
    'question' => $question,
    'discussion_id' => $discussionId
]);

view('discussions/store.view.php');