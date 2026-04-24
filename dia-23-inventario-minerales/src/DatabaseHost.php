<?php

declare(strict_types=1);

namespace App;

use App\Config\DatabaseConfig;
use PDO;
use PDOException;

/**
 * Gestor de conexión PDO.
 * Implementa el manejo de excepciones y la inyección de configuración.
 */
class DatabaseHost
{
    private ?PDO $connection = null;

    public function __construct(
        private readonly DatabaseConfig $config
    ) {}

    /**
     * Establece y retorna la conexión PDO.
     */
    public function connect(): PDO
    {
        if ($this->connection === null) {
            try {
                $this->connection = new PDO(
                    $this->config->getDsn(),
                    $this->config->username,
                    $this->config->password,
                    $this->config->options
                );
            } catch (PDOException $e) {
                // En producción no deberíamos mostrar el mensaje directo de PDO por seguridad
                throw new \RuntimeException("Error al conectar a la base de datos: " . $e->getMessage());
            }
        }

        return $this->connection;
    }

    /**
     * Verifica si la conexión está activa.
     */
    public function testConnection(): bool
    {
        try {
            $this->connect();
            return true;
        } catch (\Exception) {
            return false;
        }
    }
    
    /**
     * Obtiene la configuración actual.
     */
    public function getConfig(): DatabaseConfig
    {
        return $this->config;
    }
}
