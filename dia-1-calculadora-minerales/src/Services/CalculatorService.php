<?php

declare(strict_types=1);

namespace App\Services;

use App\DTO\Liquidacion;
use App\Enums\MineralType;

class CalculatorService
{
    /**
     * Calcula el valor total de un lote de mineral.
     * 
     * @param Liquidacion $liquidacion El DTO inmutable con los datos
     * @return float El valor total calculado
     */
    public function calculate(Liquidacion $liquidacion): float
    {
        $pesoFino = $liquidacion->getPesoFino();
        
        // Lógica de cálculo usando la expresión match de PHP 8
        $total = match($liquidacion->mineral) {
            MineralType::ESTANO => $pesoFino * $liquidacion->cotizacionUsd,
            MineralType::ZINC   => $pesoFino * $liquidacion->cotizacionUsd * 0.95, // 5% descuento por impurezas (ejemplo real de mercado)
            MineralType::PLATA  => $pesoFino * $liquidacion->cotizacionUsd * 1.02, // 2% prima extra (ejemplo)
        };

        return round($total, 2);
    }
}
