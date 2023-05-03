<?php

namespace Controllers;

use Core\Database;
use Core\Validator;
use Core\Response;

class UserAccountsController
{
    public function __construct()
    {
    }

    public function create(): void
    {
        $suggested_password = generate_password();
        $heading = 'Create you account and join our platform';
        view(
            'useraccounts/create.view.php',
            compact('heading', 'suggested_password')
        );
    }

    public function store(): void
    {
        if (! isset($_POST['name']) ||
            ! isset($_POST['email']) ||
            ! isset($_POST['password'])) {
            Response::abort(Response::BAD_REQUEST);
        }

        $name = trim($_POST['name']);
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);

        if (! Validator::between($name, 2)) {
            $_SESSION['errors']['name'] =
               'The name must be at least two letters long';
        }
        if (Validator::exists($name, 'users', 'name')) {
            $_SESSION['errors']['name'] =
                'Sorry, this name has already been taken';
        }
        if (! Validator::email($email)) {
            $_SESSION['errors']['email'] =
                ($email ?: 'An empty email').' is not a valid email address';
        }
        if (Validator::exists($email, 'users', 'email')) {
            $_SESSION['errors']['email'] =
                'A user is already registered with '.$email;
        }
        if (! Validator::password($password)) {
            $_SESSION['errors']['password'] =
                ($password ?: 'An empty password').' is not in the requested format';
        }

        if (empty($_SESSION['errors'])) {
            $database = new Database(ENV_FILE);
            $database->query(
                'INSERT INTO users(name, email, password) 
                VALUES(:name, :email, :password)',
                [
                    'name' => $name,
                    'email' => $email,
                    'password' => password_hash($password, PASSWORD_BCRYPT),
                ]
            );
            $_SESSION['flash']['success'] = 'Welcome, you are correctly registered, you can now login';
            $location = 'http://'.$_SERVER['HTTP_HOST'].'/login';
        } else {
            $_SESSION['old'] = compact('name', 'email', 'password');
            $location = 'http://'.$_SERVER['HTTP_HOST'].'/register';
        }

        header("Location: $location");
        exit;

    }
}
