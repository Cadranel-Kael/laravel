<?php

use Core\Database;

$heading = 'List of users';
$database = new Database(ENV_FILE);
$notes = $database->query('SELECT * FROM Users')->all();
view('notes/index.view.php', compact('heading', 'currentUserId', 'notes'));
