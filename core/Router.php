<?php

namespace Core;

class Router
{
    protected array $routes = [];


    public function add(string $uri, string $method, string $controller)
    {
        $this->routes[] = compact('uri', 'method', 'controller');
    }

    public function get(string $uri, string $controller)
    {
        $this->add($uri, 'GET', $controller);
    }

    public function post(string $uri, string $controller)
    {
        $this->add($uri, 'POST', $controller);
    }

    public function delete(string $uri, string $controller)
    {
        $this->add($uri, 'DELETE', $controller);
    }

    public function patch(string $uri, string $controller)
    {
        $this->add($uri, 'PATCH', $controller);
    }

    public function routeToController(string $uri, string $method)
    {
        $routes = array_values(array_filter($this->routes, fn ($r) => $uri === $r['uri'] && strtoupper($method) === $r['method']));
        if (empty($routes)) {
            Response::abort();
        }
        require base_path('controllers/' . $routes[0]['controller']);
    }
}
