<?php
declare(strict_types=1);

$dayNumber = 4;
$dayLabel = 'DÍA 04';
$dayTitle = 'Simulador de Préstamos';
$dayDescription = 'Simulador de préstamos con algoritmos financieros. Cálculo de tablas de amortización (Sistema Francés) con total separación de responsabilidades.';



$learningObjectives = [
    [
        'title' => 'Algoritmia Financiera',
        'desc' => 'Cálculo de cuotas fijas usando la fórmula matemática del Sistema de Amortización Francés.'
    ],
    [
        'title' => 'Cálculos de Precisión',
        'desc' => 'Manejo del redondeo y operaciones de punto flotante en la generación de cronogramas bancarios.'
    ],
    [
        'title' => 'Estructuras Multidimensionales',
        'desc' => 'Uso de arrays complejos para transportar tanto el resumen ejecutivo como el detalle mes a mes.'
    ],
    [
        'title' => 'Validación de Dominios',
        'desc' => 'Uso de DTOs (Loan) para asegurar que el capital, la tasa y el plazo sean coherentes antes del cálculo.'
    ]
];

$professorNote = '
    <div class="space-y-4">
        <p>A primera vista, calcular un préstamo parece solo aplicar una fórmula. Pero la verdadera complejidad ocurre en la última cuota, donde los redondeos acumulados pueden causar que el saldo final no sea exactamente cero.</p>
        <div class="bg-blue-100/50 p-4 rounded-lg border-l-4 border-blue-400 my-4">
            <strong class="text-blue-900 block mb-1">El "Ajuste de Cierre":</strong>
            <p>Revisa el <code>AmortizationService</code>. Observa cómo ajustamos la última cuota basándonos en el saldo remanente real. Sin este ajuste, tu software financiero nunca cuadraría al centavo.</p>
        </div>
        <p>Esta lógica es 100% independiente de la UI. Podrías usar este mismo Service para generar un PDF o una respuesta JSON para una App móvil. ¡Eso es arquitectura limpia!</p>
    </div>
';

$files = [
    'main.php'                => ['path' => 'main.php', 'icon' => 'ph-terminal-window'],
    'Loan.php'                => ['path' => 'src/Classes/Loan.php', 'icon' => 'ph-bank'],
    'AmortizationService.php' => ['path' => 'src/Services/AmortizationService.php', 'icon' => 'ph-math-operations'],
];



$executionMode = 'cli';

$cliOutput = '
<div class="text-[#56b6c2] font-bold">SIMULADOR FINANCIERO — AMORTIZATION SERVICE</div>
<div class="text-slate-500">==============================================</div>
<div class="mt-2 text-slate-300">Entrada: Capital <span class="text-white">$10,000</span> | Interés <span class="text-white">5.5%</span> | Plazo <span class="text-white">12 Meses</span></div>
<div class="mt-1 text-slate-400">Calculando cuota fija (Sistema Francés)...</div>

<div class="mt-4 text-[#e5c07b] font-bold">CRONOGRAMA DE PAGOS (DUMP):</div>
<div class="text-slate-500">──────────────────────────────────────</div>
<div class="grid grid-cols-5 gap-1 text-[10px] text-slate-500 mb-2">
    <span>MES</span> <span>CUOTA</span> <span>INTERÉS</span> <span>CAPITAL</span> <span>SALDO</span>
</div>
<div class="mt-1 text-slate-300">
    <div class="flex justify-between"><span>01</span> <span class="text-white">$858.37</span> <span>$45.83</span> <span>$812.54</span> <span class="text-emerald-400 font-bold">$9,187.46</span></div>
    <div class="flex justify-between"><span>02</span> <span class="text-white">$858.37</span> <span>$42.11</span> <span>$816.26</span> <span class="text-emerald-400 font-bold">$8,371.20</span></div>
    <div class="flex justify-between"><span>...</span> <span>...</span> <span>...</span> <span>...</span> <span>...</span></div>
    <div class="flex justify-between"><span>12</span> <span class="text-white">$858.37</span> <span>$3.91</span> <span>$854.46</span> <span class="text-emerald-400 font-bold">$0.00</span></div>
</div>

<div class="mt-4 text-[#61afef] font-bold">RESUMEN EJECUTIVO:</div>
<div class="text-slate-500">──────────────────────────────────────</div>
<div class="mt-2 text-slate-400 italic">"Gasto Total en Intereses: <span class="text-[#e06c75]">$300.44</span>"</div>
<div class="mt-1 text-slate-400 italic">"Monto Total Pagado: <span class="text-white">$10,300.44</span>"</div>

<div class="mt-4 p-2 bg-blue-500/10 border border-blue-500/20 rounded text-[10px] text-blue-400">
    TIP: El Service ajusta automáticamente la última cuota para garantizar que el saldo final sea exactamente 0.00.
</div>
';



require_once __DIR__ . '/../../templates/pedagogical_view.php';
