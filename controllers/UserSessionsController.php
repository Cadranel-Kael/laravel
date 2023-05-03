<?php

namespace Controllers;

use Core\Database;
use Core\Response;

class UserSessionsController
{
    public function __construct()
    {
    }

    public function create(): void
    {
        $heading = 'Login to your session';
        view(
            'usersessions/create.view.php',
            compact('heading')
        );
    }

    public function store(): void
    {

        $errors = [];

        if (! isset($_POST['email']) || ! isset($_POST['password'])) {
            Response::abort(Response::BAD_REQUEST);
        }

        $email = trim($_POST['email']);
        $password = trim($_POST['password']);

        /*if (Validator::exists($email, 'users', 'email')) {
            $errors['email'] = 'A user is already registered with this email address';
        }*/

        $database = new Database(ENV_FILE);
        $user = $database->query('SELECT * FROM users WHERE email = :email', ['email' => $email])->find();

        if (! $user) {
            $errors['email'] = 'This email is not registered yet in our database';
        } else {
            $hash = $user->password;

            if (! password_verify($password, $hash)) {
                $errors['password'] = "This password doesn't match the one recorded for your email address";
            }
            // State !important pour les sessions
            // Création d'un fichier sur le serveur qui consigne toutes les informations
        }

        if (empty($errors)) {
            $_SESSION['user'] = $user;

            $location = $_SERVER['HTTP_ORIGIN'];
            header("Location: $location");
            exit;
        } else {
            $heading = 'Please check your credentials in order to login to your account';
            view('userSessions/create.view.php', compact('heading', 'errors', 'email', 'password'));
        }

        header("Location: $location");
        exit;
    }

    public function destroy(): void
    {
        // Unset all of the session variables.
        $_SESSION = [];

        // If it's desired to kill the session, also delete the session cookie.
        // Note: This will destroy the session, and not just the session data!
        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params['path'],
                $params['domain'],
                $params['secure'],
                $params['httponly']
            );
        }

        // Finally, destroy the session.
        session_destroy();

        $location = $_SERVER['HTTP_REFERER'];

        header("Location: $location");
        exit;
    }
}
