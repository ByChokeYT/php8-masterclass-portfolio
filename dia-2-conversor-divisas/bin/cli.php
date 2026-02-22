<?php
declare(strict_types=1);

require_once __DIR__ . '/../src/Enums/Currency.php';
require_once __DIR__ . '/../src/Services/ConverterService.php';

use App\Enums\Currency;
use App\Services\ConverterService;

// Simple CLI test
// Usage: php cli.php 100 USD BOB

$amount = (float) ($argv[1] ?? 1);
$from = Currency::tryFrom(strtoupper($argv[2] ?? 'USD'));
$to = Currency::tryFrom(strtoupper($argv[3] ?? 'BOB'));

if (!$from || !$to) {
    echo "Error: Moneda no válida.\n";
    echo "Uso: php cli.php [monto] [moneda_origen] [moneda_destino]\n";
    echo "Ejemplo: php cli.php 100 USD BOB\n";
    exit(1);
}

$service = new ConverterService();
$result = $service->convert($amount, $from, $to);

echo "---------------------------------\n";
echo "💱 Conversor de Divisas CLI\n";
echo "---------------------------------\n";
echo "💰 Origen:  {$from->getFlag()} {$amount} {$from->value}\n";
echo "💵 Destino: {$to->getFlag()} " . number_format($result, 2) . " {$to->value}\n";
echo "---------------------------------\n";
