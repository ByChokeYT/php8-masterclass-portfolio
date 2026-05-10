<?php
declare(strict_types=1);

$dayNumber = 7;
$dayLabel = 'DÍA 07';
$dayTitle = 'Analizador de Texto';
$dayDescription = 'Manipulación de strings y SEO en PHP. Creación de una herramienta que analiza palabras, caracteres y densidad de keywords usando mbstring.';



$learningObjectives = [
    [
        'title' => 'Soporte Multibyte (mbstring)',
        'desc' => 'Uso obligatorio de <code>mb_*</code> para procesar correctamente textos con tildes, eñes y emojis en español.'
    ],
    [
        'title' => 'Análisis de Frecuencia',
        'desc' => 'Uso de <code>array_count_values()</code> y <code>arsort()</code> para identificar densidad de palabras clave (SEO).'
    ],
    [
        'title' => 'Expresiones Regulares',
        'desc' => 'Limpieza y normalización de texto mediante <code>preg_replace()</code> para eliminar puntuación y caracteres especiales.'
    ],
    [
        'title' => 'Optimización de Memoria',
        'desc' => 'Por qué preferir funciones nativas de PHP escritas en C frente a bucles manuales de procesamiento de texto.'
    ]
];

$professorNote = '
    <div class="space-y-4">
        <p>Procesar texto es una de las tareas más costosas a nivel de memoria. Fíjate cómo usamos <code>array_count_values</code>, que está altamente optimizada en C dentro del core de PHP.</p>
        <div class="bg-purple-100/50 p-4 rounded-lg border-l-4 border-purple-400 my-4">
            <strong class="text-purple-900 block mb-1">Peligro con Strings:</strong>
            <p>Al trabajar en español, nunca olvides las funciones multibyte. Si usas <code>strlen("año")</code> te devolverá 4 bytes, no 3 caracteres. Esto rompe cualquier lógica de truncado o conteo real.</p>
        </div>
        <p>En este analizador, implementamos una capa de limpieza previa que convierte todo a minúsculas y elimina ruido, asegurando que "PHP" y "php" se cuenten como la misma entidad.</p>
    </div>
';

$files = [
    'main.php'         => ['path' => 'main.php', 'icon' => 'ph-terminal-window'],
    'TextAnalyzer.php' => ['path' => 'src/Classes/TextAnalyzer.php', 'icon' => 'ph-text-aa'],
];


$executionMode = 'cli';

$cliOutput = '
<div class="text-[#56b6c2] font-bold">TEXT ENGINE — MB_STRING ANALYZER</div>
<div class="text-slate-500">==============================================</div>
<div class="mt-2 text-slate-300">Cargando texto de entrada (UTF-8)...</div>
<div class="mt-1 text-slate-500 italic">"PHP es la tecnología del mañana. Programar en PHP es increíble."</div>

<div class="mt-4 text-[#e5c07b] font-bold">MÉTRICAS BASE (mbstring):</div>
<div class="text-slate-500">──────────────────────────────────────</div>
<div class="grid grid-cols-2 gap-4">
    <div class="text-slate-400">Caracteres: <span class="text-white">65</span></div>
    <div class="text-slate-400">Palabras  : <span class="text-white">10</span></div>
    <div class="text-slate-400">Párrafos  : <span class="text-white">1</span></div>
    <div class="text-slate-400">Lectura   : <span class="text-[#98c379]">1 seg</span></div>
</div>

<div class="mt-4 text-[#61afef] font-bold">DENSIDAD DE KEYWORDS (SEO DUMP):</div>
<div class="text-slate-500">──────────────────────────────────────</div>
<div class="mt-2 space-y-1">
    <div class="flex justify-between items-center bg-white/5 p-1 rounded px-3">
        <span class="text-white font-mono">php</span>
        <span class="text-[#e06c75] font-bold">20.0% (2)</span>
    </div>
    <div class="flex justify-between items-center p-1 px-3">
        <span class="text-slate-300 font-mono text-xs">tecnología</span>
        <span class="text-slate-500">10.0% (1)</span>
    </div>
    <div class="flex justify-between items-center p-1 px-3">
        <span class="text-slate-300 font-mono text-xs">increíble</span>
        <span class="text-slate-500">10.0% (1)</span>
    </div>
</div>

<div class="mt-4 p-2 bg-purple-500/10 border border-purple-500/20 rounded text-[10px] text-purple-400">
    TIP: Usamos mb_strtolower() para normalizar el texto antes del conteo, evitando que "PHP" y "php" se cuenten por separado.
</div>
';

require_once __DIR__ . '/../../templates/pedagogical_view.php';
