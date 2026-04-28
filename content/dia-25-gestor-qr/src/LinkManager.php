<?php

declare(strict_types=1);

namespace App;

use PDO;
use Exception;

class LinkManager
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
            $this->db->exec($sql);
        }
    }

    /**
     * Valida y guarda un enlace de forma segura en la base de datos.
     * Uso intensivo de validación nativa de PHP.
     */
    public function saveLink(string $title, string $url): bool
    {
        $title = trim(htmlspecialchars($title, ENT_QUOTES, 'UTF-8'));
        $url = trim(filter_var($url, FILTER_SANITIZE_URL));

        if (empty($title)) {
            throw new Exception("El título no puede estar vacío.");
        }

        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            throw new Exception("Formato de URL inválido. Asegúrate de incluir http:// o https://");
        }

        $stmt = $this->db->prepare("INSERT INTO links (title, url) VALUES (:title, :url)");
        return $stmt->execute([
            ':title' => $title,
            ':url' => $url
        ]);
    }

    /**
     * Recupera todos los enlaces ordenados cronológicamente,
     * transformando el UTC nativo al localtime del sistema para el UI.
     */
    public function getLinks(): array
    {
        // Se extrae explícitamente datetime(..., 'localtime') para precisión en dashboard
        $stmt = $this->db->query("
            SELECT id, title, url, datetime(created_at, 'localtime') as created_at_local 
            FROM links 
            ORDER BY created_at DESC
        ");
        
        return $stmt->fetchAll();
    }
}
