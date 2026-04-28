<?php

declare(strict_types=1);

namespace App\Models;

use App\DatabaseHost;
use PDO;

class ServiceRepository
{
    private PDO $db;

    public function __construct(DatabaseHost $host)
    {
        $this->db = $host->connect();
    }

    /**
     * @return Service[]
     */
    public function getAll(): array
    {
        $stmt = $this->db->query("SELECT * FROM services ORDER BY title ASC");
        $results = $stmt->fetchAll();

        return array_map(function ($row) {
            return new Service(
                id: (int)$row['id'],
                title: $row['title'],
                description: $row['description'],
                price: (float)$row['price'],
                imagePath: $row['image_path']
            );
        }, $results);
    }
}
