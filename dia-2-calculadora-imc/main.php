<?php

declare(strict_types=1);

require_once __DIR__ . '/src/Contracts/CalculadoraInterface.php';
require_once __DIR__ . '/src/Enums/SistemaUnidad.php';
require_once __DIR__ . '/src/Enums/ClasificacionImc.php';
require_once __DIR__ . '/src/DTO/MedicionCorporal.php';
require_once __DIR__ . '/src/Services/ImcCalculatorService.php';

use App\Enums\SistemaUnidad;
use App\DTO\MedicionCorporal;
use App\Services\ImcCalculatorService;

// ── UTILIDADES CLI ────────────────────────────────────────────────────────────

/**
 * Aplica color ANSI al texto para la terminal.
 */
function color(string $text, string $color = '37'): string {
    return "\033[{$color}m{$text}\033[0m";
}

/**
 * Limpia la pantalla de la terminal.
 */
function clear(): void {
    echo "\033[2J\033[H";
}

/**
 * Captura entrada del usuario con un prompt colorido.
 */
function input(string $prompt, string $colorCode = '1;36'): string {
    echo color($prompt, $colorCode) . " ";
    return trim(fgets(STDIN));
}

/**
 * Dibuja una barra visual de IMC con indicador de posición.
 */
function dibujarBarra(int $posicion): void {
    $ancho = 40;
    $posPixel = (int) round(($posicion * $ancho) / 100);

    echo "  ";
    for ($i = 0; $i <= $ancho; $i++) {
        $char = ($i === $posPixel) ? '▲' : '─';
        $colorBarra = match(true) {
            $i < 10  => '1;34', // Bajo
            $i < 20  => '1;32', // Normal
            $i < 30  => '1;33', // Sobrepeso
            default  => '1;31', // Obesidad
        };
        echo color($char, $colorBarra);
    }
    echo "\n";
    echo color("  BP        N          SP       O-I   O-II  O-III\n", '90');
}

// ── INICIO DEL PROGRAMA ───────────────────────────────────────────────────────

clear();
echo color("==============================================\n", '1;36');
echo color("   CALCULADORA DE IMC v1.0 — ELITE\n", '1;36');
echo color("   Masterclass PHP 8.5 — Día 02\n", '1;36');
echo color("==============================================\n\n", '1;36');

$nombre = input("¿Cuál es tu nombre?");
if (empty($nombre)) $nombre = 'Paciente';

echo color("\nSistemas disponibles:\n", '37');
echo color("  [1] Métrico   (kg / m)\n", '32');
echo color("  [2] Imperial  (lbs / ft)\n", '33');

$opcion = input("\nSelecciona el sistema (1-2):");
$sistema = match($opcion) {
    '1' => SistemaUnidad::METRICO,
    '2' => SistemaUnidad::IMPERIAL,
    default => null
};

if (!$sistema) {
    echo color("\n❌ Error: Opción no válida. Saliendo...\n", '1;31');
    exit(1);
}

$peso   = (float) input("Peso ({$sistema->getUnidadPeso()}):");
$altura = (float) input("Altura ({$sistema->getUnidadAltura()}):");

try {
    $medicion = new MedicionCorporal($sistema, $peso, $altura, $nombre);
    $servicio = new ImcCalculatorService($medicion);
    $resultado = $servicio->getResultado();
    $ideal     = $servicio->getPesoIdeal();

    clear();
    echo color("==============================================\n", '1;36');
    echo color("   RESULTADOS PARA: " . strtoupper($nombre) . "\n", '1;36');
    echo color("==============================================\n\n", '1;36');

    // Bloque de Datos
    echo color("  DATOS INGRESADOS\n", '1;37');
    echo color("  " . str_repeat('─', 38) . "\n", '90');
    echo "  Peso   : " . color(number_format($medicion->getPesoKg(), 1) . " kg", '1;37') . "\n";
    echo "  Altura : " . color(number_format($medicion->getAlturaMetros(), 2) . " m", '1;37') . "\n";
    echo "  Sistema: " . color($sistema->value, '1;37') . "\n\n";

    // Bloque de IMC
    echo color("  CÁLCULO MÉDICO\n", '1;37');
    echo color("  " . str_repeat('─', 38) . "\n", '90');
    echo "  IMC    : " . color($resultado['imcFormateado'], '1;37') . "\n";
    echo "  Estado : " . color($resultado['label'], $resultado['color']) . "\n\n";

    // Visualización
    dibujarBarra((int)$resultado['posicionBarra']);

    // Rango Saludable
    echo color("\n  RANGO SALUDABLE (OMS)\n", '1;37');
    echo color("  " . str_repeat('─', 38) . "\n", '90');
    echo "  Ideal  : " . color("{$ideal['pesoMinimo']}kg — {$ideal['pesoMaximo']}kg", '1;32') . "\n";

    if ($ideal['enRango']) {
        echo "  Estado : " . color("✓ Estás en tu peso ideal", '1;32') . "\n";
    } else {
        $diferenciaValue = $ideal['diferencia'];
        $accion = $diferenciaValue > 0 ? "ganar" : "perder";
        echo "  Acción : " . color(abs($diferenciaValue) . " kg por " . $accion, '1;33') . "\n";
    }

    // Recomendación Final
    echo color("\n  " . str_repeat('═', 42) . "\n", $resultado['color']);
    echo "  " . color($resultado['recomendacion'], $resultado['color']) . "\n";
    echo color("  " . str_repeat('═', 42) . "\n\n", $resultado['color']);

} catch (\Exception $e) {
    echo color("\n❌ Error: " . $e->getMessage() . "\n\n", '1;31');
}
