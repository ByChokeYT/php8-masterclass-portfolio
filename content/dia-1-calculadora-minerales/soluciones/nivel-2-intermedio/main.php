<?php
declare(strict_types=1);
require_once __DIR__ . '/src/Enums/MineralType.php';
require_once __DIR__ . '/src/DTO/Liquidacion.php';
require_once __DIR__ . '/src/Services/CalculatorService.php';
use App\Enums\MineralType;
use App\DTO\Liquidacion;
use App\Services\CalculatorService;

function color(string $t, string $c = '37'): string { return "\033[{$c}m{$t}\033[0m"; }
function input(string $p): string { echo color($p, '1;36') . " "; return trim(fgets(STDIN)); }

$ejecutando = true;

while ($ejecutando) {
    echo "\033[2J\033[H";
    echo color("==============================================\n", '1;33');
    echo color("   CALCULADORA INTERACTIVA (NIVEL 2)\n", '1;33');
    echo color("==============================================\n\n", '1;33');

    echo color("Minerales:\n [1] Sn [2] Zn [3] Ag [4] Au\n", '37');
    $opcion = input("Selección:");
    $mineral = match($opcion) { '1'=>MineralType::ESTANO, '2'=>MineralType::ZINC, '3'=>MineralType::PLATA, '4'=>MineralType::ORO, default=>null };

    if ($mineral) {
        $peso = (float)input("Peso (kg):");
        $cot  = (float)input("Cotización (USD/kg):");
        $pur  = (float)input("Pureza (%):");

        try {
            $liq = new Liquidacion($mineral, $peso, $cot, $pur);
            $res = (new CalculatorService())->calculate($liq);
            echo color("\nTOTAL: $" . number_format($res['totalUsd'], 2) . " USD\n", '1;32');
        } catch (\Exception $e) { echo "Error: " . $e->getMessage() . "\n"; }
    } else { echo "Opción inválida.\n"; }

    $continuar = input("\n¿Calcular otro? (s/n):");
    if (strtolower($continuar) !== 's') {
        $ejecutando = false;
        echo color("\n¡Gracias por usar el sistema!\n", '1;35');
    }
}
