<?php

namespace Core;
use Core\Middleware\Middleware;

class Router {
    protected $routes = [];

    public function add($method, $uri, $controller) {
        $this->routes[] = [
            'uri' => $uri,
            'controller' => $controller,
            'method' => $method,
            'middleware' => null
        ];

        return $this;
    }

    public function get($uri, $controller) {
        return $this->add('GET', $uri, $controller);
    }

    public function post($uri, $controller) {
        return $this->add('POST', $uri, $controller);
    }

    public function delete($uri, $controller) {
        return $this->add('DELETE', $uri, $controller);
    }

    public function patch($uri, $controller) {
        return $this->add('PATCH', $uri, $controller);
    }

    public function put($uri, $controller) {
        return $this->add('PUT', $uri, $controller);
    }

    public function only($key) {
        $this->routes[array_key_last($this->routes)]['middleware'] = $key;
        
        return $this;
    }

    public function route($uri, $method) {
        foreach ($this->routes as $route) {
            // pronalazi u url {} i bilo sta da je unutar viticastih zagrada
            $pattern = preg_replace('/\{(\w+)\}/', '(?P<\1>[^/]+)', $route['uri']);
            //Obrazac: @^/counseling_api/discussion/(?P<id>[^/]+)$@  poklapa se sa: /counseling_api/discussion/42 a ne poklapa se sa /counseling_api/discussion/42/edit /counseling_api/discussions
            $pattern = "@^" . $pattern . "$@";
    
            // ako obrazac odgovara, matches ce biti [0] => /counseling_api/discussion/42, ['id'] => 42
            if (preg_match($pattern, $uri, $matches) && $route['method'] === strtoupper($method)) {

                Middleware::resolve($route['middleware']);
    
                // prvi arg nam je u ovom momentu rezultat preg_match i on je [0] => /counseling_api/discussion/42, ['id'] => 42
                //is_string proverava da li je vrednost string, i ARRAY_FILTER_USE_KEY govori da proverava keys a ne values
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
    
                $_GET = array_merge($_GET, $params);
    
                return require base_path('Http/controllers/' . $route['controller']);
            }
        }
    
        $this->abort();
    }

    public function previousUrl() {
        return $_SERVER['HTTP_REFERER'];
    }

    protected function abort($code = 404) {
        http_response_code($code);
        echo json_encode(["error" => "Page not found"]);
        die();
    }
}