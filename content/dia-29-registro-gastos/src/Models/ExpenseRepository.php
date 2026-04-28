<?php
declare(strict_types=1);
namespace App\Models;

use App\DatabaseHost;
use PDO;

class ExpenseRepository
{
    private \PDO $db;

    public function __construct(DatabaseHost $host)
    {
        $this->db = $host->connect();
    }

    /** @return Expense[] */
    public function getAll(): array
    {
        $stmt = $this->db->query("SELECT * FROM expenses ORDER BY expense_date DESC");
        return array_map(fn($r) => new Expense(
            id:          (int)$r['id'],
            description: $r['description'],
            amount:      (float)$r['amount'],
            category:    $r['category'],
            expenseDate: $r['expense_date']
        ), $stmt->fetchAll());
    }

    /** @return array{total:float, byCategory:array} */
    public function getSummary(): array
    {
        $total = (float)$this->db
            ->query("SELECT COALESCE(SUM(amount),0) FROM expenses")
            ->fetchColumn();

        $stmt = $this->db->query(
            "SELECT category, COALESCE(SUM(amount),0) as total
             FROM expenses GROUP BY category ORDER BY total DESC"
        );

        return ['total' => $total, 'byCategory' => $stmt->fetchAll()];
    }

    public function insert(string $desc, float $amount, string $category, string $date): bool
    {
        if (empty($desc) || $amount <= 0 || empty($category) || empty($date)) {
            throw new \InvalidArgumentException("Todos los campos son requeridos y el monto debe ser mayor a 0.");
        }

        $stmt = $this->db->prepare(
            "INSERT INTO expenses (description, amount, category, expense_date)
             VALUES (:desc, :amount, :category, :date)"
        );
        return $stmt->execute([
            'desc'     => $desc,
            'amount'   => $amount,
            'category' => $category,
            'date'     => $date,
        ]);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM expenses WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}
