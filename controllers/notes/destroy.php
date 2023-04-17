<?php

use Core\Database;
use Core\Response;

$id = (int)$_POST['id'];
$database = new Database(ENV_FILE);
$note = $database->query('SELECT * FROM Notes where id = :id', ['id' => $id])->findOrFail();
if ($currentUserId !== $note['user_id']) {
    Response::abort(Response::FORBIDDEN);
}
view('notes/show.view.php', compact('heading', 'currentUserId', 'note'));
