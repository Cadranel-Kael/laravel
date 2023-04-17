<?php

function urlIs(string $path): bool
{
    return parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) === $path;
}

function dd($var)
{
    echo '<pre>';
    var_dump($var);
    echo '</pre>';
    die();
}

function base_path(string $path): string
{
    return BASE_PATH . $path;
}

function view(string $path, array $params = []): void
{
    extract($params);
    require base_path('views/' . $path);
}

function generate_password(int $length = 16)
{
    $password = '';

    // Génère un chiffre aléatoire
    $password .= chr(random_int(48, 57));

    // Génère une lettre capitale aléatoire
    $password .= chr(random_int(65, 90));

    // Génère un symbole aléatoire
    $password .= chr(random_int(33, 47));

    // Génère les caractères restants de façon aléatoire
    for ($i = 0; $i < $length - 3; $i++) {
        $password .= chr(random_int(33, 126));
    }

    // Mélange les caractères
    $password = str_shuffle($password);

    return $password;
}
