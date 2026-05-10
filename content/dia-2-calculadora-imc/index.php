<?php
declare(strict_types=1);

$dayNumber = 2;
$dayLabel = 'DÍA 02';
$dayTitle = 'Calculadora de IMC (CLI)';
$dayDescription = 'Arquitectura de Software aplicada a la terminal. Interfaces, Enums, DTOs y Servicios de Alto Rendimiento. Aprende a separar responsabilidades correctamente.';



$learningObjectives = [
    [
        'title' => 'Contratos (Interfaces)',
        'desc' => 'Definimos el "qué" antes del "cómo". Garantiza escalabilidad total para múltiples calculadoras.'
    ],
    [
        'title' => 'Aritmética Entera x100',
        'desc' => 'Operamos en gramos y milímetros para evitar la imprecisión del punto flotante (float) en PHP.'
    ],
    [
        'title' => 'Responsabilidad Única',
        'desc' => 'Separación clara entre captura de datos (Main), contratos (Interface) y lógica (Service).'
    ],
    [
        'title' => 'Enums con Lógica',
        'desc' => 'Uso de métodos dentro de Enums para centralizar conversiones de unidades y etiquetas.'
    ],
    [
        'title' => 'Visualización CLI',
        'desc' => 'Construcción de una barra de progreso visual dinámica utilizando caracteres ANSI en terminal.'
    ]
];

$professorNote = '
    <div class="space-y-4">
        <p>¡Bienvenido al Día 02! Aquí es donde la arquitectura empieza a ponerse seria. En el Día 01 usamos DTOs y Enums, pero hoy introducimos las <strong>Interfaces</strong>.</p>
        <div class="bg-blue-100/50 p-4 rounded-lg border-l-4 border-blue-400 my-4">
            <strong class="text-blue-900 block mb-1">Dato de Ingeniero Senior:</strong>
            <p>La precisión lo es todo. Trabajar con decimales en lenguajes de programación siempre conlleva riesgos de redondeo debido al estándar IEEE 754.</p>
        </div>
        <p>Fíjate cómo en <code>MedicionCorporal.php</code> convertimos los kilos a gramos y los metros a milímetros. Ese es un estándar real en <strong>Fintech y HealthTech</strong> para evitar que un redondeo de 0.0001 haga fallar una transacción o un diagnóstico médico.</p>
        <p><strong>Lo nuevo vs Día 01:</strong></p>
        <ul class="list-disc ml-5 space-y-1">
            <li><strong>Interfaces:</strong> Contratos que obligan a las clases a ser consistentes.</li>
            <li><strong>Lazy Calculation:</strong> El IMC se calcula solo la primera vez y se cachea.</li>
            <li><strong>ANSI Graphics:</strong> Llevamos la terminal al límite visual.</li>
        </ul>
    </div>
';

$files = [
    'main.php'                   => ['path' => 'main.php', 'icon' => 'ph-terminal-window'],
    'CalculadoraInterface.php'   => ['path' => 'src/Contracts/CalculadoraInterface.php', 'icon' => 'ph-file-code'],
    'ImcCalculatorService.php'   => ['path' => 'src/Services/ImcCalculatorService.php', 'icon' => 'ph-gear-six'],
    'MedicionCorporal.php'       => ['path' => 'src/DTO/MedicionCorporal.php', 'icon' => 'ph-database'],
    'SistemaUnidad.php'          => ['path' => 'src/Enums/SistemaUnidad.php', 'icon' => 'ph-ruler'],
    'ClasificacionImc.php'       => ['path' => 'src/Enums/ClasificacionImc.php', 'icon' => 'ph-activity'],
];


$executionMode = 'cli';

$cliOutput = '
<div class="text-[#56b6c2] font-bold">CALCULADORA DE IMC v1.0 — CLI ELITE</div>
<div class="text-slate-500">==============================================</div>
<div class="mt-2"><span class="text-[#98c379]">¿Cuál es tu nombre?</span> <span class="text-white">Ana</span></div>
<div class="mt-1"><span class="text-[#98c379]">Selecciona el sistema (1-2):</span> <span class="text-white">1 (Métrico)</span></div>
<div class="mt-1"><span class="text-[#98c379]">Peso (kg):</span> <span class="text-white">65</span></div>
<div class="mt-1"><span class="text-[#98c379]">Altura (m):</span> <span class="text-white">1.68</span></div>

<div class="mt-4 text-[#e5c07b] font-bold">   RESULTADOS PARA: ANA</div>
<div class="text-slate-500">──────────────────────────────────────</div>
<div class="mt-2 text-slate-400">Peso Ideal (OMS): <span class="text-[#98c379]">52.2kg — 70.3kg</span></div>
<div class="mt-1 text-slate-400">Estado Actual   : <span class="text-white">✓ Estás en rango saludable</span></div>

<div class="mt-4">IMC: <span class="text-white font-bold">23.03</span> | <span class="text-[#98c379] font-bold uppercase tracking-widest">Normal</span></div>
<div class="mt-2 text-[#98c379]/50">  ──────────▲─────────────────────────────</div>
<div class="text-slate-600 font-bold text-[10px]">  BP        N          SP       O-I   O-II</div>

<div class="mt-4 p-3 bg-[#98c379]/10 border border-[#98c379]/20 rounded text-[#98c379] italic">
    "Mantén tus hábitos. ¡Vas por buen camino!"
</div>
';


require_once __DIR__ . '/../../templates/pedagogical_view.php';
