<?php
declare(strict_types=1);

$dayNumber = 8;
$dayLabel = 'DÍA 08';
$dayTitle = 'Adivina el Número';
$dayDescription = 'Gestión del estado del juego con Sesiones. Construcción de un ciclo de juego completo y validación de entradas de usuario en PHP.';



$learningObjectives = [
    [
        'title' => 'Gestión de Estado (Stateless HTTP)',
        'desc' => 'Entender cómo <code>$_SESSION</code> permite que una web "recuerde" datos entre peticiones independientes.'
    ],
    [
        'title' => 'Lógica de Game Loop',
        'desc' => 'Implementación de un flujo de juego con estados (Inicio, Jugando, Ganado, Perdido).'
    ],
    [
        'title' => 'Validación de Rangos',
        'desc' => 'Uso de <code>filter_var()</code> con opciones <code>min_range</code> y <code>max_range</code> para blindar la entrada del usuario.'
    ],
    [
        'title' => 'Feedback Visual Inmediato',
        'desc' => 'Uso de lógica condicional para responder al estado del juego en tiempo real.'
    ]
];

$professorNote = '
    <div class="space-y-4">
        <p>La web no tiene memoria (HTTP es <strong>stateless</strong>). Cada vez que das clic en "Adivinar", el servidor empieza desde cero.</p>
        <div class="bg-blue-100/50 p-4 rounded-lg border-l-4 border-blue-400 my-4">
            <strong class="text-blue-900 block mb-1">Sesiones como Memoria RAM:</strong>
            <p>En este proyecto, la sesión actúa como la memoria persistente. Guardamos el número secreto y los intentos. Sin ella, el juego olvidaría el número en el segundo en que la página carga.</p>
        </div>
        <p>Presta atención a cómo reiniciamos el juego: simplemente borramos una variable de sesión o la sobrescribimos. Es la forma más limpia de manejar flujos de usuario temporales.</p>
    </div>
';

$files = [
    'main.php' => ['path' => 'main.php', 'icon' => 'ph-terminal-window'],
];


$executionMode = 'cli';

$cliOutput = '
<div class="text-[#56b6c2] font-bold">GAME ARCHITECTURE — STATEFUL LOOP</div>
<div class="text-slate-500">==============================================</div>
<div class="mt-2 text-slate-300">$_SESSION[\'game\'] init... <span class="text-emerald-400">OK</span></div>
<div class="mt-1 text-slate-400">Generando secreto: <span class="text-white">SECRET_KEY_MD5(...)</span></div>

<div class="mt-4 text-[#e5c07b] font-bold">EVENT LOG (User Iterations):</div>
<div class="text-slate-500">──────────────────────────────────────</div>
<div class="mt-2 text-slate-400">
    [T+0] GET /index.php <span class="text-blue-400">-> RENDER_START</span><br>
    [T+5] POST /guess=50 <span class="text-rose-400">-> TOO_HIGH (Attempts: 4)</span><br>
    [T+8] POST /guess=25 <span class="text-amber-400">-> TOO_LOW (Attempts: 3)</span><br>
    [T+12] POST /guess=42 <span class="text-emerald-400 font-bold">-> WINNER_FOUND!</span>
</div>

<div class="mt-4 text-[#61afef] font-bold">SESSION DUMP:</div>
<div class="text-slate-500">──────────────────────────────────────</div>
<pre class="text-[10px] text-slate-400 bg-black/20 p-2 rounded">
$_SESSION = [
    \'target\' => 42,
    \'history\' => [50, 25, 42],
    \'status\'  => \'completed\'
];
</pre>

<div class="mt-4 p-2 bg-blue-500/10 border border-blue-500/20 rounded text-[10px] text-blue-400">
    TIP: El patrón Post/Redirect/Get evita que al refrescar la página se reenvíe el último número intentado.
</div>
';

require_once __DIR__ . '/../../templates/pedagogical_view.php';
