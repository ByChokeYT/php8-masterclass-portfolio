<?php
declare(strict_types=1);

namespace App;

use PDO;

class AuditLogger
{
    private PDO $db;

    public function __construct()
    {
        $dbPath = __DIR__ . '/../audit.sqlite';
        $this->db = new PDO("sqlite:" . $dbPath);
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

        $this->db->exec("
            CREATE TABLE IF NOT EXISTS audit_logs (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                action TEXT NOT NULL,
                user TEXT NOT NULL,
                ip_address TEXT NOT NULL,
                user_agent TEXT NOT NULL,
                timestamp DATETIME DEFAULT CURRENT_TIMESTAMP
            )
        ");
    }

    public function log(string $action, string $user): void
    {
        $ip = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
        $ua = $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown';

        $stmt = $this->db->prepare("
            INSERT INTO audit_logs (action, user, ip_address, user_agent)
            VALUES (:action, :user, :ip, :ua)
        ");
        $stmt->execute([
            ':action' => $action,
            ':user' => $user,
            ':ip' => $ip,
            ':ua' => $ua
        ]);
    }

    public function getLogs(): array
    {
        return $this->db->query("SELECT * FROM audit_logs ORDER BY id DESC LIMIT 10")->fetchAll();
    }
}
