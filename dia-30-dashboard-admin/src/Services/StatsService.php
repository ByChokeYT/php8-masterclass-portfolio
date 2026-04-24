<?php

declare(strict_types=1);

namespace App\Services;

use App\DatabaseHost;
use App\Config\DatabaseConfig;
use PDO;

class StatsService
{
    private string $basePath;

    public function __construct()
    {
        $this->basePath = __DIR__ . '/../../../';
    }

    private function getCount(string $relPath, string $tableName): int
    {
        try {
            $absPath = realpath($this->basePath . $relPath);
            if (!$absPath || !file_exists($absPath)) return 0;

            $config = new DatabaseConfig($absPath);
            $host = new DatabaseHost($config);
            $db = $host->connect();
            
            return (int)$db->query("SELECT COUNT(*) FROM $tableName")->fetchColumn();
        } catch (\Exception $e) {
            return 0;
        }
    }

    private function getSum(string $relPath, string $tableName, string $column): float
    {
        try {
            $absPath = realpath($this->basePath . $relPath);
            if (!$absPath || !file_exists($absPath)) return 0;

            $config = new DatabaseConfig($absPath);
            $host = new DatabaseHost($config);
            $db = $host->connect();
            
            return (float)$db->query("SELECT SUM($column) FROM $tableName")->fetchColumn();
        } catch (\Exception $e) {
            return 0;
        }
    }

    public function getGlobalStats(): array
    {
        return [
            'guests'   => $this->getCount('dia-22-crud-invitados/data/eventos_academia.sqlite', 'guests'),
            'users'    => $this->getCount('dia-24-registro-seguro/data/seguridad.sqlite', 'users'),
            'expenses' => $this->getSum('dia-29-registro-gastos/data/gastos.sqlite', 'expenses', 'amount'),
            'minerals' => $this->getCount('dia-23-inventario-minerales/data/mineria_transaccional.sqlite', 'minerals'),
            'links'    => $this->getCount('dia-25-gestor-qr/data/qr_links.sqlite', 'links'),
            'comments' => $this->getCount('dia-26-muro-comentarios/data/muro_deseos.sqlite', 'comments'),
            'total_registros' => $this->getCount('dia-29-registro-gastos/data/gastos.sqlite', 'expenses')
        ];
    }
}
