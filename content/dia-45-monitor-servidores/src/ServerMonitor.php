<?php
declare(strict_types=1);

namespace App;

class ServerMonitor
{
    public function ping(string $host, int $port = 80, float $timeout = 2.0): array
    {
        $startTime = microtime(true);
        
        // Supresión de errores con @ para manejar fallos de conexión limpiamente
        $connection = @fsockopen($host, $port, $errno, $errstr, $timeout);
        
        $endTime = microtime(true);
        $latency = ($endTime - $startTime) * 1000; // En milisegundos

        if (is_resource($connection)) {
            fclose($connection);
            return [
                'status' => 'online',
                'latency' => round($latency, 2),
                'error' => null
            ];
        }

        return [
            'status' => 'offline',
            'latency' => 0,
            'error' => $errstr ?: "Connection timed out"
        ];
    }
}
