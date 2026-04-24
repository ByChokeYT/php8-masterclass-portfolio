<?php

declare(strict_types=1);

namespace App\Services;

use App\DTO\Liquidacion;
use App\Enums\MineralType;

/**
 * Servicio de cálculo de liquidación.
 *
 * UPGRADE v2: Todos los cálculos se realizan en CENTAVOS (enteros)
 * para eliminar completamente los errores de punto flotante IEEE 754.
 *
 * Ejemplo del problema clásico float:
 *   0.1 + 0.2 === 0.3  →  FALSE en PHP/cualquier lenguaje con float64
 *
 * Solución:
 *   10 + 20 === 30     →  TRUE siempre (aritmética entera exacta)
 */
class CalculatorService
{
    /**
     * Factores de ajuste de mercado por mineral (en puntos base enteros).
     * 10000 = 100.00% (sin ajuste)
     *  9500 =  95.00% (descuento 5%)
     * 10200 = 102.00% (prima 2%)
     */
    private const FACTOR_BASE = 10000;

    private const FACTORES = [
        'Estaño' => 10000, // Sin ajuste
        'Zinc'   =>  9500, // −5% por impurezas típicas del mercado
        'Plata'  => 10200, // +2% prima por pureza
    ];

    /**
     * Calcula el valor total en centavos (int) y lo devuelve en USD (float).
     *
     * Fórmula entera:
     *   totalCentavos = (pesoFinoGramos × cotizacionCentavos × factor) / (1000 × BASE)
     *
     * Todo en enteros → sin pérdida de precisión de punto flotante.
     */
    public function calculate(Liquidacion $liquidacion): array
    {
        $factor = self::FACTORES[$liquidacion->mineral->value] ?? self::FACTOR_BASE;

        // Cálculo 100% en enteros
        // pesoFinoGramos × cotizacionCentavos/kg → centavos totales
        // ÷ 1000 porque el peso está en gramos (1 kg = 1000 g)
        // ÷ FACTOR_BASE para aplicar el factor de ajuste
        $totalCentavos = intdiv(
            $liquidacion->getPesoFinoGramos() * $liquidacion->cotizacionCentavos * $factor,
            1000 * self::FACTOR_BASE
        );

        $ajustePct = ($factor / self::FACTOR_BASE) * 100;

        return [
            'totalCentavos' => $totalCentavos,
            'totalUsd'      => $totalCentavos / 100,
            'ajustePct'     => $ajustePct,
            'ajusteLabel'   => match(true) {
                $factor > self::FACTOR_BASE => sprintf('+%.0f%% prima de mercado', $ajustePct - 100),
                $factor < self::FACTOR_BASE => sprintf('−%.0f%% descuento por impurezas', 100 - $ajustePct),
                default                     => 'Sin ajuste de mercado',
            },
        ];
    }
}
