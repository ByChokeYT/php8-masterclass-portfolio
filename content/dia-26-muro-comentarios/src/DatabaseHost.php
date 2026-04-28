<?php

declare(strict_types=1);

namespace App;

use App\Config\DatabaseConfig;
use PDO;
use PDOException;
use Exception;

/**
 * PHP 8.5: Database connection manager with constructor promotion
 */
class DatabaseHost
{
    private ?PDO $connection = null;

    public function __construct(private readonly DatabaseConfig $config) {}

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
            } catch (PDOException $e) {
                throw new Exception("Database Connection Error: " . $e->getMessage());
            }
        }

        return $this->connection;
    }
}
