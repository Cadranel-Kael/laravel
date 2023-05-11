<?php

use Controllers\DashboardController;
use Controllers\NotesController;
use Controllers\UserAccountsController;
use Controllers\UserSessionsController;

$router->get('/', [DashboardController::class, 'index']);
/*$router->get('/about', 'pages/about.php');
$router->get('/contact', 'pages/contact.php');*/

/*
  Notes CRUD
  NB : CRUD est un acronyme pour : Create, Read, Update et Delete */
$router->get('/notes', [NotesController::class, 'index'])->only('authenticated');
$router->get('/note', [NotesController::class, 'show'])->only('authenticated');
$router->get('/notes/create', [NotesController::class, 'create'])->only('authenticated');
$router->post('/notes', [NotesController::class, 'store'])->only('authenticated')->csrf();
$router->delete('/note', [NotesController::class, 'destroy'])->only('authenticated');
$router->get('/note/edit', [NotesController::class, 'edit'])->only('authenticated');
$router->patch('/note', [NotesController::class, 'update'])->only('authenticated');

/* User Accounts creation */
$router->get('/register', [UserAccountsController::class, 'create'])->only('guest');
$router->post('/register', [UserAccountsController::class, 'store'])->only('guest');

/* User Session creation */
$router->get('/login', [UserSessionsController::class, 'create'])->only('guest');
$router->post('/login', [UserSessionsController::class, 'store'])->only('guest');
$router->delete('/logout', [UserSessionsController::class, 'destroy'])->only('authenticated');
