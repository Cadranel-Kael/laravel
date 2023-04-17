<?php

use Core\Database;
use Core\Validator;
use Core\Response;

$errors = [];
if (!isset($_POST['email']) || !isset($_POST['password']) || !isset($_POST['name'])) {
    Response::abort(Response::BAD_REQUEST);
}

$email = trim($_POST['email']);
$name = trim($_POST['name']);
$password = trim($_POST['password']);

if (!Validator::between($name, 2)) {
    $errors['name'] = 'The name must be at least two letters long';
}
if (Validator::exists($name, 'users', 'name')) {
    $errors['name'] = 'Sorry, this name has already been taken';
}
if (!Validator::email($email)) {
    $errors['email'] = ($email ?: 'An empty email') . ' is not a valid email address';
}
if (Validator::exists($email, 'users', 'email')) {
    $errors['email'] = 'A user is already registered with this email address';
}
if (!Validator::password($password)) {
    $errors['password'] = ($password ?: 'An empty password') . ' is not in the requested format';
}

if (empty($errors)) {
    $database = new Database(ENV_FILE);
    $database->query(
        'INSERT INTO users(name, email, password) values(:name, :email, :password)',
        [
            'name' => $name,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_BCRYPT)
        ]
    );
    header('Location: http://a.test/login');
    exit;
} else {
    $heading = 'Please check your credentials in order to create your user account';
    $suggested_password = generate_password();
    view('userAccounts/create.view.php', compact('heading', 'suggested_password', 'errors', 'email', 'password'));
}
