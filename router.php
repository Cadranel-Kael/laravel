<?php

function abort($code = 404)
{
    http_response_code($code);
    require VIEWS_PATH . "/codes/{$code}.view.php";
    die();
}

function routeToController(string $path): void
{
    $routes = require './routes.php';
    if (array_key_exists($path, $routes)) {
        $controller = $routes[$path];
        require CONTROLLERS_PATH . "/{$controller}";
    } else {
        abort();
    }
}
