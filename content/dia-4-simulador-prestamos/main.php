<?php
declare(strict_types=1);

require_once __DIR__ . '/src/Classes/Loan.php';
require_once __DIR__ . '/src/Services/AmortizationService.php';

use App\Classes\Loan;
use App\Services\AmortizationService;

echo "\033[1;34mSIMULADOR FINANCIERO — CLI EDITION\033[0m\n";
echo "==============================================\n\n";

// Parámetros por defecto
$capital = 15000;
$tasa = 7.5;
$plazo = 12;

echo "Calculando préstamo: \033[1;37m$capital USD\033[0m al \033[1;37m$tasa%\033[0m en \033[1;37m$plazo meses\033[0m...\n\n";

$loan = new Loan($capital, $tasa, $plazo);
$service = new AmortizationService();
$result = $service->calculate($loan);

echo "\033[1;33mCRONOGRAMA DE AMORTIZACIÓN:\033[0m\n";
echo str_repeat("-", 60) . "\n";
printf("%-5s | %-12s | %-10s | %-10s | %-12s\n", "MES", "CUOTA", "INTERÉS", "CAPITAL", "SALDO");
echo str_repeat("-", 60) . "\n";

foreach ($result['schedule'] as $row) {
    printf("%-5d | %-12.2f | %-10.2f | %-10.2f | %-12.2f\n", 
        $row['month'], 
        $row['payment'], 
        $row['interest'], 
        $row['principal'], 
        $row['balance']
    );
}

echo str_repeat("-", 60) . "\n";
echo "\033[1;37mRESUMEN FINAL:\033[0m\n";
echo "Pago Mensual: \033[1;32m$" . number_format($result['summary']['monthly_payment'], 2) . "\033[0m\n";
echo "Total Interés: \033[1;31m$" . number_format($result['summary']['total_interest'], 2) . "\033[0m\n";
echo "Total a Pagar: \033[1;36m$" . number_format($result['summary']['total_payment'], 2) . "\033[0m\n";
echo "==============================================\n";
