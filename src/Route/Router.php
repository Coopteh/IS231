<?php
namespace App\Route;

class Router
{
    private array $routes = [];

    public function addRoute(string $path, callable $callback): void
    {
        $this->routes[$path] = $callback;
    }

    public function dispatch(string $path): void
    {
        if (array_key_exists($path, $this->routes)) {
            call_user_func($this->routes[$path]);
        } else {
            http_response_code(404);
            echo "Page not found.";
        }
    }
}