<?php

use Core\Database;
use Core\Response;

$heading = 'Edit Note';
$currentUserId = 1;
$id = (int)$_GET['id'];
$database = new Database(ENV_FILE);
$note = $database->query('SELECT * FROM Notes where id = :id', ['id' => $id])->findOrFail();
if ($currentUserId !== $note['user_id']) {
    Response::abort(Response::FORBIDDEN);
}
view('notes/edit.view.php', compact('heading', 'currentUserId', 'note'));
