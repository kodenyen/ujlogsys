<?php
namespace App\Core;

class Router {
    protected $routes = [];

    public function add($route, $controller, $action) {
        $this->routes[$route] = ['controller' => $controller, 'action' => $action];
    }

    public function dispatch($url) {
        $url = trim($url, '/');
        if (array_key_exists($url, $this->routes)) {
            $controllerName = "App\\Controllers\\" . $this->routes[$url]['controller'];
            $action = $this->routes[$url]['action'];

            if (class_exists($controllerName)) {
                $controller = new $controllerName();
                if (method_exists($controller, $action)) {
                    $controller->$action();
                } else {
                    die("Action $action not found in controller $controllerName");
                }
            } else {
                die("Controller $controllerName not found");
            }
        } else {
            http_response_code(404);
            echo "404 Not Found (Route: $url)";
        }
    }
}
