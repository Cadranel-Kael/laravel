<?php

namespace Core;

use Core\Middleware\Middleware;
use Exception;

class Router
{
    protected array $routes = [];

    public function add(string $uri, string $method, array|string $controller): Router
    {
        $middleware = [];
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

    public function only(string $key): Router
    {
        $this->routes[array_key_last($this->routes)]['middleware'][] = $key;
        return $this;
    }

    public function csrf(): Router
    {
        $this->routes[array_key_last($this->routes)]['middleware'][] = 'csrf';
        return $this;
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
                foreach($routes[0]['middleware'] as $middleware) {
                    Middleware::resolve($middleware);
                }
            } catch (Exception $e) {
                exit($e->getMessage());
            }
        }

        $controller = new $routes[0]['controller'][0]();
        $controllerMethod = $routes[0]['controller'][1];

        call_user_func([$controller, $controllerMethod]);
    }
}
