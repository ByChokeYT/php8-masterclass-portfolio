<?php
declare(strict_types=1);

namespace App\Core;

class Performance
{
    private float $startTime;

    public function __construct()
    {
        $this->startTime = microtime(true);
    }

    public function getMetrics(): array
    {
        return [
            'load_time' => round((microtime(true) - $this->startTime) * 1000, 2),
            'memory_usage' => round(memory_get_usage() / 1024 / 1024, 2),
            'php_version' => PHP_VERSION,
            'server_software' => $_SERVER['SERVER_SOFTWARE'] ?? 'N/A'
        ];
    }
}
