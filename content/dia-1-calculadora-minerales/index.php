<?php
declare(strict_types=1);

$dayNumber = 1;
$dayLabel = 'DÍA 01';
$dayTitle = 'Calculadora de Minerales (CLI)';
$dayDescription = 'Primeros pasos con PHP 8.5. Aprendizaje de tipado estricto, uso de Enums y creación de DTOs inmutables para una calculadora de minerales robusta.';



$learningObjectives = [
    [
        'title' => 'Tipado Estricto',
        'desc' => 'Uso obligatorio de <code>declare(strict_types=1);</code> para evitar coerción de tipos accidental.'
    ],
    [
        'title' => 'Enumeraciones (Enums)',
        'desc' => 'Reemplazar "strings mágicos" por <code>Enum MineralType</code> para opciones de cálculo seguras.'
    ],
    [
        'title' => 'Readonly DTOs',
        'desc' => 'Crear clases <code>readonly</code> para transportar datos (Liquidación) de forma segura e inmutable.'
    ],
    [
        'title' => 'Expresión Match',
        'desc' => 'Sustituir la sentencia <code>switch</code> por <code>match</code> para retornos directos y exhaustivos.'
    ]
];

$professorNote = '
    <div class="space-y-4">
        <p>¡Hola, dev! Como ingeniero Senior, rara vez uso arrays asociativos (<code>[\'peso\' => 10]</code>) para mover información entre capas.</p>
        <div class="bg-blue-100/50 p-4 rounded-lg border-l-4 border-blue-400 my-4">
            <strong class="text-blue-900 block mb-1">Dato de Arquitectura:</strong>
            <p>En su lugar, usamos <strong>DTOs (Data Transfer Objects)</strong> inmutables. Esto permite que el IDE nos autocomplete y el motor de PHP detecte errores de tipos antes de que el código llegue a producción.</p>
        </div>
        <p>Fíjate cómo el uso de <code>match</code> en <code>CalculatorService</code> hace que el código sea exhaustivo: si añades un nuevo mineral al Enum y olvidas calcularlo, PHP lanzará un error. ¡Seguridad total!</p>
    </div>
';


$files = [
    'main.php'          => ['path' => 'main.php', 'icon' => 'ph-terminal-window'],
    'MineralType.php'   => ['path' => 'src/Enums/MineralType.php', 'icon' => 'ph-list-bullets'],
    'Liquidacion.php'   => ['path' => 'src/DTO/Liquidacion.php', 'icon' => 'ph-database'],
    'CalculatorService.php' => ['path' => 'src/Services/CalculatorService.php', 'icon' => 'ph-gear-six'],
];


$executionMode = 'cli';

$cliOutput = '
<div class="text-[#56b6c2] font-bold">CALCULADORA DE MINERALES v2.0</div>
<div class="text-slate-500">==============================================</div>
<div class="mt-3">
    <span class="text-[#98c379]">Selecciona el mineral (1-3):</span> <span class="text-white">3</span>
</div>
<div class="mt-1">
    <span class="text-[#98c379]">Peso bruto en kg:</span> <span class="text-white">10</span>
</div>
<div class="mt-1">
    <span class="text-[#98c379]">Cotización actual en USD/kg:</span> <span class="text-white">500</span>
</div>
<div class="mt-1">
    <span class="text-[#98c379]">Pureza del mineral (0-100)%:</span> <span class="text-white">92</span>
</div>
<br>
<div class="text-[#e5c07b]">==============================================</div>
<div class="text-[#e5c07b] font-bold">   LIQUIDACIÓN FINAL</div>
<div class="text-[#e5c07b]">==============================================</div>
<div class="mt-3">Tipo        : <span class="text-[#61afef] font-bold">🪙 Plata (Ag)</span></div>
<div class="mt-1">Peso bruto  : <span class="text-[#d19a66]">10.000 kg</span></div>
<div class="mt-1">Peso fino   : <span class="text-[#d19a66]">9.2000 kg</span></div>
<div class="mt-1">Calidad     : <span class="text-[#c678dd] font-bold">ALTA CALIDAD</span></div>
<br>
<div class="text-[#98c379] font-bold text-sm bg-[#98c379]/10 inline-block px-3 py-1 rounded">
    TOTAL A LIQUIDAR: $4,692.00 USD
</div>
';

require_once __DIR__ . '/../../templates/pedagogical_view.php';
