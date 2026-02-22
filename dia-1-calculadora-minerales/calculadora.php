<?php

declare(strict_types=1);

// ==========================================
// 1. Calculadora de Pureza de Minerales
// ==========================================

// Definimos los minerales usando un Enum respaldado por string (PHP 8.1+)
enum MineralType: string {
    case ESTANO = 'Estaño';
    case ZINC   = 'Zinc';
    case PLATA  = 'Plata';

    public function getSymbol(): string {
        return match($this) {
            self::ESTANO => 'Sn',
            self::ZINC   => 'Zn',
            self::PLATA  => 'Ag',
        };
    }
}

// Data Transfer Object usando readonly class (PHP 8.2+) para inmutabilidad
readonly class Liquidacion {
    public function __construct(
        public MineralType $mineral,
        public float $pesoKg,
        public float $cotizacionUsd,
        public float $purezaPorcentaje
    ) {}

    // Lógica principal de cálculo usando match()
    public function calcularTotal(): float {
        // Obtenemos el peso fino basado en la pureza
        $pesoFino = $this->pesoKg * ($this->purezaPorcentaje / 100);

        // Lógica de cálculo base con match (se pueden agregar castigos/bonos por mineral)
        $valorBase = match($this->mineral) {
            MineralType::ESTANO => $pesoFino * $this->cotizacionUsd,           // Directo
            MineralType::ZINC   => $pesoFino * $this->cotizacionUsd * 0.95,    // 5% de descuento por impurezas (ejemplo)
            MineralType::PLATA  => $pesoFino * $this->cotizacionUsd * 1.02,    // 2% de prima por plata (ejemplo)
        };

        return round($valorBase, 2);
    }
}

// Función helper para leer input del usuario de forma segura en CLI
function prompt(string $mensaje): string {
    echo "\033[1;36m$mensaje\033[0m "; // Color Cyan
    return trim(fgets(STDIN));
}

// Función para imprimir errores en rojo
function error(string $mensaje): void {
    echo "\033[1;31m❌ Error: $mensaje\033[0m\n";
}

// Función para limpiar pantalla (Linux/Mac/Windows)
function clear_screen(): void {
    echo "\033[2J\033[H";
}

// ==========================================
// EJECUCIÓN DEL SCRIPT
// ==========================================

clear_screen();
echo "\033[1;33m==============================================\033[0m\n";
echo "\033[1;32m  ⚒️ CALCULADORA DE PUREZA DE MINERALES v2.0 \033[0m\n";
echo "\033[1;33m==============================================\033[0m\n\n";

// 1. Seleccionar Mineral
echo "Seleccione el mineral a liquidar:\n";
$minerales = MineralType::cases();
foreach ($minerales as $index => $mineral) {
    echo "  [" . ($index + 1) . "] " . $mineral->value . " (" . $mineral->getSymbol() . ")\n";
}

$mineralElegido = null;
while ($mineralElegido === null) {
    $opcion = (int) prompt("\nOpción (1-" . count($minerales) . "):");
    if (isset($minerales[$opcion - 1])) {
        $mineralElegido = $minerales[$opcion - 1];
    } else {
        error("Opción inválida.");
    }
}

// 2. Ingresar Peso
$peso = -1.0;
while ($peso <= 0) {
    $input = prompt("Ingrese el Peso Bruto en Kg:");
    if (is_numeric($input) && (float)$input > 0) {
        $peso = (float)$input;
    } else {
        error("El peso debe ser un número mayor a 0.");
    }
}

// 3. Ingresar Pureza (Ley)
$pureza = -1.0;
while ($pureza <= 0 || $pureza > 100) {
    $input = prompt("Ingrese el porcentaje de Pureza (Ej: 45.5):");
    if (is_numeric($input) && (float)$input > 0 && (float)$input <= 100) {
        $pureza = (float)$input;
    } else {
        error("La pureza debe ser un número entre 0.1 y 100.");
    }
}

// 4. Ingresar Cotización
$cotizacion = -1.0;
while ($cotizacion <= 0) {
    $input = prompt("Ingrese la cotización actual por Kg (USD):");
    if (is_numeric($input) && (float)$input > 0) {
        $cotizacion = (float)$input;
    } else {
        error("La cotización debe ser un número mayor a 0.");
    }
}

// 5. Instanciar DTO inmutable y calcular
$liquidacion = new Liquidacion($mineralElegido, $peso, $cotizacion, $pureza);
$totalAPagar = $liquidacion->calcularTotal();
$pesoFinoStr = number_format($peso * ($pureza / 100), 2);

// 6. Generar Ticket / Recibo en consola
echo "\n\033[1;32m==============================================\033[0m\n";
echo "\033[1;37m             TICKET DE LIQUIDACIÓN            \033[0m\n";
echo "\033[1;32m==============================================\033[0m\n";
echo "📦 Tipo de Mineral : \033[1;33m{$liquidacion->mineral->value} ({$liquidacion->mineral->getSymbol()})\033[0m\n";
echo "⚖️  Peso Bruto      : " . number_format($liquidacion->pesoKg, 2) . " Kg\n";
echo "🔬 Pureza (Ley)    : " . number_format($liquidacion->purezaPorcentaje, 2) . " %\n";
echo "💎 Peso Fino Real  : \033[1;36m{$pesoFinoStr} Kg\033[0m\n";
echo "💵 Cotización      : $ " . number_format($liquidacion->cotizacionUsd, 2) . " USD/Kg\n";
echo "\033[1;32m----------------------------------------------\033[0m\n";
echo "💰 TOTAL A PAGAR   : \033[1;32m$ " . number_format($totalAPagar, 2) . " USD\033[0m\n";
echo "\033[1;32m==============================================\033[0m\n\n";

