<?php
declare(strict_types=1);

namespace App\Core;

final class Router
{
    private array $getRoutes = [];
    private array $postRoutes = [];

    public function get(string $path, array $handler): void
    {
        $this->getRoutes[$this->normalize($path)] = $handler;
    }

    public function post(string $path, array $handler): void
    {
        $this->postRoutes[$this->normalize($path)] = $handler;
    }

    public function dispatch(): void
    {
        $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
        $uri = $_SERVER['REQUEST_URI'] ?? '/';

        // Remove query string
        $path = parse_url($uri, PHP_URL_PATH) ?: '/';
        $path = $this->normalize($path);

        // In case app is inside a subfolder (InfinityFree)
        $scriptDir = rtrim(str_replace('\\','/', dirname($_SERVER['SCRIPT_NAME'] ?? '')), '/');
        if ($scriptDir !== '' && $scriptDir !== '/') {
            if (str_starts_with($path, $scriptDir)) {
                $path = $this->normalize(substr($path, strlen($scriptDir)));
            }
        }

        $routes = ($method === 'POST') ? $this->postRoutes : $this->getRoutes;

        if (!isset($routes[$path])) {
            http_response_code(404);
            echo "404 Not Found";
            return;
        }

        [$class, $methodName] = $routes[$path];
        $controller = new $class();
        $controller->{$methodName}();
    }

    private function normalize(string $path): string
    {
        $path = '/' . trim($path, '/');
        return $path === '/' ? '/' : $path;
    }
}
