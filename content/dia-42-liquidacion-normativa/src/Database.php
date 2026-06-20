<?php
declare(strict_types=1);

namespace App;

use PDO;

class Database
{
    private static ?PDO $instance = null;

    public static function getConnection(): PDO
    {
        if (self::$instance === null) {
            $dbPath = __DIR__ . '/../database.sqlite';
            self::$instance = new PDO("sqlite:" . $dbPath);
            self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            self::$instance->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            
            // Inicializar tabla si no existe
            self::$instance->exec("
                CREATE TABLE IF NOT EXISTS liquidaciones (
                    id INTEGER PRIMARY KEY AUTOINCREMENT,
                    empleado TEXT NOT NULL,
                    salario_basico REAL NOT NULL,
                    descuento_afp REAL NOT NULL,
                    aporte_solidario REAL NOT NULL,
                    liquido_pagable REAL NOT NULL,
                    fecha DATETIME DEFAULT CURRENT_TIMESTAMP
                )
            ");
        }
        return self::$instance;
    }
}
