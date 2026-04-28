<?php

declare(strict_types=1);

namespace App;

use PDO;
use Exception;

class InventoryManager
{
    private PDO $db;

    public function __construct(DatabaseHost $dbHost)
    {
        $this->db = $dbHost->connect();
        $this->initialize();
    }

    private function initialize(): void
    {
        $sql = file_get_contents(__DIR__ . '/../data/schema.sql');
        if ($sql !== false) {
            // SQLite permite múltiples sentencias si se ejecuta directamente
            $this->db->exec($sql);
        }
    }

    /**
     * Obtiene el estado actual del inventario.
     */
    public function getStock(): array
    {
        $stmt = $this->db->query("SELECT * FROM minerals ORDER BY name ASC");
        return $stmt->fetchAll();
    }

    /**
     * Obtiene los últimos movimientos.
     */
    public function getLogs(int $limit = 20): array
    {
        $stmt = $this->db->prepare("
            SELECT l.id, l.mineral_id, l.type, l.quantity, l.reason, datetime(l.created_at, 'localtime') as created_at, m.name as mineral_name, m.symbol 
            FROM inventory_logs l 
            JOIN minerals m ON l.mineral_id = m.id 
            ORDER BY l.created_at DESC 
            LIMIT :limit
        ");
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * Procesa un movimiento de inventario usando TRANSACCIONES.
     * Garantiza que el stock y el log se actualicen atómicamente.
     */
    public function recordMovement(int $mineralId, string $type, float $quantity, string $reason): bool
    {
        if ($quantity <= 0) throw new Exception("La cantidad debe ser mayor a cero.");
        
        try {
            // 1. INICIAR TRANSACCIÓN
            $this->db->beginTransaction();

            // 2. Verificar existencia y stock actual
            $stmt = $this->db->prepare("SELECT stock FROM minerals WHERE id = :id");
            $stmt->execute([':id' => $mineralId]);
            $mineral = $stmt->fetch();

            if (!$mineral) throw new Exception("Mineral no encontrado.");

            $currentStock = (float)$mineral['stock'];
            $newStock = ($type === 'IN') ? $currentStock + $quantity : $currentStock - $quantity;

            if ($newStock < 0) throw new Exception("Stock insuficiente para realizar la salida. Stock actual: $currentStock Kg.");

            // 3. Actualizar Stock
            $upd = $this->db->prepare("UPDATE minerals SET stock = :stock WHERE id = :id");
            $upd->execute([':stock' => $newStock, ':id' => $mineralId]);

            // 4. Insertar Log de Auditoría
            $log = $this->db->prepare("INSERT INTO inventory_logs (mineral_id, type, quantity, reason) VALUES (:mid, :type, :qty, :reason)");
            $log->execute([
                ':mid' => $mineralId,
                ':type' => $type,
                ':qty' => $quantity,
                ':reason' => $reason
            ]);

            // 5. CERRAR TRANSACCIÓN (COMMIT)
            return $this->db->commit();

        } catch (Exception $e) {
            // 6. REVERTIR SI ALGO FALLA (ROLLBACK)
            if ($this->db->inTransaction()) {
                $this->db->rollBack();
            }
            throw $e;
        }
    }
}
