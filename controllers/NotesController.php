<?php

namespace Controllers;

use Core\Database;
use Core\Response;
use Core\Validator;
use Intervention\Image\ImageManagerStatic as Image;

class NotesController
{
    use HandleFileUpload;
    private \stdClass $user;

    public function __construct()
    {
        // Since the middleware has checked the presence of a user in the session,
        // we can safely use its id without checking its presence.
        // It doesnt mean that the user is authorized to interact with whatever note
        // but we will always include the user id in our sql requests.
        // It is not a very controlled authorization strategy, but it's a start.
        $this->user = $_SESSION['user'];
    }

    private function checkDescriptionForNote(): string
    {
        if (! isset($_POST['description'])) {
            Response::abort(Response::BAD_REQUEST);
        }

        if (! Validator::between($_POST['description'], 1, 255)) {
            $_SESSION['errors']['description'] =
                'The description must be more than 1 character and less than 255 characters long';
            $_SESSION['old']['description'] = $_POST['description'];
            return '';
        }

        return trim($_POST['description']);
    }

    public function index(): void
    {

        $heading = 'Mes Notes';
        $database = new Database(ENV_FILE);

        $notes = $database->query(
            'SELECT * FROM notes where user_id = :user_id',
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
            'SELECT * FROM notes 
            WHERE id = :id AND user_id = :user_id',
            [
                'id' => $id,
                'user_id' => $this->user->id,
            ]
        )->findOrFail();

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
        $note_description = $this->checkDescriptionForNote();
        $image_url = $this->handleImageUpload();
        if (empty($_SESSION['errors'])) {
            //Persist
            if($image_url) {
                $this->save_images($image_url);
            }
            $database = new Database(ENV_FILE);
            $database->query(
                'INSERT INTO notes(description, user_id,image_url) 
                VALUES(:description, :user_id, :image_url)',
                [
                    'description' => $note_description,
                    'user_id' => $this->user->id,
                    'image_url' => $image_url,
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
                'user_id' => $this->user->id,
            ]
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
                    'user_id'=> $this->user->id,
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
                'user_id' => $this->user->id,
            ]
        );

        $location = 'http://'. $_SERVER['HTTP_HOST'].'/notes';
        header('Location: '.$location);
        exit;
    }

    public function save_images($path): bool
    {
        $tmp_path = $_FILES['thumbnail']['tmp_name'];
        $image = Image::make($tmp_path);
        $width = $image->width();
        $height = $image->height();
        $ratio = $width / $height;
        foreach(NOTES_THUMBS_WIDTHS as $thumb_width) {
            if(!file_exists(storage_path('public/img/'.$thumb_width))) {
                mkdir(storage_path('public/img/'.$thumb_width));
            }

            $image->resize($thumb_width, $thumb_width / $ratio)
                  ->save(storage_path('public/img/'.$thumb_width.'/').$path);
        }
        return true;
    }

}
