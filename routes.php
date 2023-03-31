<?php

$router->get('/', 'pages/dashboard.php');
$router->get('/about', 'pages/about.php');
$router->get('/contact', 'pages/contact.php');
$router->get('/notes', 'notes/index.php');
$router->get('/note', 'notes/show.php');
$router->get('/notes/create', 'notes/create.php');
$router->post('/notes', 'notes/store.php');
$router->delete('/note', 'notes/destroy.php');
