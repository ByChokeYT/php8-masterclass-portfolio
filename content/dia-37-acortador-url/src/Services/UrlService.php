<?php
declare(strict_types=1);

namespace App\Services;

use PDO;

class UrlService {
    private PDO $db;

    public function __construct() {
        $dbPath = __DIR__ . '/../../database/urls.db';
        $this->db = new PDO("sqlite:$dbPath");
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->init();
    }

    private function init(): void {
        $this->db->exec("CREATE TABLE IF NOT EXISTS urls (
            id INTEGER PRIMARY KEY AUTOINCREMENT, 
            long_url TEXT NOT NULL, 
            short_code TEXT UNIQUE NOT NULL, 
            clicks INTEGER DEFAULT 0, 
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        );");
    }

    public function shorten(string $longUrl): string {
        // Verificar si ya existe
        $stmt = $this->db->prepare("SELECT short_code FROM urls WHERE long_url = ?");
        $stmt->execute([$longUrl]);
        $existing = $stmt->fetchColumn();
        if ($existing) return $existing;

        // Generar código único
        $code = substr(md5(uniqid((string)rand(), true)), 0, 6);
        
        $stmt = $this->db->prepare("INSERT INTO urls (long_url, short_code) VALUES (?, ?)");
        $stmt->execute([$longUrl, $code]);
        
        return $code;
    }

    public function getLongUrl(string $code): ?string {
        $stmt = $this->db->prepare("SELECT long_url FROM urls WHERE short_code = ?");
        $stmt->execute([$code]);
        $url = $stmt->fetchColumn();
        
        if ($url) {
            // Incrementar clicks
            $stmt = $this->db->prepare("UPDATE urls SET clicks = clicks + 1 WHERE short_code = ?");
            $stmt->execute([$code]);
            return (string)$url;
        }
        
        return null;
    }

    public function getStats(): array {
        $stmt = $this->db->query("SELECT * FROM urls ORDER BY created_at DESC LIMIT 5");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
