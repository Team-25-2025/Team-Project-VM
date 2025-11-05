<?php

$router->get('/register', 'App\\Controllers\\RegistrationController@index')->only('guest');

//Login
$router->get('/TeamProjectManage/public/', 'App\\Controllers\\SessionController@index')->only('guest');
$router->post('/TeamProjectManage/public/', 'App\\Controllers\\SessionController@store')->only('guest');
$router->delete('/TeamProjectManage/public/', 'App\\Controllers\\SessionController@destroy')->only('auth');

$router->get('/TeamProjectManage/public/index.php/board', 'App\\Controllers\\TeamBoardController@index')->only('auth');

$router->get('/TeamProjectManage/public/index.php/todo', 'App\\Controllers\\TodoController@index')->only('auth')->perms(['employee']);

$router->get('/TeamProjectManage/public/index.php/knowledge', 'App\\Controllers\\KnowledgeSharingController@index')->only('auth');

$router->get('/TeamProjectManage/public/index.php/knowledge/viewtopic', 'App\\Controllers\\KnowledgeSharingController@viewTopic')->only('auth');
$router->post('/TeamProjectManage/public/index.php/knowledge/viewtopic', 'App\\Controllers\\KnowledgeSharingController@viewTopic')->only('auth');

$router->get('/TeamProjectManage/public/index.php/knowledge/create/topic', 'App\\Controllers\\KnowledgeSharingController@createTopic')->only('auth');
$router->post('/TeamProjectManage/public/index.php/knowledge/create/topic', 'App\\Controllers\\KnowledgeSharingController@createTopic')->only('auth');

$router->get('/TeamProjectManage/public/index.php/knowledge/categories', 'App\\Controllers\\KnowledgeSharingController@categories')->only('auth');
$router->get('/TeamProjectManage/public/index.php/knowledge/create/categories', 'App\\Controllers\\KnowledgeSharingController@createCategories')->only('auth');
$router->post('/TeamProjectManage/public/index.php/knowledge/create/categories', 'App\\Controllers\\KnowledgeSharingController@createCategories')->only('auth');

$router->get('/TeamProjectManage/public/index.php/knowledge/create/post', 'App\\Controllers\\KnowledgeSharingController@createPost')->only('auth');
$router->post('/TeamProjectManage/public/index.php/knowledge/create/post', 'App\\Controllers\\KnowledgeSharingController@createPost')->only('auth');


$router->get('/TeamProjectManage/public/index.php/calendar', 'App\\Controllers\\CalendarController@index')->only('auth');
$router->post('/TeamProjectManage/public/index.php/calendar/SaveEvents', 'App\\Controllers\\CalendarController@saveEvents')->only('auth');
$router->get('/TeamProjectManage/public/index.php/calendar/LoadEvents', 'App\\Controllers\\CalendarController@loadEvents')->only('auth');

$router->get('/TeamProjectManage/public/index.php/discussion', 'App\\Controllers\\DiscussionController@index');

$router->get('/TeamProjectManage/public/index.php/notification', 'App\\Controllers\\NotificationController@index')->only('auth');

$router->get('/TeamProjectManage/public/index.php/settings', 'App\\Controllers\\SettingsController@index')->only('auth');

$router->get('/TeamProjectManage/public/index.php/chat', 'App\\Controllers\\ChatController@index')->only('auth');

$router->get('/TeamProjectManage/public/index.php/dashboard', 'App\\Controllers\\DashboardController@index')->only('auth')->perms(['manager', 'teamleader']);

$router->get('/TeamProjectManage/public/index.php/mylist', 'App\\Controllers\\ListController@index')->only('auth');

$router->get('/TeamProjectManage/public/index.php/analytics', 'App\\Controllers\\AnalyticsController@index')->only('auth')->perms(['teamleader', 'employee']);

?> 