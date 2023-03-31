<?php

function abort($code = 404)
{
    http_response_code($code);
    require base_path("views/codes/{$code}.view.php");
    die();
}

function routeToController(string $path): void
{
    $routes = require base_path('routes.php');
    if (array_key_exists($path, $routes)) {
        $controller = $routes[$path];
        require base_path("controllers/{$controller}");
    } else {
        abort();
    }
}
