<?php
declare(strict_types=1);

namespace App\Services;

use App\Classes\Transaction;

/**
 * Capa de Servicio: BudgetManager (Gestor de Presupuesto)
 * 
 * Esta clase se encarga de abstraer TODA la lógica de negocio y persistencia
 * de datos relacionada con las transacciones. El archivo index.php nunca debe
 * tocar $_SESSION directamente; debe pedirle a BudgetManager que lo haga.
 */
class BudgetManager {
    /**
     * @var string Clave bajo la cual se guardan los datos en $_SESSION
     */
    private const SESSION_KEY = 'transactions_v1';

    /**
     * Constructor: Asegura que la sesión esté iniciada y la estructura de datos exista.
     */
    public function __construct() {
        // Verifica si la sesión ya está activa antes de llamar a session_start()
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        // Si es la primera vez que el usuario entra, inicializamos un array vacío
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
