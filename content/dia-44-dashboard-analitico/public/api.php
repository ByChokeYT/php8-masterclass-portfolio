<?php
declare(strict_types=1);

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

// Simulación de base de datos de producción (ventas mensuales de minerales)
$stats = [
    'labels' => ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio'],
    'datasets' => [
        [
            'label' => 'Estaño (t)',
            'data' => [120, 150, 180, 140, 210, 250],
            'backgroundColor' => 'rgba(99, 102, 241, 0.5)',
            'borderColor' => 'rgb(99, 102, 241)',
            'borderWidth' => 2
        ],
        [
            'label' => 'Plata (kg)',
            'data' => [300, 320, 280, 390, 420, 480],
            'backgroundColor' => 'rgba(6, 182, 212, 0.5)',
            'borderColor' => 'rgb(6, 182, 212)',
            'borderWidth' => 2
        ]
    ]
];

echo json_encode($stats);
