<?php

declare(strict_types=1);

require_once __DIR__ . '/../src/Enums/MineralType.php';   
require_once __DIR__ . '/../src/Services/CalculatorService.php';

use App\Enums\MineralType;
use App\Services\CalculatorService;

// Función helper para limpiar la pantalla (solo Linux/Mac)
function clearScreen() {
    system('clear');
}

// Función para obtener input del usuario de forma segura
function prompt(string $message): string {
    echo $message . " ";
    return trim(fgets(STDIN));
}

// Inicio del programa
clearScreen();
echo "========================================\n";
echo "   CALCULADORA DE MINERALES  v1.0 (CLI) \n";
echo "========================================\n";

// 1. Mostrar opciones de minerales usando el Enum
echo "Seleccione un mineral:\n";
foreach (MineralType::cases() as $index => $mineral) {
    echo "[" . ($index + 1) . "] " . $mineral->value . " (" . $mineral->getSymbol() . ")\n";
}

// 2. Obtener selección de mineral
do {
    $seleccion = (int) prompt("\nIngrese el número del mineral:");
    $minerales = MineralType::cases();
    
    if (isset($minerales[$seleccion - 1])) {
        $mineralElegido = $minerales[$seleccion - 1];
        break;
    }
    echo "❌ Opción inválida. Intente de nuevo.\n";
} while (true);

// 3. Obtener peso
do {
    $pesoInput = prompt("Ingrese Peso Neto (Kg):");
    if (is_numeric($pesoInput) && (float)$pesoInput > 0) {
        $peso = (float)$pesoInput;
        break;
    }
    echo "❌ Peso inválido. Debe ser un número mayor a 0.\n";
} while (true);

// 4. Obtener cotización
do {
    $cotizacionInput = prompt("Ingrese Cotización (USD):");
    if (is_numeric($cotizacionInput) && (float)$cotizacionInput > 0) {
        $cotizacion = (float)$cotizacionInput;
        break;
    }
    echo "❌ Cotización inválida.\n";
} while (true);

// 5. Calcular
$servicio = new CalculatorService();
$total = $servicio->calculate($mineralElegido, $peso, $cotizacion);

// 6. Mostrar Resultados
echo "\n----------------------------------------\n";
echo " RESULTADO DE LIQUIDACIÓN \n";
echo "----------------------------------------\n";
echo "Mineral    : " . $mineralElegido->value . "\n";
echo "Peso       : " . number_format($peso, 2) . " Kg\n";
echo "Cotización : " . number_format($cotizacion, 2) . " USD\n";
echo "----------------------------------------\n";
echo "TOTAL A PAGAR: $ " . number_format($total, 2) . "\n";
echo "========================================\n\n";

