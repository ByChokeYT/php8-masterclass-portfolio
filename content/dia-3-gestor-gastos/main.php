<?php
declare(strict_types=1);

require_once __DIR__ . '/src/Classes/Transaction.php';
require_once __DIR__ . '/src/Services/BudgetManager.php';

use App\Services\BudgetManager;

$manager = new BudgetManager();

echo "\033[1;36mGESTOR DE GASTOS v1.0 — CLI EDITION\033[0m\n";
echo "==============================================\n\n";

// Simulación de interacción CLI
echo "\033[1;32m[+] Añadiendo ingresos y gastos...\033[0m\n";
$manager->addTransaction("Sueldo Mensual", 2500.0, "Trabajo", "income");
$manager->addTransaction("Alquiler", 800.0, "Vivienda", "expense");
$manager->addTransaction("Supermercado", 350.0, "Comida", "expense");
$manager->addTransaction("Freelance PHP", 1200.0, "Trabajo", "income");

$transactions = $manager->getTransactions();
$balance = $manager->getBalance();

echo "\n\033[1;33mLISTADO DE MOVIMIENTOS:\033[0m\n";
echo "----------------------------------------------\n";
foreach ($transactions as $t) {
    $symbol = $t->type === 'income' ? '+' : '-';
    $color = $t->type === 'income' ? "\033[0;32m" : "\033[0;31m";
    printf("%-20s | %s%s$%-10.2f\033[0m | %s\n", 
        $t->description, 
        $color, 
        $symbol, 
        $t->amount, 
        $t->category
    );
}

echo "----------------------------------------------\n";
echo "\033[1;37mBALANCE TOTAL: \033[1;32m$" . number_format($balance, 2) . " USD\033[0m\n";
echo "==============================================\n";
