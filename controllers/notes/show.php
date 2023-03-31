<?php

use Core\Database;

$heading = 'Note';
$currentUserId = 1;
$id = (int)$_GET['id'];
$database = new Database(ENV_FILE);
$note = $database->query('SELECT * FROM Notes where id = :id', ['id' => $id])->findOrFail();
if ($currentUserId !== $note['user_id']) {
    abort(403);
}
view('notes/show.view.php', compact('heading', 'currentUserId', 'note'));