<?php

$router->get('/counseling_api/discussions', 'getDiscussionsModel.php'); 
$router->get('/counseling_api/discussion/{id}', 'getDiscussionModel.php');
$router->get('/counseling_api/discussionsQandA/{discussion_id}', 'getDiscussionQandAModel.php');

$router->post('/counseling_api/register', 'registerModel.php');
$router->post('/counseling_api/login', 'loginModel.php');

$router->post('/counseling_api/discussions', 'createDiscussionModel.php')->only('auth');
$router->delete('/counseling_api/discussion/{id}', 'deleteDiscussionModel.php')->only('auth');
$router->patch('/counseling_api/discussion/{id}', 'updateDiscussionModel.php')->only('auth');

$router->patch('/counseling_api/users', 'updateUserModel.php')->only('auth');