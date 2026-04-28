<?php

declare(strict_types=1);

namespace App;

use App\Config\DatabaseConfig;
use PDO;
use PDOException;

/**
 * Gestor de la conexión a la base de datos usando PDO.
 */
class DatabaseHost
{
    private ?PDO $connection = null;

    public function __construct(private DatabaseConfig $config) {}

    public function connect(): PDO
    {
        if ($this->connection === null) {
            try {
                $this->connection = new PDO(
                    $this->config->getDsn(),
                    $this->config->username,
                    $this->config->password,
                    [
                        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                        PDO::ATTR_EMULATE_PREPARES   => false,
                    ]
                );
                
                // Asegurar modo de escritura en SQLite si aplica
                if ($this->config->driver === 'sqlite') {
                    $this->connection->exec('PRAGMA foreign_keys = ON;');
                }
                
            } catch (PDOException $e) {
                throw new \Exception("Error de conexión a la Base de Datos: " . $e->getMessage());
            }
        }

        return $this->connection;
    }
}
