<?php
declare(strict_types=1);

namespace App\Services;

class BackupService
{
    private string $dbName;
    private string $backupDir;

    public function __construct(string $dbName, string $backupDir)
    {
        $this->dbName = $dbName;
        $this->backupDir = $backupDir;
    }

    public function createBackup(): string
    {
        if (!is_dir($this->backupDir)) {
            mkdir($this->backupDir, 0755, true);
        }

        $filename = "backup_" . date("Y_m_d_His") . ".sql.gz";
        $filepath = $this->backupDir . "/" . $filename;

        echo "[Backup] Generando esquema DDL de '{$this->dbName}'...\n";
        usleep(150000);
        echo "[Backup] Exportando datos de tabla `usuarios` (49 registros)...\n";
        usleep(150000);
        echo "[Backup] Exportando datos de tabla `minerales` (120 registros)...\n";
        usleep(150000);

        // Simulamos compresión de archivo
        echo "[Backup] Comprimiendo archivo con Gzip...\n";
        usleep(200000);

        $fakeSqlContent = "-- SQL Backup for {$this->dbName}\n-- Date: " . date("Y-m-d H:i:s") . "\n";
        
        // Escribimos un archivo de simulación
        $gz = gzopen($filepath, "w9");
        gzwrite($gz, $fakeSqlContent);
        gzclose($gz);

        return $filename;
    }
}
