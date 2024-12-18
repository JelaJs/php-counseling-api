<?php

$router->get('/counseling_api/discussions', 'getDiscussionsModel.php'); //->only('auth');  //->only('auth'); na ovoj ruti samo radi testiranja 
$router->get('/counseling_api/discussion/{id}', 'getDiscussionModel.php');
$router->get('/counseling_api/discussionsQandA/{discussion_id}', 'getDiscussionQandAModel.php');

$router->post('/counseling_api/register', 'registerModel.php');
$router->post('/counseling_api/login', 'loginModel.php');