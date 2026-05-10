<?php
declare(strict_types=1);

$dayNumber = 5;
$dayLabel = 'DÍA 05';
$dayTitle = 'Calculadora IMC Pro';
$dayDescription = 'Calculadora de salud con manejo de errores avanzado. Implementación de bloques try-catch y excepciones personalizadas para un flujo de datos seguro.';



$learningObjectives = [
    [
        'title' => 'Manejo de Excepciones',
        'desc' => 'Uso de bloques <code>try-catch</code> y lanzamiento de <code>\InvalidArgumentException</code> para una validación robusta.'
    ],
    [
        'title' => 'Sanitización de Datos',
        'desc' => 'Uso de <code>filter_input()</code> para asegurar que los datos POST sean del tipo correcto antes de procesarlos.'
    ],
    [
        'title' => 'Reutilización POO',
        'desc' => 'Demostración de cómo la misma lógica de negocio puede servir a una terminal o a una web sin cambios.'
    ],
    [
        'title' => 'UI Dinámica con Tailwind',
        'desc' => 'Construcción de una interfaz moderna y reactiva que responde a los estados de error y éxito del backend.'
    ]
];

$professorNote = '
    <div class="space-y-4">
        <p>¿Recuerdas que en el Día 2 construimos esta calculadora para la terminal? Ahora usamos la misma arquitectura base, pero conectada a una interfaz Web.</p>
        <div class="bg-emerald-100/50 p-4 rounded-lg border-l-4 border-emerald-400 my-4">
            <strong class="text-emerald-900 block mb-1">Poder de la Abstracción:</strong>
            <p>Esta es la verdadera ventaja de la POO: la lógica de negocio (el cálculo del IMC) no sabe ni le importa si está siendo ejecutada en la consola o en un navegador. ¡Es código 100% agnóstico!</p>
        </div>
        <p>Fíjate en el controlador frontal (<code>public/index.php</code>). Maneja los errores de forma elegante: si algo falla en el Service, atrapamos la excepción y la mostramos al usuario sin que la app "explote".</p>
    </div>
';

$files = [
    'main.php'       => ['path' => 'main.php', 'icon' => 'ph-terminal-window'],
    'Person.php'     => ['path' => 'src/Classes/Person.php', 'icon' => 'ph-user'],
    'BMIService.php' => ['path' => 'src/Services/BMIService.php', 'icon' => 'ph-heartbeat'],
];



$executionMode = 'cli';

$cliOutput = '
<div class="text-[#56b6c2] font-bold">HEALTH-TECH SERVICE — BMI CALCULATOR</div>
<div class="text-slate-500">==============================================</div>
<div class="mt-2 text-slate-300">Procesando datos del paciente...</div>
<div class="mt-1">
    <span class="text-[#98c379]">Peso (kg)  :</span> <span class="text-white">72.5</span><br>
    <span class="text-[#98c379]">Altura (m):</span> <span class="text-white">1.78</span>
</div>

<div class="mt-4 text-[#e5c07b] font-bold">ANÁLISIS DE RESULTADOS:</div>
<div class="text-slate-500">──────────────────────────────────────</div>
<div class="mt-2 text-slate-300">Índice de Masa Corporal: <span class="text-white font-bold">22.88</span></div>
<div class="mt-1">
    Estado: <span class="text-emerald-400 font-bold uppercase tracking-widest">Normal</span> 
    <span class="text-slate-500 text-[10px] ml-2">(Rango: 18.5 - 24.9)</span>
</div>

<div class="mt-4 text-[#61afef] font-bold">LOG DE EXCEPCIONES (Manejo de Errores):</div>
<div class="text-slate-500">──────────────────────────────────────</div>
<div class="mt-2 text-slate-500">
    [INFO] Verificando tipos... <span class="text-emerald-400">float detected</span><br>
    [INFO] Validando rangos... <span class="text-emerald-400">valid</span><br>
    [INFO] Ejecutando cálculo... <span class="text-emerald-400">success</span>
</div>

<div class="mt-4 p-2 bg-emerald-500/10 border border-emerald-500/20 rounded text-[10px] text-emerald-400 italic">
    "La arquitectura permite atrapar InvalidArgumentException si el usuario ingresa valores imposibles (ej: peso < 0)."
</div>
';



require_once __DIR__ . '/../../templates/pedagogical_view.php';
