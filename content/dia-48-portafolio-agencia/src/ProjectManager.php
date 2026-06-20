<?php
declare(strict_types=1);

namespace App;

use PDO;

class ProjectManager
{
    private PDO $db;

    public function __construct()
    {
        $dbPath = __DIR__ . '/../agency.sqlite';
        $this->db = new PDO("sqlite:" . $dbPath);
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        
        $this->db->exec("
            CREATE TABLE IF NOT EXISTS projects (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                title TEXT NOT NULL,
                category TEXT NOT NULL,
                description TEXT NOT NULL
            )
        ");
        
        // Insertar semillas si está vacío
        $count = $this->db->query("SELECT COUNT(*) FROM projects")->fetchColumn();
        if ($count == 0) {
            $this->addProject("Rediseño Web Corporativa", "Desarrollo Web", "Nueva plataforma interactiva construida en PHP 8.");
            $this->addProject("App de Monitoreo IoT", "Software Industrial", "Monitoreo en tiempo real de sensores mineros.");
        }
    }

    public function addProject(string $title, string $category, string $description): void
    {
        $stmt = $this->db->prepare("INSERT INTO projects (title, category, description) VALUES (:title, :category, :description)");
        $stmt->execute([
            ':title' => $title,
            ':category' => $category,
            ':description' => $description
        ]);
    }

    public function getProjects(): array
    {
        return $this->db->query("SELECT * FROM projects ORDER BY id DESC")->fetchAll();
    }
}
