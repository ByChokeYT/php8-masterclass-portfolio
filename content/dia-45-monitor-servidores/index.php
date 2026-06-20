<?php
declare(strict_types=1);

$dayNumber = 45;
$dayLabel = 'DÍA 45';
$dayTitle = 'Monitor de Servidores (Ping)';
$dayDescription = 'Desarrollo de un panel de monitoreo de servidores y servicios de red utilizando sockets de PHP para validar si un host está en línea.';

$learningObjectives = [
    [
        'title' => 'Conexiones por Sockets',
        'desc' => 'Uso de la función <code>fsockopen()</code> para conectarse a una IP y puerto con timeout.'
    ],
    [
        'title' => 'Cálculo de Latencia',
        'desc' => 'Medir el tiempo exacto transcurrido entre el envío y recepción del paquete de red.'
    ],
    [
        'title' => 'Diseño Resiliente',
        'desc' => 'Manejo de timeouts y supresión de warnings del sistema para evitar caídas del monitor.'
    ]
];

$professorNote = '
    <div class="space-y-4">
        <p>¡Hola! Un monitor de estado (uptime) es fundamental en cualquier arquitectura cloud. En lugar de usar pings ICMP tradicionales (que suelen requerir privilegios de root o sudo en el sistema operativo), usamos pings TCP por sockets en PHP.</p>
        <div class="bg-blue-100/50 p-4 rounded-lg border-l-4 border-blue-400 my-4">
            <strong class="text-blue-900 block mb-1">Dato Técnico Importante:</strong>
            <p>La función <code>fsockopen()</code> es excelente porque permite realizar conexiones TCP ordinarias a puertos específicos (como 80 para HTTP, 3306 para MySQL o 22 para SSH). Siempre define un <strong>timeout corto</strong> (ej. 2 o 3 segundos) para evitar que tu monitor se quede congelado esperando a que responda un servidor caído.</p>
        </div>
    </div>
';

$files = [
    'public/index.php'      => ['path' => 'public/index.php', 'icon' => 'ph-browser'],
    'src/ServerMonitor.php' => ['path' => 'src/ServerMonitor.php', 'icon' => 'ph-activity'],
];

$executionMode = 'web';
$webAppUrl = '/content/dia-45-monitor-servidores/public/index.php';

require_once __DIR__ . '/../../templates/pedagogical_view.php';
