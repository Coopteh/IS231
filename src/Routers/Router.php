<?php
namespace src\Routers;

class Router
{
    protected $routes = [];
    protected $params = [];

    public function add($route, $controller, $action, $method = 'GET')
    {
        $this->routes[] = [
            'route' => $route,
            'controller' => $controller,
            'action' => $action,
            'method' => strtoupper($method)
        ];
    }

    public function dispatch($url)
    {
        $url = $this->removeQueryString($url);
        $method = $_SERVER['REQUEST_METHOD'];

        foreach ($this->routes as $route) {
            if ($route['method'] !== $method) {
                continue;
            }

            $pattern = $this->convertToPattern($route['route']);
            
            if (preg_match($pattern, $url, $matches)) {
                array_shift($matches);
                $this->params = $matches;
                
                $controllerClass = "src\\Controllers\\" . $route['controller'];
                
                if (class_exists($controllerClass)) {
                    $controller = new $controllerClass();
                    $action = $route['action'];
                    
                    if (method_exists($controller, $action)) {
                        call_user_func_array([$controller, $action], $this->params);
                        return;
                    }
                }
            }
        }
        
        // 404 Not Found
        header("HTTP/1.0 404 Not Found");
        echo "404 - Страница не найдена";
    }

    protected function convertToPattern($route)
    {
        $route = preg_replace('/\//', '\\/', $route);
        $route = preg_replace('/\{([a-z]+)\}/', '(?P<$1>[a-zA-Z0-9\-]+)', $route);
        return '/^' . $route . '$\/';
    }

    protected function removeQueryString($url)
    {
        if ($url != '') {
            $parts = explode('?', $url, 2);
            $url = $parts[0];
        }
        return $url;
    }
}