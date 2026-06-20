<?php
declare(strict_types=1);

$dayNumber = 48;
$dayLabel = 'DÍA 48';
$dayTitle = 'Portafolio de Agencia (CMS)';
$dayDescription = 'Creación de un gestor de contenidos básico para administrar proyectos de un portafolio de agencia, guardando y editando registros dinámicamente.';

$learningObjectives = [
    [
        'title' => 'Gestión de Contenido (CMS)',
        'desc' => 'Comprender cómo estructurar una base de datos para la creación, lectura y edición de artículos o portafolios.'
    ],
    [
        'title' => 'Formularios de Edición',
        'desc' => 'Diseño de flujos para precargar datos existentes en un formulario y procesar actualizaciones.'
    ],
    [
        'title' => 'Sanitización del Frontend',
        'desc' => 'Uso de <code>htmlspecialchars</code> para evitar inyección de HTML/CSS de terceros.'
    ]
];

$professorNote = '
    <div class="space-y-4">
        <p>¡Hola! Los portafolios autoadministrables o blogs son el punto de partida de los grandes gestores de contenido (CMS como WordPress). Aquí es donde se conectan todas las operaciones CRUD (Create, Read, Update, Delete).</p>
        <div class="bg-blue-100/50 p-4 rounded-lg border-l-4 border-blue-400 my-4">
            <strong class="text-blue-900 block mb-1">Dato de Sanitización:</strong>
            <p>Al permitir a los administradores escribir texto libre (como títulos y descripciones), siempre corres el riesgo de ataques XSS (Cross-Site Scripting). Nunca renderices en el navegador lo que viene de la base de datos sin antes filtrarlo con <code>htmlspecialchars()</code>.</p>
        </div>
    </div>
';

$files = [
    'public/index.php'      => ['path' => 'public/index.php', 'icon' => 'ph-browser'],
    'src/ProjectManager.php'=> ['path' => 'src/ProjectManager.php', 'icon' => 'ph-folder'],
];

$executionMode = 'web';
$webAppUrl = '/content/dia-48-portafolio-agencia/public/index.php';

require_once __DIR__ . '/../../templates/pedagogical_view.php';
