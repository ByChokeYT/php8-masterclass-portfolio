<?php
declare(strict_types=1);

namespace App\Services;

use App\Enums\Currency;

/**
 * Servicio encargado de la lógica de conversión de divisas.
 * 
 * Utiliza una estrategia de conversión con el Dólar (USD) como moneda base/pivote.
 * @package App\Services
 */
class ConverterService
{
    /**
     * Tasas de cambio referenciales con respecto a 1 USD.
     * @var array<string, float>
     */
    private const RATES = [
        'USD' => 1.0,
        'EUR' => 0.93,   // 1 USD = 0.93 EUR
        'BOB' => 6.91,   // 1 USD = 6.91 BOB (Oficial aprox)
        'ARS' => 1100.0, // 1 USD = 1100 ARS (Blue aproximado)
        'BRL' => 5.0,    // 1 USD = 5.00 BRL
        'CLP' => 980.0,  // 1 USD = 980 CLP
        'PEN' => 3.75,   // 1 USD = 3.75 PEN
    ];

    public function convert(float $amount, Currency $from, Currency $to): float
    {
        if ($from === $to) {
            return $amount;
        }

        // Convertir de ORIGEN a USD (Base)
        // Si tengo 100 EUR y la tasa es 0.93 (1 USD = 0.93 EUR) -> 100 / 0.93 = 107.5 USD 
        $amountInUsd = $amount / self::RATES[$from->value];

        // Convertir de USD a DESTINO
        // Si tengo 107.5 USD y quiero BOB (6.91) -> 107.5 * 6.91 = 742.8 BOB
        return $amountInUsd * self::RATES[$to->value];
    }
}
