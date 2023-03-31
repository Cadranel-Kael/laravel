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
