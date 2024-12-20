<?php

use Core\App;
use Core\Database;
use Core\Validator;
use Core\JwtToken;

$discussionId = (int) $_GET['id'] ?? null;

$answer = $_POST['answer'] ?? null;

$decodedJwt = JwtToken::get();
$decodedAssoc = json_decode(json_encode($decodedJwt), true);

if(!Validator::inputs($answer, $discussionId)) {
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

if(strtolower($decodedAssoc['data']['type']) !== 'advisor') {
    errorResponse(400, "User needs to be type Advisor"); 
}

if($discussion['have_answer'] && $discussion['advisor_id'] !== $decodedAssoc['data']['id']) {
    errorResponse(400, "You're not allowed to give answers for this discussion");
}

$db->query("INSERT INTO answers (user_id, discussion_id, answer) VALUES (:user_id, :discussion_id, :answer)", [
    'user_id' => $decodedAssoc['data']['id'],
    'discussion_id' => $discussionId,
    'answer' => $answer
]);

$db->query("UPDATE discussions SET have_answer = 1, advisor_id = :advisor_id WHERE id = :id", [
    'advisor_id' => $decodedAssoc['data']['id'],
    'id' => $discussionId
]);