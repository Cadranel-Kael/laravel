<?php

namespace Core;

use Core\Middleware\Middleware;
use Exception;

class Router
{
    protected array $routes = [];

    public function add(string $uri, string $method, array|string $controller): Router
    {
        $middleware = null;
        $this->routes[] = compact('uri', 'method', 'controller', 'middleware');

        return $this;
    }

    public function get(string $uri, array|string $controller): Router
    {
        return $this->add($uri, 'GET', $controller);
    }

    public function post(string $uri, array|string $controller): Router
    {
        return $this->add($uri, 'POST', $controller);
    }

    public function delete(string $uri, array|string $controller): Router
    {
        return $this->add($uri, 'DELETE', $controller);
    }

    public function patch(string $uri, array|string $controller): Router
    {
        return $this->add($uri, 'PATCH', $controller);
    }

    public function only(string $key): void
    {
        $this->routes[array_key_last($this->routes)]['middleware'] = $key;
    }

    public function routeToController(string $uri, string $method): void
    {
        $routes = array_values(
            array_filter(
                $this->routes,
                fn ($r) => $uri === $r['uri'] && strtoupper($method) === $r['method']
            )
        );
        if (empty($routes)) {
            Response::abort();
        }

        if (! is_null($routes[0]['middleware'])) {
            try {
                Middleware::resolve($routes[0]['middleware']);
            } catch (Exception $e) {
                exit($e->getMessage());
            }
        }

        $controller = new $routes[0]['controller'][0]();
        $controllerMethod = $routes[0]['controller'][1];

        call_user_func([$controller, $controllerMethod]);
    }
}
