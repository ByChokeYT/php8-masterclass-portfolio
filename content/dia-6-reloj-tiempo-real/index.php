<?php
declare(strict_types=1);

$dayNumber = 6;
$dayLabel = 'DÍA 06';
$dayTitle = 'Reloj en Tiempo Real';
$dayDescription = 'Manipulación del objeto DateTime de PHP. Sincronización de zonas horarias y construcción de un sistema de tiempo robusto para aplicaciones distribuidas.';



$learningObjectives = [
    [
        'title' => 'Ecosistema DateTime',
        'desc' => 'Instanciación y formateo de fechas de manera Orientada a Objetos usando <code>DateTime</code> y <code>DateTimeZone</code>.'
    ],
    [
        'title' => 'Sincronización Server-Client',
        'desc' => 'Conceptos de "Verdad de Servidor" para evitar desajustes en aplicaciones que dependen del tiempo.'
    ],
    [
        'title' => 'Inmutabilidad de Fechas',
        'desc' => 'Breve introducción a <code>DateTimeImmutable</code> para evitar efectos secundarios en la manipulación de fechas.'
    ],
    [
        'title' => 'Zonas Horarias Olson',
        'desc' => 'Uso de la base de datos de zonas horarias de PHP para manejar cambios de horario de verano automáticamente.'
    ]
];

$professorNote = '
    <div class="space-y-4">
        <p>Nunca uses funciones antiguas como <code>date()</code> o <code>time()</code> en aplicaciones modernas. Siempre usa el objeto <code>DateTime</code> o, preferiblemente, <code>DateTimeImmutable</code>.</p>
        <div class="bg-indigo-100/50 p-4 rounded-lg border-l-4 border-indigo-400 my-4">
            <strong class="text-indigo-900 block mb-1">Dato de Arquitectura:</strong>
            <p>Manejar zonas horarias es un desafío técnico real. PHP usa la base de datos Olson internamente, lo que nos permite despreocuparnos de si en Japón o Bolivia cambió la ley horaria ayer.</p>
        </div>
        <p>En este proyecto, nos enfocamos en cómo PHP maneja el tiempo como un objeto, permitiendo sumas, restas y comparaciones lógicas de forma natural.</p>
    </div>
';

$files = [
    'main.php' => ['path' => 'main.php', 'icon' => 'ph-terminal-window'],
];


$executionMode = 'cli';

$cliOutput = '
<div class="text-[#56b6c2] font-bold">TIME ARCHITECTURE — DATETIME API DUMP</div>
<div class="text-slate-500">==============================================</div>
<div class="mt-2 text-slate-300">Consultando objeto <span class="text-white">DateTime</span> del sistema...</div>

<div class="mt-4 text-[#e5c07b] font-bold">PROPIEDADES DEL OBJETO (UTC vs LOCAL):</div>
<div class="text-slate-500">──────────────────────────────────────</div>
<div class="mt-2 flex justify-between text-slate-400">
    <span>Timestamp PHP:</span> <span class="text-white">'.time().'</span>
</div>
<div class="mt-1 flex justify-between text-slate-400">
    <span>UTC Time:</span> <span class="text-[#61afef]">'.gmdate('Y-m-d H:i:s').'</span>
</div>
<div class="mt-1 flex justify-between text-slate-400">
    <span>Local Time:</span> <span class="text-emerald-400">'.date('Y-m-d H:i:s').'</span>
</div>
<div class="mt-1 flex justify-between text-slate-400">
    <span>Timezone:</span> <span class="text-[#c678dd]">America/La_Paz (GMT-4)</span>
</div>

<div class="mt-4 text-[#61afef] font-bold">INTERVALOS Y DIFERENCIAS:</div>
<div class="text-slate-500">──────────────────────────────────────</div>
<div class="mt-2 text-slate-400 italic">
    "Diferencia con fin de año: <span class="text-white">234 días, 12 horas</span>"<br>
    "Formato RFC 2822: <span class="text-white">'.date('r').'</span>"
</div>

<div class="mt-4 p-2 bg-indigo-500/10 border border-indigo-500/20 rounded text-[10px] text-indigo-400">
    TIP: Usar DateTimeZone(\'America/La_Paz\') garantiza que los cálculos de hora sean precisos sin importar la configuración del servidor.
</div>
';

require_once __DIR__ . '/../../templates/pedagogical_view.php';
