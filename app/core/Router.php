<?php
// app/core/Router.php

class Router
{
    private $routes = [];

    public function get($uri, $action)
    {
        $this->routes['GET'][$uri] = $action;
    }

    public function post($uri, $action)
    {
        $this->routes['POST'][$uri] = $action;
    }

    public function dispatch($url)
    {
        $httpMethod = $_SERVER['REQUEST_METHOD'];
        $uri = '/' . trim($url, '/');
        
        // Check for exact matches first
        if (isset($this->routes[$httpMethod][$uri])) {
            return $this->executeRoute($httpMethod, $uri);
        }
        
        // Check for routes with parameters
        foreach ($this->routes[$httpMethod] as $routeUri => $action) {
            // Convert route with parameters to regex pattern
            $pattern = preg_replace('/\(:num\)/', '(\d+)', $routeUri);
            $pattern = str_replace('/', '\/', $pattern);
            $pattern = '/^' . $pattern . '$/';
            
            if (preg_match($pattern, $uri, $matches)) {
                // Remove the full match
                array_shift($matches);
                
                // Execute the route with parameters
                return $this->executeRoute($httpMethod, $routeUri, $matches);
            }
        }
        
        // No route found
        http_response_code(404);
        echo "404 Not Found";
        exit;
    }
    
    private function executeRoute($method, $uri, $params = [])
    {
        $action = $this->routes[$method][$uri];
        
        if (!$action) {
            http_response_code(404);
            echo "404 Not Found";
            exit;
        }
        
        list($controllerName, $controllerMethod) = explode('@', $action);
        
        // Include the controller file
        $controllerFile = __DIR__ . '/../controllers/' . $controllerName . '.php';
        
        if (!file_exists($controllerFile)) {
            die("Controller file not found: " . $controllerFile);
        }
        
        require_once $controllerFile;
        
        if (!class_exists($controllerName)) {
            die("Controller class $controllerName not found");
        }
        
        // Initialize database connection
        require_once __DIR__ . '/Database.php';
        $database = new Database();
        $db = $database->connect();
        
        // Create controller instance with database
        $controller = new $controllerName($db);
        
        if (!method_exists($controller, $controllerMethod)) {
            die("Method $controllerMethod not found in $controllerName");
        }
        
        // Call the method with parameters
        if (!empty($params)) {
            call_user_func_array([$controller, $controllerMethod], $params);
        } else {
            $controller->$controllerMethod();
        }
        
        return true;
    }
}