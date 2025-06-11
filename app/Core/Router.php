<?php
namespace App\Core;

class Router 
{
    private $routes = [];

    public function add($method, $path, $handler) 
    {
        $this->routes[] =  [ 'method' => strtoupper($method), 'path' => $path, 'handler' => $handler ];
    }

    public function dispatch($requestMethod, $requestUri) 
    {
        $requestMethod = strtoupper($requestMethod);
        $uri = parse_url($requestUri, PHP_URL_PATH);

        foreach ($this->routes as $route) 
        {
            if ($requestMethod !== $route['method']) {
                continue;
            }

            $routePath = $route['path'];

            $pattern = preg_replace('#\{[^\}]+\}#', '([^/]+)', $routePath);
            $pattern = "#^$pattern$#";

            if (preg_match($pattern, $uri, $matches)) 
            {
                array_shift($matches);

                [$controllerName, $methodName] = explode('@', $route['handler']);
                $controllerClass = "App\\Controllers\\$controllerName";

                $controller = new $controllerClass();

                return call_user_func_array([$controller, $methodName], $matches);
            }
        }
        http_response_code(404);
        echo json_encode(['error' => 'Rota não encontrada.']);
    }
}