<?php
declare(strict_types=1);
namespace App\Models;

readonly class Expense
{
    public function __construct(
        public int    $id,
        public string $description,
        public float  $amount,
        public string $category,
        public string $expenseDate
    ) {}

    public function formattedAmount(): string
    {
        return 'Bs. ' . number_format($this->amount, 2);
    }

    public function formattedDate(): string
    {
        return date('d M Y', strtotime($this->expenseDate));
    }
}
