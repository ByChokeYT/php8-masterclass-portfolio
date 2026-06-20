<?php
declare(strict_types=1);

$dayNumber = 44;
$dayLabel = 'DÍA 44';
$dayTitle = 'Dashboard Analítico (Chart.js)';
$dayDescription = 'Construcción de un panel analítico interactivo que consulta y agrupa estadísticas del backend en formato JSON para graficarlas con Chart.js en el frontend.';

$learningObjectives = [
    [
        'title' => 'Endpoints de Datos (APIs)',
        'desc' => 'Separar la lógica del renderizado de datos, sirviendo un endpoint estructurado en JSON.'
    ],
    [
        'title' => 'Integración de Gráficos',
        'desc' => 'Uso de la librería Chart.js para renderizar gráficos de barras y líneas con datos dinámicos.'
    ],
    [
        'title' => 'Consumo de Datos en JS',
        'desc' => 'Consumir datos desde PHP mediante Fetch API en Vanilla Javascript de manera asíncrona.'
    ]
];

$professorNote = '
    <div class="space-y-4">
        <p>¡Hola! Los dashboards ejecutivos son de gran valor para cualquier cliente corporativo. La mejor práctica de arquitectura hoy en día es evitar inyectar datos directamente en variables globales de JS usando etiquetas de PHP.</p>
        <div class="bg-blue-100/50 p-4 rounded-lg border-l-4 border-blue-400 my-4">
            <strong class="text-blue-900 block mb-1">Dato de Arquitectura de APIs:</strong>
            <p>Es mucho más limpio y mantenible servir los datos en un endpoint JSON separado (por ejemplo, <code>api.php</code>). Esto permite que tus gráficos se carguen de manera asíncrona mediante Fetch API y te prepara para escalar la aplicación en el futuro.</p>
        </div>
    </div>
';

$files = [
    'public/index.php' => ['path' => 'public/index.php', 'icon' => 'ph-browser'],
    'public/api.php'   => ['path' => 'public/api.php', 'icon' => 'ph-brackets-curly'],
];

$executionMode = 'web';
$webAppUrl = '/content/dia-44-dashboard-analitico/public/index.php';

require_once __DIR__ . '/../../templates/pedagogical_view.php';
