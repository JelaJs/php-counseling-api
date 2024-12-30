<?php

use Core\App;
use Core\Database;
use Core\Validator;
use Core\JwtToken;

$discussionId = (int) $_GET['id'] ?? null;

$question = $_POST['question'] ?? null;

$decodedJwt = JwtToken::get();
$decodedAssoc = json_decode(json_encode($decodedJwt), true);

if(!Validator::inputs($question, $discussionId)) {
    errorResponse(400, "Missing parameter");
}

if(!$discussionId) {
    errorResponse(400, "Product id needs to be type integer");
}

$db = App::resolve(Database::class);

$discussion = $db->query('SELECT * FROM discussions WHERE id = :id', [
    'id' => $discussionId
])->find();

if(!$discussion) {
    errorResponse(400, "No active discussion for id: $discussionId");
}

if(strtolower($decodedAssoc['data']['type']) !== 'listener') {
    errorResponse(400, "User needs to be type Listener");
}

if($discussion['listener_id'] !== $decodedAssoc['data']['id']) {
    errorResponse(400, "You're not allowed to ask questions for this discussion");
}

$db->query("INSERT INTO questions (user_id, question, discussion_id) VALUES (:user_id, :question, :discussion_id)", [
    'user_id' => $decodedAssoc['data']['id'],
    'question' => $question,
    'discussion_id' => $discussionId
]);

die();