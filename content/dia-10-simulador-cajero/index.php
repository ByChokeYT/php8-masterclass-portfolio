<?php
declare(strict_types=1);

$dayNumber = 10;
$dayLabel = 'DÍA 10';
$dayTitle = 'Simulador de Cajero ATM';
$dayDescription = 'Proyecto final del Módulo 1. Integración de todos los conceptos (POO, Sesiones, Excepciones, DTOs) en un simulador de banco robusto y seguro.';



$learningObjectives = [
    [
        'title' => 'Integración de Conceptos',
        'desc' => 'Uso simultáneo de Clases, Sesiones y Manejo de Errores para construir una aplicación de estado complejo.'
    ],
    [
        'title' => 'Lógica Transaccional',
        'desc' => 'Garantizar que las operaciones (retiro/depósito) no dejen el saldo en estados inconsistentes.'
    ],
    [
        'title' => 'Arquitectura de Defensa',
        'desc' => 'Uso de excepciones personalizadas para proteger las reglas de negocio de entradas maliciosas.'
    ],
    [
        'title' => 'Modularización Final',
        'desc' => 'Consolidación de todo lo aprendido en una estructura de carpetas profesional y escalable.'
    ]
];

$professorNote = '
    <div class="space-y-4">
        <p>¡Felicidades por llegar al Día 10! Este cajero automático (ATM) es la prueba de fuego de todo lo aprendido en el Módulo 1.</p>
        <div class="bg-amber-100/50 p-4 rounded-lg border-l-4 border-amber-400 my-4">
            <strong class="text-amber-900 block mb-1">Cierre de Módulo:</strong>
            <p>La clase <code>CajeroAutomatico</code> es el cerebro. Observa cómo protege la integridad de los datos lanzando excepciones si intentas retirar más de lo que tienes. La lógica de negocio está totalmente aislada de la entrada de datos.</p>
        </div>
        <p>Hemos pasado de scripts de 10 líneas en el Día 1 a un sistema con capas, servicios y manejo de estados. Estás listo para el Módulo 2: <strong>Bases de Datos y Persistencia Real</strong>.</p>
    </div>
';

$files = [
    'main.php'             => ['path' => 'main.php', 'icon' => 'ph-terminal-window'],
    'CajeroAutomatico.php' => ['path' => 'src/Classes/CajeroAutomatico.php', 'icon' => 'ph-bank'],
];


$executionMode = 'cli';

$cliOutput = '
<div class="text-[#56b6c2] font-bold">ATM CORE — TRANSACTIONAL LOG</div>
<div class="text-slate-500">==============================================</div>
<div class="mt-2 text-slate-300">Autenticando usuario... <span class="text-emerald-400">OK</span></div>
<div class="mt-1 text-slate-400">Instanciando CajeroAutomatico(balance: $1000)</div>

<div class="mt-4 text-[#e5c07b] font-bold">HISTORIAL DE MOVIMIENTOS:</div>
<div class="text-slate-500">──────────────────────────────────────</div>
<div class="mt-2 text-slate-400">
    [DEPOSIT]  $500.00 <span class="text-emerald-400">-> SUCCESS</span> (Balance: $1500)<br>
    [WITHDRAW] $200.00 <span class="text-emerald-400">-> SUCCESS</span> (Balance: $1300)<br>
    [WITHDRAW] $5000.00 <span class="text-rose-400">-> FAILED</span> (Insuficiente)<br>
</div>

<div class="mt-4 text-[#61afef] font-bold">DEBUG INFO (Exception Catching):</div>
<div class="text-slate-500">──────────────────────────────────────</div>
<div class="mt-2 text-slate-500">
    <span class="text-rose-400 font-bold">Caught:</span> App\Exceptions\BalanceInsuficienteException<br>
    <span class="text-slate-400">Message:</span> No puedes retirar $5000.00. Saldo actual: $1300.00<br>
    <span class="text-slate-600 font-mono text-[10px]">Stack trace: CajeroAutomatico.php:L45 -> index.php:L82</span>
</div>

<div class="mt-4 p-2 bg-amber-500/10 border border-amber-500/20 rounded text-[10px] text-amber-400">
    TIP: Este es el cierre del Módulo 1. Aquí demostramos cómo la lógica de negocio sólida protege la aplicación de errores de usuario antes de que lleguen a la capa de persistencia.
</div>
';

require_once __DIR__ . '/../../templates/pedagogical_view.php';
