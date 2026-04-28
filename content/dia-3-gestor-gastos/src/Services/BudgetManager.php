<?php
declare(strict_types=1);

namespace App\Services;

use App\Classes\Transaction;

class BudgetManager {
    private const SESSION_KEY = 'transactions_v1';

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION[self::SESSION_KEY])) {
            $_SESSION[self::SESSION_KEY] = [];
        }
    }

    public function addTransaction(string $description, float $amount, string $category, string $type): void {
        $transaction = Transaction::create($description, $amount, $category, $type);
        // Add to beginning of array
        array_unshift($_SESSION[self::SESSION_KEY], serialize($transaction));
    }

    /**
     * @return Transaction[]
     */
    public function getTransactions(): array {
        return array_map(fn($t) => unserialize($t), $_SESSION[self::SESSION_KEY]);
    }

    public function getBalance(): float {
        $balance = 0;
        foreach ($this->getTransactions() as $t) {
            if ($t->type === 'income') {
                $balance += $t->amount;
            } else {
                $balance -= $t->amount;
            }
        }
        return $balance;
    }

    public function clearTransactions(): void {
        $_SESSION[self::SESSION_KEY] = [];
    }
    
    public function deleteTransaction(string $id): void {
        $_SESSION[self::SESSION_KEY] = array_filter(
            $_SESSION[self::SESSION_KEY], 
            fn($s) => unserialize($s)->id !== $id
        );
    }
}
