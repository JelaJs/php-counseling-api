<?php

$router->get('/counseling_api/discussions', 'getDiscussions.php')->only('auth');  //->only('auth'); na ovoj ruti samo radi testiranja 
$router->get('/counseling_api/discussion/{id}', 'getDiscussion.php');
$router->get('/counseling_api/discussionsQandA/{discussion_id}', 'getDiscussionQandA.php');

$router->post('/counseling_api/register', 'register.php');
$router->post('/counseling_api/login', 'login.php');