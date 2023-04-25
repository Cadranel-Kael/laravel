<?php

$router->get('/', 'pages/dashboard.php');
$router->get('/about', 'pages/about.php');
$router->get('/contact', 'pages/contact.php');

/* Notes CRUD */
$router->get('/notes', 'notes/index.php');
$router->get('/note', 'notes/show.php');
$router->get('/notes/create', 'notes/create.php');
$router->post('/notes', 'notes/store.php');
$router->delete('/note', 'notes/destroy.php');
$router->get('/note/edit', 'notes/edit.php');
$router->patch('/note', 'notes/update.php');

/* User Account creation */
$router->get('/register', 'userAccounts/create.php');
$router->post('/register', 'userAccounts/store.php');

/* User Session creation */
$router->get('/login', 'userSessions/create.php');
$router->post('/login', 'userSessions/store.php');
