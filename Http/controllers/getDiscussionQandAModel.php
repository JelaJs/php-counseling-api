<?php

use Core\App;
use Core\Database;

$id = (int) $_GET['discussion_id'] ?? null;

if(!$id) {
    http_response_code(401);
    echo json_encode(["message" => "Product id needs to be type integer"]);
    return;
}

$db = App::resolve(Database::class);

$questions = $db->query("SELECT * FROM questions WHERE discussion_id = :id", [
    "id" => $id
])->get();

if(!$questions) {
    http_response_code(400);
    echo json_encode(["message" => "No questions with this id"]);
    return;
}

$answers = $db->query("SELECT * FROM answers WHERE discussion_id = :id", [
    "id" => $id
])->get();

if(!$answers) {
    echo json_encode([
        "data" => $questions
    ]);

    die();
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