<?php

$router->get('/counseling_api/discussions', 'discussions/index.php'); 
$router->get('/counseling_api/discussion/{id}', 'discussions/show.php');
$router->get('/counseling_api/discussionsQandA/{discussion_id}', 'questions&answears/index.php');

$router->post('/counseling_api/register', 'user/register.php');
$router->post('/counseling_api/login', 'user/login.php');

$router->post('/counseling_api/discussions', 'discussions/store.php')->only('auth');
$router->delete('/counseling_api/discussion/{id}', 'discussions/destroy.php')->only('auth');
$router->patch('/counseling_api/discussion/{id}', 'discussions/update.php')->only('auth');

$router->patch('/counseling_api/users', 'user/update.php')->only('auth');

$router->post('/counseling_api/discussion/questions/{id}', 'questions&answears/storeQuestion.php')->only('auth');
$router->post('/counseling_api/discussion/answers/{id}', 'questions&answears/storeAnswer.php')->only('auth');