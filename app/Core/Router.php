<?php
declare(strict_types=1);

class Router
{
    private array $routes = [];

    public function get(string $path, array $handler): void
    {
        $this->routes['GET'][$path] = $handler;
    }

    public function post(string $path, array $handler): void
    {
        $this->routes['POST'][$path] = $handler;
    }

    public function put(string $path, array $handler): void
    {
        $this->routes['PUT'][$path] = $handler;
    }

    public function delete(string $path, array $handler): void
    {
        $this->routes['DELETE'][$path] = $handler;
    }

    public function dispatch(): void
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri    = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $base   = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
        $path   = '/' . ltrim(substr($uri, strlen($base)), '/');

        $result = $this->resolve($method, $path);

        if ($result === null) {
            http_response_code(404);
            echo '<h1>404 — Página não encontrada</h1>';
            return;
        }

        [$handler, $params] = $result;
        [$class, $action]   = $handler;
        (new $class())->$action(...$params);
    }

    private function resolve(string $method, string $path): ?array
    {
        foreach ($this->routes[$method] ?? [] as $route => $handler) {
            $params = $this->match($route, $path);
            if ($params !== null) {
                return [$handler, $params];
            }
        }
        return null;
    }

    private function match(string $route, string $path): ?array
    {
        $pattern = preg_replace('/\{[^}]+\}/', '([^/]+)', $route);
        if (preg_match('#^' . $pattern . '$#', $path, $matches)) {
            array_shift($matches);
            return $matches;
        }
        return null;
    }
}
