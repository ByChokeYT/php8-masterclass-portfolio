<?php

declare(strict_types=1);

namespace App;

use PDO;

class GuestManager
{
    private PDO $db;

    public function __construct(DatabaseHost $dbHost)
    {
        $this->db = $dbHost->connect();
        $this->initialize();
    }

    /**
     * Asegura que la tabla exista.
     */
    private function initialize(): void
    {
        $sql = file_get_contents(__DIR__ . '/../data/schema.sql');
        if ($sql !== false) {
            $this->db->exec($sql);
        }
    }

    /**
     * Obtiene todos los invitados.
     */
    public function getAll(): array
    {
        $stmt = $this->db->query("SELECT * FROM guests ORDER BY created_at DESC");
        return $stmt->fetchAll();
    }

    /**
     * Agrega un nuevo invitado.
     */
    public function add(string $name, string $email): bool
    {
        $stmt = $this->db->prepare("INSERT INTO guests (name, email) VALUES (:name, :email)");
        return $stmt->execute([
            ':name' => $name,
            ':email' => $email
        ]);
    }

    /**
     * Actualiza los datos de un invitado.
     */
    public function update(int $id, string $name, string $email): bool
    {
        $stmt = $this->db->prepare("UPDATE guests SET name = :name, email = :email WHERE id = :id");
        return $stmt->execute([
            ':name' => $name,
            ':email' => $email,
            ':id' => $id
        ]);
    }

    /**
     * Actualiza el estado de un invitado.
     */
    public function updateStatus(int $id, string $status): bool
    {
        $stmt = $this->db->prepare("UPDATE guests SET status = :status WHERE id = :id");
        return $stmt->execute([
            ':status' => $status,
            ':id' => $id
        ]);
    }

    /**
     * Elimina un invitado.
     */
    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM guests WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }

    /**
     * Busca un invitado por ID.
     */
    public function getById(int $id): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM guests WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $guest = $stmt->fetch();
        return $guest ?: null;
    }
}
