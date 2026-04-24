<?php

declare(strict_types=1);

namespace App;

use PDO;
use Exception;

class CommentManager
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

    public function addComment(string $author, string $content): bool
    {
        $author = trim(strip_tags($author));
        $content = trim(strip_tags($content));

        if (empty($author) || empty($content)) {
            throw new Exception("Nombre y mensaje son obligatorios.");
        }

        if (strlen($content) > 500) {
            throw new Exception("El mensaje es demasiado largo (máx 500 caracteres).");
        }

        $stmt = $this->db->prepare("INSERT INTO comments (author, content) VALUES (:author, :content)");
        return $stmt->execute([
            ':author' => $author,
            ':content' => $content
        ]);
    }

    public function getComments(): array
    {
        $stmt = $this->db->query("SELECT *, datetime(created_at, 'localtime') as local_date FROM comments ORDER BY created_at DESC");
        return $stmt->fetchAll();
    }
}
