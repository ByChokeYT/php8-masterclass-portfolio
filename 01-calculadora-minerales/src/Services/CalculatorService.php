<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\MineralType;

class CalculatorService
{
    /**
     * Calcula el valor total de un lote de mineral.
     * 
     * @param MineralType $mineral El tipo de mineral (usando el Enum)
     * @param float $peso Peso en Kilogramos
     * @param float $cotizacion Precio por unidad (USD)
     * @return float El valor total calculado
     */
    public function calculate(MineralType $mineral, float $peso, float $cotizacion): float
    {
        // En una aplicación real, aquí aplicaríamos lógica específica por mineral.
        // Por ahora, aplicaremos una simple multiplicación, pero usaremos match
        // para demostrar cómo manejaríamos casos diferentes.
        
        return match($mineral) {
            MineralType::ESTANO => $peso * $cotizacion, // Lógica base
            MineralType::ZINC   => $peso * $cotizacion * 0.98, // Ejemplo: Descuento del 2% por impurezas típicas
            MineralType::PLATA  => $peso * $cotizacion,
            MineralType::ORO    => $peso * $cotizacion,
        };
    }
}
