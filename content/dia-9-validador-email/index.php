<?php
declare(strict_types=1);

$dayNumber = 9;
$dayLabel = 'DÍA 09';
$dayTitle = 'Validador de Email';
$dayDescription = 'Seguridad y saneamiento de datos. Construcción de un validador de emails que comprueba sintaxis y registros DNS para confirmar dominios reales.';



$learningObjectives = [
    [
        'title' => 'Filtros Nativos de PHP',
        'desc' => 'Uso de <code>FILTER_VALIDATE_EMAIL</code> y <code>FILTER_SANITIZE_EMAIL</code> integrados en el core.'
    ],
    [
        'title' => 'Resolución DNS en Tiempo Real',
        'desc' => 'Comprobación de registros MX (Mail Exchange) mediante <code>checkdnsrr()</code> para confirmar si el dominio existe.'
    ],
    [
        'title' => 'Inyección de Dependencias',
        'desc' => 'Separación de la lógica de validación compleja en un servicio dedicado (<code>EmailValidator</code>).'
    ],
    [
        'title' => 'Prevención de Inyección',
        'desc' => 'Por qué sanitizar antes de validar es vital para evitar ataques de inyección de cabeceras o scripts.'
    ]
];

$professorNote = '
    <div class="space-y-4">
        <p>Validar un email con Regex es un error clásico de principiante. La especificación RFC 5322 es tan compleja que la mayoría de los Regex fallan con correos válidos poco comunes.</p>
        <div class="bg-blue-100/50 p-4 rounded-lg border-l-4 border-blue-400 my-4">
            <strong class="text-blue-900 block mb-1">Dato de Senior:</strong>
            <p>PHP ya resolvió esto internamente con <code>filter_var()</code>. Como profesional, vamos un paso más allá: consultamos los servidores DNS para ver si el dominio realmente tiene buzón de correo.</p>
        </div>
        <p>Este enfoque previene que los usuarios se registren con correos que "parecen reales" pero son imposibles de contactar (ej: hola@noexisto.123).</p>
    </div>
';

$files = [
    'main.php'           => ['path' => 'main.php', 'icon' => 'ph-terminal-window'],
    'EmailValidator.php' => ['path' => 'src/Classes/EmailValidator.php', 'icon' => 'ph-shield-check'],
];


$executionMode = 'cli';

$cliOutput = '
<div class="text-[#56b6c2] font-bold">SECURITY SERVICE — EMAIL VALIDATOR</div>
<div class="text-slate-500">==============================================</div>
<div class="mt-2 text-slate-300">Iniciando EmailValidatorService...</div>

<div class="mt-4 text-[#e5c07b] font-bold">PRUEBA DE VALIDACIÓN:</div>
<div class="text-slate-500">──────────────────────────────────────</div>
<div class="mt-2 text-slate-400">Email: <span class="text-white">"choke@google.com"</span></div>
<div class="mt-1 text-slate-400">
    1. Saneamiento (FILTER_SANITIZE): <span class="text-emerald-400">choke@google.com</span><br>
    2. Sintaxis (FILTER_VALIDATE): <span class="text-emerald-400">VALID</span><br>
    3. Resolución DNS (MX Records): <span class="text-emerald-400">RESOLVED</span>
</div>
<div class="mt-2 text-emerald-400 font-bold">Resultado: [TRUE] El correo es seguro y existe.</div>

<div class="text-slate-500">──────────────────────────────────────</div>
<div class="mt-4 text-[#e06c75] font-bold">PRUEBA DE ATAQUE / ERROR:</div>
<div class="mt-2 text-slate-400">Email: <span class="text-white">"test<script>@evil.com"</span></div>
<div class="mt-1 text-slate-400">
    1. Saneamiento: <span class="text-amber-400">testscript@evil.com</span><br>
    2. Sintaxis: <span class="text-rose-400">INVALID FORMAT</span><br>
</div>
<div class="mt-2 text-rose-400 font-bold">Resultado: [FALSE] Intento de inyección bloqueado.</div>

<div class="mt-4 p-2 bg-blue-500/10 border border-blue-500/20 rounded text-[10px] text-blue-400">
    TIP: checkdnsrr() es una función de bajo nivel que consulta los servidores de nombres. Úsala solo después de validar la sintaxis para ahorrar recursos.
</div>
';

require_once __DIR__ . '/../../templates/pedagogical_view.php';
