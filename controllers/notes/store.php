<?php

use Core\Database;
use Core\Validator;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errors = [];
    $currentUserId = $_POST['currentUserId'];
    if (!isset($_POST['description'])) {
        abort(400);
    }
    if (!Validator::between($_POST['description'], 1, 255)) {
        $errors['description'] = 'The description must be more than 1 character and less than 255 characters long';
    }
    if (empty($errors)) {
        $description = $_POST['description'];
        $database = new Database(ENV_FILE);
        $database->query('INSERT INTO notes(description, user_id) values(:description, :currentUserId)', ['description' => $description, 'currentUserId' => $currentUserId]);
        header('Location: http://screencast.test/notes');
    } else {
        $heading = 'Create Note';
        view('notes/create.view.php', compact('heading', 'errors', 'currentUserId'));
    }
} else {
    abort(405);
}
