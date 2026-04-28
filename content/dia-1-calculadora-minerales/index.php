<?php
declare(strict_types=1);

/**
 * MASTERCLASS ACADEMY // MANUAL MAESTRO COMPLETO v10.1
 */

$enumCode = file_get_contents(__DIR__ . '/src/Enums/MineralType.php');
$dtoCode = file_get_contents(__DIR__ . '/src/DTO/Liquidacion.php');
$serviceCode = file_get_contents(__DIR__ . '/src/Services/CalculatorService.php');
$mainCode = file_get_contents(__DIR__ . '/main.php');

?>
<!DOCTYPE html>
<html lang="es" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Día 01 — Calculadora de Minerales CLI | Masterclass PHP 8.5</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: #08090a; color: #94a3b8; }
        .tech-mono { font-family: 'JetBrains Mono', monospace; }
        .glass { background: rgba(15, 17, 20, 0.7); backdrop-filter: blur(12px); border: 1px solid rgba(255,255,255,0.05); }
        .bento-card { background: #0f1114; border: 1px solid rgba(255,255,255,0.05); border-radius: 24px; transition: all 0.3s; }
        .code-window { background: #0d0f12; border-radius: 16px; border: 1px solid rgba(255,255,255,0.08); overflow: hidden; margin-top: 1.5rem; }
        .code-header { background: #16191d; padding: 0.75rem 1.25rem; display: flex; align-items: center; gap: 0.5rem; border-bottom: 1px solid rgba(255,255,255,0.05); }
        .dot { width: 10px; height: 10px; border-radius: 50%; }
        .summary-table th { text-align: left; padding: 1rem; border-bottom: 1px solid rgba(255,255,255,0.1); font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.1em; color: #64748b; }
        .summary-table td { padding: 1.25rem 1rem; border-bottom: 1px solid rgba(255,255,255,0.05); font-size: 0.85rem; }
    </style>
</head>
<body class="selection:bg-blue-500/30 selection:text-blue-200">

    <?php require_once __DIR__ . '/../_nav.php'; ?>

    <div class="max-w-5xl mx-auto px-6 py-20">
        
        <!-- INTRODUCCIÓN -->
        <header class="mb-32">
            <h1 class="text-6xl font-black text-white tracking-tighter mb-8 italic">Día 01 — Calculadora de Minerales CLI</h1>
            <h4 class="text-blue-500 font-bold tech-mono tracking-widest uppercase mb-12">Masterclass PHP 8.5 | Fase 1: Dominio de la Terminal</h4>
            
            <div class="space-y-6 text-xl text-slate-400 leading-relaxed border-l-4 border-blue-500/30 pl-8">
                <h2 class="text-2xl font-black text-white uppercase italic">¿Qué vas a construir?</h2>
                <p>Una calculadora que corre <strong>100% en la terminal</strong> (sin navegador, sin HTML). El programa te pregunta qué mineral tienes, cuánto pesa y qué tan puro es — y te calcula cuánto vale en USD.</p>
                
                <p class="text-sm font-bold text-slate-500">Al terminar este día vas a entender:</p>
                <ul class="text-sm space-y-2 list-disc pl-5 opacity-80">
                    <li>Qué es un <strong>Enum</strong> y para qué sirve en PHP 8.5</li>
                    <li>Qué es un <strong>DTO</strong> (objeto de datos) y por qué usamos <code>readonly</code></li>
                    <li>Cómo separar la lógica en un <strong>Service</strong></li>
                    <li>Por qué <strong>nunca debes usar <code>float</code></strong> para dinero</li>
                    <li>Cómo darle <strong>colores y formato</strong> a la terminal</li>
                </ul>
            </div>
        </header>

        <!-- CONCEPTOS CLAVE -->
        <section class="mb-40">
            <h2 class="text-3xl font-black text-white uppercase italic mb-12">Conceptos clave antes de empezar</h2>
            
            <div class="grid grid-cols-1 gap-12">
                <div class="bento-card p-10">
                    <h3 class="text-xl font-bold text-blue-400 mb-4">¿Qué es un Enum?</h3>
                    <p class="mb-6">Un Enum es una lista de opciones fijas. En vez de escribir el string <code>"Estaño"</code> en 10 lugares distintos (y arriesgarte a escribir <code>"estaño"</code> con minúscula en uno), defines el Enum una vez y lo usas siempre igual.</p>
                    <pre class="tech-mono text-[11px] bg-black/40 p-6 rounded-xl border border-white/5">// Sin Enum — peligroso
$mineral = "estaño"; // ¿con tilde? ¿sin tilde? ¿mayúscula?

// Con Enum — seguro
$mineral = MineralType::ESTANO; // PHP no te deja equivocarte</pre>
                </div>

                <div class="bento-card p-10">
                    <h3 class="text-xl font-bold text-blue-400 mb-4">¿Qué es un DTO?</h3>
                    <p class="mb-6">DTO = Data Transfer Object. Es una caja que guarda datos relacionados juntos. La palabra <code>readonly</code> significa que una vez que guardas los datos, <strong>nadie los puede cambiar</strong>. Eso evita bugs.</p>
                    <pre class="tech-mono text-[11px] bg-black/40 p-6 rounded-xl border border-white/5">// readonly = inmutable, nadie puede cambiar los datos después
readonly class Liquidacion { ... }</pre>
                </div>

                <div class="bento-card p-10">
                    <h3 class="text-xl font-bold text-blue-400 mb-4">¿Por qué no usar float para dinero?</h3>
                    <pre class="tech-mono text-[11px] bg-black/40 p-6 rounded-xl border border-white/5">// El problema clásico de punto flotante
var_dump(0.1 + 0.2 === 0.3); // bool(false) ← ¡SORPRESA!
echo 0.1 + 0.2;              // 0.30000000000000004

// La solución: trabajar en CENTAVOS (enteros)
// $2.50 USD → 250 centavos
// 250 + 20 = 270 centavos → $2.70 USD ✅</pre>
                </div>
            </div>
        </section>

        <!-- ESTRUCTURA -->
        <section class="mb-40">
            <h2 class="text-3xl font-black text-white uppercase italic mb-8">Estructura del proyecto</h2>
            <div class="bg-black/40 p-10 rounded-[32px] border border-white/5 mb-8">
                <pre class="tech-mono text-sm leading-loose">
dia-01-calculadora-minerales/
├── main.php                    ← Punto de entrada, menú CLI
└── src/
    ├── Enums/
    │   └── MineralType.php     ← Lista de minerales disponibles
    ├── DTO/
    │   └── Liquidacion.php     ← Caja de datos del pedido
    └── Services/
        └── CalculatorService.php ← Lógica de cálculo</pre>
            </div>
            <div class="p-8 glass rounded-3xl">
                <h3 class="text-lg font-bold text-white mb-4">¿Por qué esta estructura?</h3>
                <p class="text-sm mb-4">Cada archivo tiene <strong>una sola responsabilidad</strong>:</p>
                <ul class="text-sm space-y-2 italic opacity-70">
                    <li>- <strong>MineralType</strong> sabe qué minerales existen</li>
                    <li>- <strong>Liquidacion</strong> guarda los datos del usuario</li>
                    <li>- <strong>CalculatorService</strong> hace los cálculos</li>
                    <li>- <strong>main.php</strong> solo muestra el menú y conecta todo</li>
                </ul>
                <p class="text-sm mt-6">Si mañana necesitas agregar un nuevo mineral, solo tocas <code>MineralType.php</code>. No buscas por todo el código.</p>
            </div>
        </section>

        <!-- CÓDIGO -->
        <section class="mb-40 space-y-24">
            <h2 class="text-3xl font-black text-white uppercase italic mb-12">Paso 2 — Crea los archivos</h2>
            
            <!-- ENUM -->
            <div class="space-y-4">
                <h4 class="text-blue-500 font-bold tech-mono text-xs uppercase">1. src/Enums/MineralType.php</h4>
                <div class="code-window">
                    <div class="code-header"><span class="text-[9px] text-slate-500 font-bold uppercase">PHP 8.5 // Enum</span><div class="dot bg-red-500 ml-auto"></div><div class="dot bg-yellow-500"></div><div class="dot bg-green-500"></div></div>
                    <div class="p-6"><pre class="bg-transparent border-none p-0 m-0 text-[10px] leading-relaxed"><?= htmlspecialchars($enumCode) ?></pre></div>
                </div>
            </div>

            <!-- DTO -->
            <div class="space-y-4">
                <h4 class="text-blue-500 font-bold tech-mono text-xs uppercase">2. src/DTO/Liquidacion.php</h4>
                <div class="code-window">
                    <div class="code-header"><span class="text-[9px] text-slate-500 font-bold uppercase">PHP 8.5 // Readonly</span><div class="dot bg-red-500 ml-auto"></div><div class="dot bg-yellow-500"></div><div class="dot bg-green-500"></div></div>
                    <div class="p-6"><pre class="bg-transparent border-none p-0 m-0 text-[10px] leading-relaxed"><?= htmlspecialchars($dtoCode) ?></pre></div>
                </div>
            </div>

            <!-- SERVICE -->
            <div class="space-y-4">
                <h4 class="text-blue-500 font-bold tech-mono text-xs uppercase">3. src/Services/CalculatorService.php</h4>
                <div class="code-window">
                    <div class="code-header"><span class="text-[9px] text-slate-500 font-bold uppercase">PHP 8.5 // Business Logic</span><div class="dot bg-red-500 ml-auto"></div><div class="dot bg-yellow-500"></div><div class="dot bg-green-500"></div></div>
                    <div class="p-6"><pre class="bg-transparent border-none p-0 m-0 text-[10px] leading-relaxed"><?= htmlspecialchars($serviceCode) ?></pre></div>
                </div>
            </div>

            <!-- MAIN -->
            <div class="space-y-4">
                <h4 class="text-blue-500 font-bold tech-mono text-xs uppercase">4. main.php</h4>
                <div class="code-window">
                    <div class="code-header"><span class="text-[9px] text-slate-500 font-bold uppercase">PHP 8.5 // Entry Point</span><div class="dot bg-red-500 ml-auto"></div><div class="dot bg-yellow-500"></div><div class="dot bg-green-500"></div></div>
                    <div class="p-6"><pre class="bg-transparent border-none p-0 m-0 text-[10px] leading-relaxed"><?= htmlspecialchars($mainCode) ?></pre></div>
                </div>
            </div>
        </section>

        <!-- EJEMPLO -->
        <section class="mb-40">
            <h2 class="text-3xl font-black text-white uppercase italic mb-8">Ejemplo de ejecución</h2>
            <div class="code-window border-emerald-500/30 shadow-[0_0_50px_rgba(16,185,129,0.1)]">
                <div class="code-header bg-emerald-950/20"><div class="dot bg-emerald-500"></div><span class="ml-4 tech-mono text-[9px] text-emerald-500 font-bold">Terminal Activa // Success_Simulation</span></div>
                <div class="p-10 tech-mono text-sm text-emerald-400">
                    <p class="opacity-30 mb-4">$ php main.php</p>
                    <pre class="bg-transparent border-none p-0 m-0 overflow-visible">
==============================================
   CALCULADORA DE MINERALES v2.0
==============================================
Selecciona el mineral (1-3): 3
Peso bruto en kg: 10
Cotización actual en USD/kg: 500
Pureza del mineral (0-100)%: 92

==============================================
   LIQUIDACIÓN FINAL
==============================================
Tipo        : 🪙 Plata (Ag)
Peso bruto  : 10.000 kg
Peso fino   : 9.2000 kg
Calidad     : ALTA CALIDAD

TOTAL A LIQUIDAR: $4,692.00 USD</pre>
                </div>
            </div>
        </section>

        <!-- RETOS -->
        <section class="mb-40">
            <h2 class="text-3xl font-black text-white uppercase italic mb-12">Retos para practicar</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="p-8 border border-white/5 rounded-[32px] bg-blue-500/5">
                    <span class="text-[10px] font-bold text-blue-400 uppercase tracking-widest">Nivel 1</span>
                    <h4 class="text-lg font-bold text-white mt-2 mb-4 italic">Básico</h4>
                    <p class="text-xs text-slate-500 leading-relaxed italic">- Agrega un cuarto mineral: ORO con símbolo Au y emoji 🥇<br>- El oro debe tener una prima del +5% en el CalculatorService</p>
                </div>
                <div class="p-8 border border-white/5 rounded-[32px] bg-amber-500/5">
                    <span class="text-[10px] font-bold text-amber-400 uppercase tracking-widest">Nivel 2</span>
                    <h4 class="text-lg font-bold text-white mt-2 mb-4 italic">Intermedio</h4>
                    <p class="text-xs text-slate-500 leading-relaxed italic">- Después de mostrar el resultado, pregunta al usuario ¿Calcular otro? (s/n)<br>- Si responde s, vuelve al inicio sin cerrar el programa (usa un while)</p>
                </div>
                <div class="p-8 border border-white/5 rounded-[32px] bg-rose-500/5">
                    <span class="text-[10px] font-bold text-rose-400 uppercase tracking-widest">Nivel 3</span>
                    <h4 class="text-lg font-bold text-white mt-2 mb-4 italic">Avanzado</h4>
                    <p class="text-xs text-slate-500 leading-relaxed italic">- Guarda cada liquidación en un array durante la sesión<br>- Al salir, muestra un resumen con el total acumulado de todas las liquidaciones</p>
                </div>
            </div>
        </section>

        <!-- RESUMEN -->
        <section class="mb-20">
            <h2 class="text-3xl font-black text-white uppercase italic mb-12">Resumen de lo que aprendiste</h2>
            <div class="overflow-x-auto">
                <table class="summary-table w-full">
                    <thead>
                        <tr>
                            <th>Concepto</th>
                            <th>Dónde lo usaste</th>
                            <th>Para qué sirve</th>
                        </tr>
                    </thead>
                    <tbody class="text-slate-300">
                        <tr>
                            <td class="font-bold text-white"><code>enum</code> con métodos</td>
                            <td>MineralType.php</td>
                            <td>Lista de opciones fijas con comportamiento</td>
                        </tr>
                        <tr>
                            <td class="font-bold text-white"><code>readonly class</code></td>
                            <td>Liquidacion.php</td>
                            <td>Datos inmutables, sin bugs por modificación accidental</td>
                        </tr>
                        <tr>
                            <td class="font-bold text-white"><code>match()</code></td>
                            <td>Ambos archivos</td>
                            <td>Alternativa limpia al switch</td>
                        </tr>
                        <tr>
                            <td class="font-bold text-white">Aritmética entera</td>
                            <td>CalculatorService.php</td>
                            <td>Evitar errores de punto flotante en dinero</td>
                        </tr>
                        <tr>
                            <td class="font-bold text-white"><code>ValueError</code></td>
                            <td>Liquidacion.php</td>
                            <td>Validar datos con mensajes de error claros</td>
                        </tr>
                        <tr>
                            <td class="font-bold text-white">Colores ANSI</td>
                            <td>main.php</td>
                            <td>Terminal con formato profesional</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>

    </div>

    <footer class="mt-40 py-20 border-t border-white/5 text-center">
        <p class="tech-mono text-[10px] text-slate-600 font-bold tracking-[8px] uppercase">Masterclass PHP 8.5 — Día 01 de 50</p>
    </footer>

</body>
</html>
