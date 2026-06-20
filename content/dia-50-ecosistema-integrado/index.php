<?php
declare(strict_types=1);

$dayNumber = 50;
$dayLabel = 'DÍA 50';
$dayTitle = 'El Ecosistema Integrado (MVC Completo)';
$dayDescription = 'Proyecto final de graduación: Integración de todos los módulos anteriores (Auth, Base de Datos, Control de Roles, Exportación y Logs) en una arquitectura empresarial MVC completa.';

$learningObjectives = [
    [
        'title' => 'Ecosistema de Software',
        'desc' => 'Integrar la autenticación de usuarios, roles, base de datos y logs de auditoría en un único sistema coherente.'
    ],
    [
        'title' => 'Arquitectura Limpia',
        'desc' => 'Mantenimiento del código bajo el principio de responsabilidad única segregado en Controladores, Modelos y Vistas.'
    ],
    [
        'title' => 'Generación de Reportes',
        'desc' => 'Exportar datos del negocio consolidados de manera segura a reportes descargables.'
    ]
];

$professorNote = '
    <div class="space-y-4">
        <p>¡Felicidades, dev! Has completado la ruta de 50 proyectos de PHP. En esta lección final, unificamos todas las piezas del rompecabezas: el enrutador del Día 41, el log de auditoría del Día 49, el control de accesos del Día 43, la base de datos de liquidación del Día 42 y la modularidad del código.</p>
        <div class="bg-blue-100/50 p-4 rounded-lg border-l-4 border-blue-400 my-4">
            <strong class="text-blue-900 block mb-1">Tu Camino como Arquitecto Backend:</strong>
            <p>De programador junior a arquitecto, el secreto es entender cómo los componentes interactúan de forma desacoplada y robusta. Has aprendido a evitar código espagueti, usar tipado estricto, inmutabilidad y seguridad por diseño. ¡A partir de aquí estás más que listo para construir el backend de la próxima gran aplicación web!</p>
        </div>
    </div>
';

$files = [
    'public/index.php'      => ['path' => 'public/index.php', 'icon' => 'ph-browser'],
    'src/Core/App.php'      => ['path' => 'src/Core/App.php', 'icon' => 'ph-tree-structure'],
];

$executionMode = 'web';
$webAppUrl = '/content/dia-50-ecosistema-integrado/public/index.php';

require_once __DIR__ . '/../../templates/pedagogical_view.php';
