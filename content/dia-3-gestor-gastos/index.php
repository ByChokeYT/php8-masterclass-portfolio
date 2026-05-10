<?php
declare(strict_types=1);

$dayNumber = 3;
$dayLabel = 'DÍA 03';
$dayTitle = 'Gestor de Gastos';
$dayDescription = 'Gestión de gastos mediante Programación Orientada a Objetos. Uso de servicios y encapsulamiento para el control financiero en consola.';




$learningObjectives = [
    [
        'title' => 'Gestión de Estado (Sesiones)',
        'desc' => 'Uso de <code>$_SESSION</code> para persistir objetos complejos (Transactions) entre recargas de página sin base de datos.'
    ],
    [
        'title' => 'Arquitectura de Servicios',
        'desc' => 'Delegación de la lógica de negocio a un <code>BudgetManager</code>, aplicando el principio de alta cohesión.'
    ],
    [
        'title' => 'Patrón PRG (Post/Redirect/Get)',
        'desc' => 'Implementación de redirecciones HTTP para evitar el reenvío accidental de formularios al refrescar.'
    ],
    [
        'title' => 'Inyección de Dependencias',
        'desc' => 'Instanciación de objetos de dominio y su paso a través de la capa de servicios para desacoplamiento.'
    ]
];

$professorNote = '
    <div class="space-y-4">
        <p>Las variables globales como <code>$_SESSION</code> son potentes pero peligrosas. Si las manipulamos directamente desde el HTML, el código se vuelve "espagueti".</p>
        <div class="bg-amber-100/50 p-4 rounded-lg border-l-4 border-amber-400 my-4">
            <strong class="text-amber-900 block mb-1">Principio de Encapsulamiento:</strong>
            <p>La vista (HTML) nunca debe saber que existe una sesión. Ella solo le dice al <code>BudgetManager</code>: "añade este gasto". El Manager decide dónde y cómo guardarlo.</p>
        </div>
        <p>Fíjate también en el uso de <code>filter_input</code>. Nunca confíes en lo que viene de <code>$_POST</code>. Validar y tipar los datos en el momento que entran al sistema es la primera línea de defensa de un Arquitecto Backend.</p>
    </div>
';

$files = [
    'main.php'           => ['path' => 'main.php', 'icon' => 'ph-terminal-window'],
    'Transaction.php'    => ['path' => 'src/Classes/Transaction.php', 'icon' => 'ph-cube'],
    'BudgetManager.php'  => ['path' => 'src/Services/BudgetManager.php', 'icon' => 'ph-gear-six'],
];



$executionMode = 'cli';

$cliOutput = '
<div class="text-[#56b6c2] font-bold">GESTOR DE GASTOS v1.0 — POO SERVICE</div>
<div class="text-slate-500">==============================================</div>
<div class="mt-2 text-slate-300">Iniciando BudgetManager con persistencia en $_SESSION...</div>
<div class="mt-1 text-slate-300">Cargando 2 transacciones previas... <span class="text-emerald-400">OK</span></div>

<div class="mt-4 text-[#e5c07b] font-bold">ACCIONES DEL DÍA:</div>
<div class="text-slate-500">──────────────────────────────────────</div>
<div class="mt-2"><span class="text-[#98c379]">1. [ADD]</span> <span class="text-white">"Pago Freelance"</span> <span class="text-emerald-400">+$800.00</span> (Ingreso)</div>
<div class="mt-1"><span class="text-[#98c379]">2. [ADD]</span> <span class="text-white">"Internet Fibra"</span> <span class="text-rose-400">-$45.00</span> (Gasto)</div>
<div class="mt-1"><span class="text-[#98c379]">3. [DEL]</span> <span class="text-white">ID: 5f2a1 (Gasto antiguo eliminado)</span></div>

<div class="mt-4 text-[#61afef] font-bold">ESTADO FINANCIERO CONSOLIDADO:</div>
<div class="text-slate-500">──────────────────────────────────────</div>
<div class="mt-2 text-slate-400">Total Ingresos : <span class="text-emerald-400 font-bold">$2,300.00</span></div>
<div class="mt-1 text-slate-400">Total Gastos   : <span class="text-rose-400 font-bold">-$545.00</span></div>
<div class="mt-2 bg-white/5 p-2 border border-white/10 rounded">
    <span class="text-white font-bold tracking-widest uppercase">Balance Neto: <span class="text-[#56b6c2]">$1,755.00</span></span>
</div>

<div class="mt-4 text-slate-500 italic text-[10px]">
    "Nota: Aunque este proyecto tiene una interfaz web opcional, el corazón pedagógico es la manipulación de la lógica de servicios y la gestión de estados en PHP puro."
</div>
';



require_once __DIR__ . '/../../templates/pedagogical_view.php';
