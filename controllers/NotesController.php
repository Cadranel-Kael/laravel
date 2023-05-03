<?php

namespace Controllers;

use Core\Database;
use Core\Response;
use Core\Validator;

class NotesController
{
    private \stdClass $user;

    public function __construct()
    {
        $this->user = $_SESSION['user'] ?? null;
    }

    private function checkDescriptionForNote(): void
    {
        //Useful for both update and store

        if (! isset($_POST['description'])) {
            Response::abort(Response::BAD_REQUEST);
        }

        if (! Validator::between($_POST['description'], 1, 255)) {
            $_SESSION['errors']['description'] =
                'The description must be more than 1 character and less than 255 characters long';
        }
    }

    public function index(): void
    {

        $heading = 'Mes Notes';
        $database = new Database(ENV_FILE);

        $notes = $database->query(
            'SELECT * FROM Notes where user_id = :user_id',
            ['user_id' => $this->user->id]
        )->all();

        view(
            'notes/index.view.php',
            compact('heading', 'notes')
        );
    }

    public function show(): void
    {
        $heading = 'Note';
        $id = (int) $_GET['id'];

        $database = new Database(ENV_FILE);
        $note = $database->query(
            'SELECT * FROM Notes where id = :id',
            ['id' => $id]
        )->findOrFail();

        if ($_SESSION['user']->id !== $note->user_id) {
            Response::abort(Response::FORBIDDEN);
        }

        view(
            'notes/show.view.php',
            compact('heading', 'note')
        );
    }

    public function create(): void
    {
        $heading = 'Create Note';
        view('notes/create.view.php', compact('heading'))  ;
    }

    public function store(): void
    {
        $this->checkDescriptionForNote();
        if (empty($_SESSION['errors'])) {
            $description = $_POST['description'];
            $database = new Database(ENV_FILE);
            $database->query(
                'INSERT INTO notes(description, user_id) 
                VALUES(:description, :user_id)',
                [
                'description' => $description,
                'user_id' => $_SESSION['user']->id
            ]
            );
            $location =
                'http://' . $_SERVER['HTTP_HOST'].'/notes';

        } else {
            $location =
                'http://' . $_SERVER['HTTP_HOST'].'/notes/create';
        }

        header('Location: '.$location);
        exit;
    }

    public function edit(): void
    {
        $heading = 'Edit Note';

        $id = (int) $_GET['id'];

        $database = new Database(ENV_FILE);
        $note = $database->query(
            'SELECT * FROM notes 
            WHERE id = :id AND user_id = :user_id',
            [
            'id' => $id,
            'user_id' => $_SESSION['user']->id]
        )->findOrFail();

        view('notes/edit.view.php', compact('heading', 'note'));
    }

    public function update(): void
    {
        $this->checkDescriptionForNote();

        $id = (int) $_POST['id'];
        if(empty($_SESSION['errors'])) {
            // TODO we could check the id of the consistency of the id between the edit route and the update route, but one thing at a time…
            $description = trim($_POST['description']);

            $database = new Database(ENV_FILE);
            $database->query(
                'UPDATE notes SET description = :description 
                WHERE id = :id AND user_id = :user_id',
                [
                    'description'=>$description,
                    'id' => $id,
                    'user_id'=> $_SESSION['user']->id
                ]
            );
            // TODO the update might actually fail but, here again, one thing at a time
            $location =
                'http://' . $_SERVER['HTTP_HOST'].'/note?id='.$id;

        } else {
            $location =
                'http://' . $_SERVER['HTTP_HOST'].'/note/edit?id='.$id;
        }

        header('Location: '.$location);
        exit;
    }

    public function destroy(): void
    {
        $id = (int) $_POST['id'];

        $database = new Database(ENV_FILE);
        $database->query(
            'DELETE FROM notes WHERE id = :id AND user_id = :user_id',
            [
                'id' => $id,
                'user_id' => $_SESSION['user']->id
            ]
        );

        $location = 'http://'. $_SERVER['HTTP_HOST'].'/notes';
        header('Location: '.$location);
        exit;
    }
}
