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

$historial = []; // [NUEVO]
$ejecutando = true;

while ($ejecutando) {
    echo "\033[2J\033[H";
    echo color("==============================================\n", '1;35');
    echo color("   SISTEMA DE GESTIÓN (NIVEL 3 - AVANZADO)\n", '1;35');
    echo color("==============================================\n\n", '1;35');

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
            
            // Guardar en historial
            $historial[] = [
                'mineral' => $mineral->value,
                'peso' => $peso,
                'total' => $res['totalUsd']
            ];

            echo color("\nTOTAL: $" . number_format($res['totalUsd'], 2) . " USD\n", '1;32');
        } catch (\Exception $e) { echo "Error: " . $e->getMessage() . "\n"; }
    }

    $continuar = input("\n¿Calcular otro? (s/n):");
    if (strtolower($continuar) !== 's') $ejecutando = false;
}

// REPORTE FINAL [NUEVO]
echo "\033[2J\033[H";
echo color("==============================================\n", '1;32');
echo color("   RESUMEN DE LA SESIÓN\n", '1;32');
echo color("==============================================\n", '1;32');
$granTotal = 0;
foreach ($historial as $idx => $item) {
    echo sprintf(" [%d] %-8s | %8.2f kg | USD %10.2f\n", $idx+1, $item['mineral'], $item['peso'], $item['total']);
    $granTotal += $item['total'];
}
echo color("----------------------------------------------\n", '90');
echo color(" TOTAL ACUMULADO: ", '1;37') . color("$" . number_format($granTotal, 2) . " USD\n", '1;32');
echo color("==============================================\n\n", '1;32');
