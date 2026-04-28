<?php

declare(strict_types=1);

namespace App\Config;

/**
 * Clase inmutable para la configuración de la base de datos.
 * Aprovecha las propiedades readonly de PHP 8.2+ para garantizar la integridad.
 */
readonly class DatabaseConfig
{
    public function __construct(
        public string $driver = 'sqlite',
        public string $host = 'localhost',
        public string $database = 'database.sqlite',
        #[\SensitiveParameter]
        public string $username = 'root',
        #[\SensitiveParameter]
        public string $password = '',
        public int $port = 3306,
        public array $options = [
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
            \PDO::ATTR_EMULATE_PREPARES => false,
        ]
    ) {}

    /**
     * Genera el DSN (Data Source Name) dinámicamente.
     */
    public function getDsn(): string
    {
        return match ($this->driver) {
            'sqlite' => "sqlite:" . __DIR__ . "/../../data/" . $this->database,
            'mysql' => "mysql:host={$this->host};port={$this->port};dbname={$this->database};charset=utf8mb4",
            default => throw new \InvalidArgumentException("Driver no soportado: {$this->driver}"),
        };
    }
}
