<?php

declare(strict_types=1);

namespace App\Models;

use App\DatabaseHost;
use PDO;

class ContactRepository
{
    private PDO $db;

    public function __construct(DatabaseHost $host)
    {
        $this->db = $host->connect();
    }

    /**
     * @return Contact[]
     */
    public function search(string $query = '', string $filter = 'name'): array
    {
        $allowedFilters = ['name', 'email', 'company', 'role'];
        if (!in_array($filter, $allowedFilters)) {
            $filter = 'name';
        }

        $sql = "SELECT * FROM contacts";
        $params = [];

        if (!empty($query)) {
            $sql .= " WHERE $filter LIKE :query";
            $params['query'] = "%$query%";
        }

        $sql .= " ORDER BY name ASC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        $results = $stmt->fetchAll();

        return array_map(fn($row) => new Contact(
            id: (int)$row['id'],
            name: $row['name'],
            email: $row['email'],
            phone: $row['phone'],
            company: $row['company'],
            role: $row['role']
        ), $results);
    }
}
