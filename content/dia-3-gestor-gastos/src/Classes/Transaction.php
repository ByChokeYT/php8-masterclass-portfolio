<?php
declare(strict_types=1);

namespace App\Classes;

class Transaction {
    public function __construct(
        public string $id,
        public string $description,
        public float $amount,
        public string $category,
        public string $type, // 'income' or 'expense'
        public string $date
    ) {}

    public static function create(string $description, float $amount, string $category, string $type): self {
        return new self(
            uniqid(),
            $description,
            $amount,
            $category,
            $type,
            date('Y-m-d H:i:s')
        );
    }
}
