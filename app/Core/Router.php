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
        
        // In case app is inside a subfolder (InfinityFree, XAMPP, etc.)
        $scriptDir = rtrim(str_replace('\\','/', dirname($_SERVER['SCRIPT_NAME'] ?? '')), '/');
        if ($scriptDir !== '' && $scriptDir !== '/') {
            // Remove the script directory from the path
            if (str_starts_with($path, $scriptDir)) {
                $path = substr($path, strlen($scriptDir));
            }
        }
        
        $path = $this->normalize($path);

        $routes = ($method === 'POST') ? $this->postRoutes : $this->getRoutes;

        // Debug: log the path being matched
        error_log('Router: Looking for path: ' . $path);
        error_log('Router: Available routes: ' . implode(', ', array_keys($routes)));

        if (!isset($routes[$path])) {
            http_response_code(404);
            echo "404 Not Found - Path: " . $path;
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
