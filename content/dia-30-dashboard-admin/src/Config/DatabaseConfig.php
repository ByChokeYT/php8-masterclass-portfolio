<?php

declare(strict_types=1);

namespace App\Config;

/**
 * PHP 8.5: Flexible Database Configuration for Multi-Project Dashboard
 */
readonly class DatabaseConfig
{
    public function __construct(
        public string $databasePath,
        public string $driver = 'sqlite',
        public string $username = 'root',
        public string $password = ''
    ) {}

    public function getDsn(): string
    {
        if ($this->driver === 'sqlite') {
            return "sqlite:" . $this->databasePath;
        }

        return sprintf(
            "%s:host=127.0.0.1;dbname=%s;charset=utf8mb4",
            $this->driver,
            $this->databasePath
        );
    }
}
