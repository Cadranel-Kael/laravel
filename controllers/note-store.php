<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $currentUserId = $_POST['currentUserId'];
    $description = $_POST['description'];
    $database = new Database(ENV_FILE);
    $database->query('INSERT INTO notes(description, user_id) values(:description, :currentUserId)', ['description' => $description, 'currentUserId' => $currentUserId]);
    header('Location: http://a.test/notes');
} else {
    abort(405);
}
