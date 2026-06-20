<?php
declare(strict_types=1);

namespace App\Core;

use PDO;

class App
{
    private PDO $db;

    public function __construct()
    {
        $dbPath = __DIR__ . '/../../ecosystem.sqlite';
        $this->db = new PDO("sqlite:" . $dbPath);
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $this->db->exec("
            CREATE TABLE IF NOT EXISTS system_logs (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                action TEXT NOT NULL,
                user TEXT NOT NULL,
                timestamp DATETIME DEFAULT CURRENT_TIMESTAMP
            )
        ");
    }

    public function logAction(string $action, string $user): void
    {
        $stmt = $this->db->prepare("INSERT INTO system_logs (action, user) VALUES (:action, :user)");
        $stmt->execute([':action' => $action, ':user' => $user]);
    }

    public function getLogsCount(): int
    {
        return (int)$this->db->query("SELECT COUNT(*) FROM system_logs")->fetchColumn();
    }
}
