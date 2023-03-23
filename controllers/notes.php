<?php

$heading = 'Mes Notes';
$currentUserId = 1;
$database = new Database(ENV_FILE);
$notes = $database->query('SELECT * FROM Notes where user_id = :user_id', ['user_id' => $currentUserId])->all();
require VIEWS_PATH . '/notes.view.php';
