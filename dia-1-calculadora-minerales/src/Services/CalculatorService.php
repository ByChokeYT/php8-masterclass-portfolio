<?php

declare(strict_types=1);

namespace App\Services;

use App\DTO\Liquidacion;

/**
 * Servicio de cálculo de liquidación.
 *
 * Todos los cálculos se realizan en CENTAVOS (enteros)
 * para eliminar completamente los errores de punto flotante.
 */
class CalculatorService
{
    /**
     * Factor base: 10000 = 100.00% (sin ajuste)
     * Trabajamos en "puntos base" para evitar decimales.
     */
    private const FACTOR_BASE = 10000;

    /**
     * Factores de ajuste por mineral.
     * 9500  = 95.00% (descuento del 5%)
     * 10200 = 102.00% (prima del 2%)
     */
    private const FACTORES = [
        'Estaño' => 10000,
        'Zinc'   =>  9500,
        'Plata'  => 10200,
    ];

    /**
     * Calcula el valor total de la liquidación.
     *
     * Fórmula entera:
     * totalCentavos = (pesoFinoGramos × cotizacionCentavos × factor) / (1000 × BASE)
     *
     * ÷ 1000 porque el peso está en gramos (queremos el valor por kg)
     * ÷ BASE  para aplicar el factor de ajuste de mercado
     */
    public function calculate(Liquidacion $liquidacion): array
    {
        $factor = self::FACTORES[$liquidacion->mineral->value] ?? self::FACTOR_BASE;

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
