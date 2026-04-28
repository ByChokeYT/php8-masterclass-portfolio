<?php
declare(strict_types=1);
require_once __DIR__ . '/src/Enums/MineralType.php';
require_once __DIR__ . '/src/DTO/Liquidacion.php';
require_once __DIR__ . '/src/Services/CalculatorService.php';
use App\Enums\MineralType;
use App\DTO\Liquidacion;
use App\Services\CalculatorService;

function color(string $t, string $c = '37'): string { return "\033[{$c}m{$t}\033[0m"; }
function clear(): void { echo "\033[2J\033[H"; }
function input(string $p): string { echo color($p, '1;36') . " "; return trim(fgets(STDIN)); }

clear();
echo color("==============================================\n", '1;33');
echo color("   CALCULADORA DE MINERALES (NIVEL 1)\n", '1;33');
echo color("==============================================\n\n", '1;33');

echo color("Minerales disponibles:\n", '37');
echo color("  [1] 📦 Estaño\n", '32');
echo color("  [2] 🏗️ Zinc\n", '33');
echo color("  [3] 🪙 Plata\n", '37');
echo color("  [4] 🥇 ORO (+5% Prima)\n", '1;33'); // [NUEVO]

$opcion = input("\nSelecciona el mineral (1-4):");
$mineral = match($opcion) {
    '1' => MineralType::ESTANO,
    '2' => MineralType::ZINC,
    '3' => MineralType::PLATA,
    '4' => MineralType::ORO, // [NUEVO]
    default => null,
};

if (!$mineral) { echo "Opción inválida.\n"; exit; }

$peso = (float)input("Peso bruto (kg):");
$cot  = (float)input("Cotización (USD/kg):");
$pur  = (float)input("Pureza (%):");

try {
    $liq = new Liquidacion($mineral, $peso, $cot, $pur);
    $res = (new CalculatorService())->calculate($liq);
    echo color("\nTOTAL A LIQUIDAR: $" . number_format($res['totalUsd'], 2) . " USD\n", '1;32');
} catch (\Exception $e) { echo "Error: " . $e->getMessage() . "\n"; }
