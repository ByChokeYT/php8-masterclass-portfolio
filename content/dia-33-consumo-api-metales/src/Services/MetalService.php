<?php
declare(strict_types=1);

namespace App\Services;

readonly class MetalService {
    /**
     * En una implementación real, aquí usaríamos una API Key de un servicio como metals.dev o metals-api.com
     */
    public function __construct(private string $apiKey = 'DEMO_KEY_123') {}

    public function getLatestPrices(): array {
        /**
         * LÓGICA DE API (SIMULADA PARA LA MASTERCLASS)
         * En producción, usaríamos cURL para consumir el endpoint:
         * https://api.metals.dev/v1/latest?api_key=XYZ
         */
        
        // Simulamos la fluctuación del mercado (+/- 0.5%)
        $volatility = fn($base) => $base * (1 + (rand(-50, 50) / 10000));

        return [
            'status' => 'success',
            'provider' => 'LME (London Metal Exchange) via API Gateway',
            'timestamp' => date('Y-m-d H:i:s'),
            'base' => 'USD',
            'data' => [
                [
                    'name' => 'Oro (24K)',
                    'symbol' => 'XAU',
                    'price' => $volatility(2384.50),
                    'unit' => 'Onza Troy',
                    'trend' => 'up',
                    'change' => '+1.2%'
                ],
                [
                    'name' => 'Plata',
                    'symbol' => 'XAG',
                    'price' => $volatility(28.15),
                    'unit' => 'Onza Troy',
                    'trend' => 'down',
                    'change' => '-0.4%'
                ],
                [
                    'name' => 'Estaño (Oruro High Grade)',
                    'symbol' => 'TIN',
                    'price' => $volatility(32740.00),
                    'unit' => 'Tonelada Métrica',
                    'trend' => 'up',
                    'change' => '+2.8%'
                ],
                [
                    'name' => 'Zinc',
                    'symbol' => 'ZNC',
                    'price' => $volatility(2895.00),
                    'unit' => 'Tonelada Métrica',
                    'trend' => 'up',
                    'change' => '+0.7%'
                ],
                [
                    'name' => 'Cobre',
                    'symbol' => 'CU',
                    'price' => $volatility(9840.00),
                    'unit' => 'Tonelada Métrica',
                    'trend' => 'down',
                    'change' => '-1.1%'
                ]
            ]
        ];
    }

    public function getMetalIcon(string $symbol): string {
        return match($symbol) {
            'XAU' => 'ph-crown',
            'XAG' => 'ph-sparkle',
            'TIN' => 'ph-cube-transparent',
            'ZNC' => 'ph-cylinder',
            'CU' => 'ph-lightning',
            default => 'ph-coins'
        };
    }
}
