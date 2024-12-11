<?php

$router->get('/counseling_api/discussions', 'getDiscussions.php');
$router->get('/counseling_api/discussion/{id}', 'getDiscussion.php');
$router->get('/counseling_api/discussionsQandA/{discussion_id}', 'getDiscussionQandA.php');