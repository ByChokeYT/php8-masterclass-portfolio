<?php
declare(strict_types=1);

namespace App;

class Router
{
    private array $routes = [];

    public function add(string $route, callable $callback): void
    {
        $this->routes[$route] = $callback;
    }

    public function dispatch(string $uri): void
    {
        $parsedUri = parse_url($uri, PHP_URL_PATH);
        
        // Limpiar subdirectorios si es que existen
        // En nuestro caso, removemos la ruta base "/content/dia-41-router-mvc/public"
        $basePath = '/content/dia-41-router-mvc/public';
        if (str_starts_with($parsedUri, $basePath)) {
            $parsedUri = substr($parsedUri, strlen($basePath));
        }
        
        if (empty($parsedUri)) {
            $parsedUri = '/';
        }

        foreach ($this->routes as $route => $callback) {
            if ($route === $parsedUri) {
                $callback();
                return;
            }
        }

        http_response_code(404);
        echo "<h1>404 - Ruta no encontrada</h1><p>El recurso '{$parsedUri}' no existe.</p>";
    }
}
