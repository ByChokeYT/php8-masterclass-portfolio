<?php

declare(strict_types=1);

require_once __DIR__ . '/src/Enums/MineralType.php';
require_once __DIR__ . '/src/DTO/Liquidacion.php';
require_once __DIR__ . '/src/Services/CalculatorService.php';

use App\Enums\MineralType;
use App\DTO\Liquidacion;
use App\Services\CalculatorService;

// ── Funciones de utilidad para la terminal ────────────────────────────────────

/** Envuelve texto con códigos de color ANSI */
function color(string $text, string $color = '37'): string
{
    return "\033[{$color}m{$text}\033[0m";
}

/** Limpia la pantalla */
function clear(): void
{
    echo "\033[2J\033[H";
}

/** Muestra un prompt y espera que el usuario escriba algo */
function input(string $prompt): string
{
    echo color($prompt, '1;36') . " ";
    return trim(fgets(STDIN));
}

// ── Inicio del programa ───────────────────────────────────────────────────────

clear();

echo color("==============================================\n", '1;33');
echo color("   CALCULADORA DE MINERALES v2.0\n", '1;33');
echo color("   Masterclass PHP 8.5 — Día 01\n", '1;33');
echo color("==============================================\n\n", '1;33');

// Menú de selección de mineral
echo color("Minerales disponibles:\n", '37');
echo color("  [1] 📦 Estaño  (Sn) — Sin ajuste de mercado\n", '32');
echo color("  [2] 🏗️ Zinc    (Zn) — −5% descuento por impurezas\n", '33');
echo color("  [3] 🪙 Plata   (Ag) — +2% prima por pureza\n\n", '37');

$opcion = input("Selecciona el mineral (1-3):");

$mineral = match($opcion) {
    '1' => MineralType::ESTANO,
    '2' => MineralType::ZINC,
    '3' => MineralType::PLATA,
    default => null,
};

if ($mineral === null) {
    echo color("\n❌ Opción inválida. Saliendo...\n\n", '1;31');
    exit(1);
}

// Captura de datos del usuario
$pesoKg       = (float) input("Peso bruto en kg:");
$cotizacion   = (float) input("Cotización actual en USD/kg:");
$pureza       = (float) input("Pureza del mineral (0-100)%:");

// Procesamiento con manejo de errores
try {
    $liquidacion = new Liquidacion($mineral, $pesoKg, $cotizacion, $pureza);
    $service     = new CalculatorService();
    $resultado   = $service->calculate($liquidacion);
    $grado       = $liquidacion->getGradoCalidad();

    // ── Pantalla de resultados ────────────────────────────────────────────────
    clear();

    echo color("==============================================\n", '1;32');
    echo color("   LIQUIDACIÓN FINAL\n", '1;32');
    echo color("==============================================\n", '1;32');

    echo color("\n  MINERAL\n", '37');
    echo color("  ──────────────────────────────────────\n", '90');
    echo color("  Tipo        : ", '37') . color(
        $mineral->getEmoji() . " " . $mineral->value . " (" . $mineral->getSymbol() . ")",
        '1;37'
    ) . "\n";
    echo color("  Ajuste      : ", '37') . color($resultado['ajusteLabel'], '1;33') . "\n";

    echo color("\n  DATOS DE ENTRADA\n", '37');
    echo color("  ──────────────────────────────────────\n", '90');
    echo color("  Peso bruto  : ", '37') . color(number_format($liquidacion->getPesoKg(), 3) . " kg", '1;37') . "\n";
    echo color("  Cotización  : ", '37') . color("$" . number_format($liquidacion->getCotizacionUsd(), 2) . " USD/kg", '1;37') . "\n";
    echo color("  Pureza      : ", '37') . color(number_format($pureza, 2) . "%", '1;37') . "\n";

    echo color("\n  CÁLCULO\n", '37');
    echo color("  ──────────────────────────────────────\n", '90');
    echo color("  Peso fino   : ", '37') . color(number_format($liquidacion->getPesoFinoKg(), 4) . " kg", '1;37') . "\n";
    echo color("  Calidad     : ", '37') . color($grado['label'], $grado['color']) . "\n";
    echo color("  Info        : ", '37') . color($grado['desc'], '90') . "\n";

    echo color("\n  ══════════════════════════════════════\n", '1;32');
    echo color("  TOTAL A LIQUIDAR: ", '37') . color(
        "$" . number_format($resultado['totalUsd'], 2) . " USD",
        '1;32'
    ) . "\n";
    echo color("  ══════════════════════════════════════\n\n", '1;32');

} catch (\ValueError $e) {
    echo color("\n❌ Error de validación: " . $e->getMessage() . "\n\n", '1;31');
    exit(1);
}
