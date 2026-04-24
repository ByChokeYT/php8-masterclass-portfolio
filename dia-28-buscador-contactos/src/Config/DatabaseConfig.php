<?php

declare(strict_types=1);

namespace App\Config;

readonly class DatabaseConfig
{
    public function __construct(
        public string $driver,
        public string $database,
        public string $host = '127.0.0.1',
        public string $username = 'root',
        public string $password = ''
    ) {}

    public function getDsn(): string
    {
        if ($this->driver === 'sqlite') {
            return "sqlite:" . __DIR__ . "/../../data/" . $this->database;
        }

        return sprintf(
            "%s:host=%s;dbname=%s;charset=utf8mb4",
            $this->driver,
            $this->host,
            $this->database
        );
    }
}
