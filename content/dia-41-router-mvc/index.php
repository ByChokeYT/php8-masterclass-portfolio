<?php
declare(strict_types=1);

$dayNumber = 41;
$dayLabel = 'DÍA 41';
$dayTitle = 'Enrutador MVC Básico';
$dayDescription = 'Creación de un router limpio desde cero para gestionar peticiones y redirigirlas a controladores específicos en una arquitectura MVC.';

$learningObjectives = [
    [
        'title' => 'Enrutamiento Limpio',
        'desc' => 'Deshacerse de las extensiones <code>.php</code> en la URL implementando un Front Controller.'
    ],
    [
        'title' => 'Mapeo de Rutas',
        'desc' => 'Uso de expresiones regulares o coincidencias directas para asociar URLs a controladores.'
    ],
    [
        'title' => 'Captura de Parámetros',
        'desc' => 'Extracción dinámica de IDs u otros parámetros contenidos en el path de la URL.'
    ]
];

$professorNote = '
    <div class="space-y-4">
        <p>¡Hola! El enrutador es el corazón de cualquier framework moderno (como Laravel o Symfony). En lugar de tener decenas de archivos index.php expuestos en la web, todas las peticiones se centralizan en un Front Controller.</p>
        <div class="bg-blue-100/50 p-4 rounded-lg border-l-4 border-blue-400 my-4">
            <strong class="text-blue-900 block mb-1">Concepto Clave:</strong>
            <p>El Front Controller intercepta la petición, lee el <code>REQUEST_URI</code>, busca coincidencias en una lista predefinida de rutas y despacha la lógica a la clase controladora correcta. Esto mejora notablemente la seguridad y la modularidad del código.</p>
        </div>
    </div>
';

$files = [
    'public/index.php' => ['path' => 'public/index.php', 'icon' => 'ph-browser'],
    'src/Router.php'    => ['path' => 'src/Router.php', 'icon' => 'ph-tree-structure'],
];

$executionMode = 'web';
$webAppUrl = '/content/dia-41-router-mvc/public/index.php';

require_once __DIR__ . '/../../templates/pedagogical_view.php';
