<?php
declare(strict_types=1);

$dayNumber = 46;
$dayLabel = 'DÍA 46';
$dayTitle = 'Gestor de Plantillas (Template Engine)';
$dayDescription = 'Creación de un motor de plantillas básico desde cero para separar la lógica de negocio de la capa de presentación HTML.';

$learningObjectives = [
    [
        'title' => 'Separación de Conceptos',
        'desc' => 'Evitar mezclar sentencias complejas de PHP en medio de los archivos de marcado HTML.'
    ],
    [
        'title' => 'Reemplazo con Expresiones Regulares',
        'desc' => 'Uso de <code>preg_replace</code> y expresiones regulares para parsear sintaxis personalizada.'
    ],
    [
        'title' => 'Caché de Plantillas',
        'desc' => 'Comprender cómo se compila y almacena una plantilla parseada para mejorar el rendimiento.'
    ]
];

$professorNote = '
    <div class="space-y-4">
        <p>¡Hola! Los motores de plantillas modernos (como Blade en Laravel o Twig en Symfony) son herramientas muy útiles para mantener ordenado el código frontend. En lugar de escribir <code>&lt;?php echo $title; ?&gt;</code>, nos permiten escribir una sintaxis más corta y limpia como <code>{{ title }}</code>.</p>
        <div class="bg-blue-100/50 p-4 rounded-lg border-l-4 border-blue-400 my-4">
            <strong class="text-blue-900 block mb-1">Dato de Rendimiento:</strong>
            <p>Un motor de plantilla real no parsea el archivo en cada petición; en su lugar, traduce la plantilla a código PHP nativo una sola vez, la guarda en un directorio de "cache" y sirve ese archivo compilado en las siguientes peticiones. ¡Esto hace que sea igual de rápido que el PHP puro!</p>
        </div>
    </div>
';

$files = [
    'public/index.php'      => ['path' => 'public/index.php', 'icon' => 'ph-browser'],
    'src/TemplateEngine.php'=> ['path' => 'src/TemplateEngine.php', 'icon' => 'ph-file-code'],
    'templates/profile.html'=> ['path' => 'templates/profile.html', 'icon' => 'ph-layout'],
];

$executionMode = 'web';
$webAppUrl = '/content/dia-46-template-engine/public/index.php';

require_once __DIR__ . '/../../templates/pedagogical_view.php';
