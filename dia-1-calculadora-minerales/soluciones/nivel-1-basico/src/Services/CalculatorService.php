<?php
declare(strict_types=1);
namespace App\Services;
use App\DTO\Liquidacion;

class CalculatorService {
    private const FACTOR_BASE = 10000;
    private const FACTORES = [
        'Estaño' => 10000,
        'Zinc'   =>  9500,
        'Plata'  => 10200,
        'Oro'    => 10500, // [NUEVO] +5% Prima
    ];

    public function calculate(Liquidacion $liquidacion): array {
        $factor = self::FACTORES[$liquidacion->mineral->value] ?? self::FACTOR_BASE;
        $totalCentavos = intdiv($liquidacion->getPesoFinoGramos() * $liquidacion->cotizacionCentavos * $factor, 1000 * self::FACTOR_BASE);
        $ajustePct = ($factor / self::FACTOR_BASE) * 100;
        return [
            'totalUsd' => $totalCentavos / 100,
            'ajusteLabel' => match(true) {
                $factor > self::FACTOR_BASE => sprintf('+%.0f%% prima de mercado', $ajustePct - 100),
                $factor < self::FACTOR_BASE => sprintf('−%.0f%% descuento por impurezas', 100 - $ajustePct),
                default => 'Sin ajuste de mercado',
            },
        ];
    }
}
