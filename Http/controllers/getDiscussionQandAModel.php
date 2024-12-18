<?php

use Core\App;
use Core\Database;

$id = (int) $_GET['discussion_id'] ?? null;

if(!$id) {
    errorResponse(401, 'Product id needs to be type integer');
}

$db = App::resolve(Database::class);

$questions = $db->query("SELECT q.*, u.username FROM questions AS q INNER JOIN users AS u ON u.id = q.user_id WHERE q.discussion_id = :id", [
    "id" => $id
])->get();

if(!$questions) {
    errorResponse(400, 'No questions with this id');
}

$answers = $db->query("SELECT a.*, u.username FROM answers AS a INNER JOIN users AS u ON u.id = a.user_id WHERE a.discussion_id = :id", [
    "id" => $id
])->get();

if(!$answers) {
    dataResponse($questions);
}

$questionsAndAnswers = array_merge($questions, $answers);

usort($questionsAndAnswers, function($a, $b) {
    $timeA = strtotime($a['created_at']) * 1000; //in miliseconds
    $timeB = strtotime($b['created_at']) * 1000;
    
    return $timeA <=> $timeB;
});

view('getDiscussionsQandAView.php', [
    'data' => $questionsAndAnswers
]);