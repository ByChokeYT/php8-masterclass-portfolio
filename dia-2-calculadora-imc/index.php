<?php
declare(strict_types=1);

/**
 * MASTERCLASS ACADEMY // MANUAL MAESTRO DÍA 02 v17.0 (ELITE EDITION)
 */

$files = [
    'Main'      => ['path' => 'main.php', 'icon' => 'ph-terminal-window'],
    'Interface' => ['path' => 'src/Contracts/CalculadoraInterface.php', 'icon' => 'ph-file-code'],
    'Service'   => ['path' => 'src/Services/ImcCalculatorService.php', 'icon' => 'ph-gear-six'],
    'DTO'       => ['path' => 'src/DTO/MedicionCorporal.php', 'icon' => 'ph-database'],
    'UnitEnum'  => ['path' => 'src/Enums/SistemaUnidad.php', 'icon' => 'ph-ruler'],
    'ImcEnum'   => ['path' => 'src/Enums/ClasificacionImc.php', 'icon' => 'ph-activity'],
];

$fileContents = [];
foreach ($files as $name => $info) {
    $fileContents[$name] = file_get_contents(__DIR__ . '/' . $info['path']);
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Día 02 — Elite Guide | Masterclass PHP 8.5</title>
    
    <!-- Frameworks & Fonts -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    
    <!-- Prism.js for Syntax Highlighting -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/themes/prism-tomorrow.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/prism.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-php.min.js"></script>

    <style>
        :root { 
            --accent: #10b981; 
            --accent-glow: rgba(16, 185, 129, 0.3);
            --bg: #050607; 
            --surface: #0f1115;
            --border: rgba(255, 255, 255, 0.08);
        }

        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background: var(--bg); 
            color: #94a3b8; 
            overflow-x: hidden;
        }

        .tech-mono { font-family: 'JetBrains Mono', monospace; }

        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: var(--bg); }
        ::-webkit-scrollbar-thumb { background: #1e293b; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: var(--accent); }

        /* Glow Effects */
        .glow-text { text-shadow: 0 0 20px var(--accent-glow); }
        .glass-card { 
            background: var(--surface); 
            border: 1px solid var(--border); 
            border-radius: 24px; 
            backdrop-filter: blur(12px);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .glass-card:hover { 
            border-color: var(--accent); 
            box-shadow: 0 20px 40px -20px rgba(0,0,0,0.5), 0 0 20px rgba(16, 185, 129, 0.05);
            transform: translateY(-4px);
        }

        /* Tabs Logic */
        .tab-btn {
            position: relative;
            padding: 0.75rem 1.5rem;
            color: #64748b;
            font-weight: 600;
            font-size: 0.875rem;
            transition: all 0.2s;
            border-bottom: 2px solid transparent;
        }
        .tab-btn.active {
            color: var(--accent);
            border-bottom-color: var(--accent);
            background: rgba(16, 185, 129, 0.05);
        }

        /* Prism Overrides */
        pre[class*="language-"] {
            margin: 0 !important;
            padding: 1.5rem !important;
            background: transparent !important;
            font-size: 0.85rem !important;
        }
        code[class*="language-"] {
            text-shadow: none !important;
        }

        /* Animations */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in { animation: fadeIn 0.8s ease-out forwards; }

        .terminal-header {
            background: #1e293b;
            padding: 8px 16px;
            border-top-left-radius: 12px;
            border-top-right-radius: 12px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .dot { width: 10px; height: 10px; border-radius: 50%; }
    </style>
</head>
<body class="antialiased">

    <div class="max-w-6xl mx-auto px-6 py-12 md:py-24">
        
        <!-- HEADER -->
        <header class="text-center mb-24 animate-fade-in">
            <div class="inline-flex items-center gap-3 px-4 py-1.5 rounded-full bg-emerald-500/10 border border-emerald-500/20 text-emerald-500 text-[10px] font-black uppercase tracking-[0.2em] mb-8">
                <i class="ph-bold ph-sketch-logo"></i> Masterclass Day 02
            </div>
            <h1 class="text-5xl md:text-7xl font-extrabold text-white mb-6 tracking-tight italic">
                BMI Calculator <span class="text-emerald-500">Elite</span>
            </h1>
            <p class="text-xl text-slate-400 max-w-2xl mx-auto font-medium">
                Arquitectura de Software aplicada a la terminal. <br>
                <span class="text-slate-500 text-base">Interfaces, Enums, DTOs y Servicios de Alto Rendimiento.</span>
            </p>
        </header>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            <!-- LEFT COLUMN: CONCEPTS -->
            <div class="lg:col-span-4 space-y-8 animate-fade-in" style="animation-delay: 0.2s">
                <div class="glass-card p-8">
                    <h2 class="text-white font-bold flex items-center gap-3 mb-6 uppercase tracking-wider text-sm">
                        <i class="ph-bold ph-lightning text-emerald-500"></i> Core Principles
                    </h2>
                    <ul class="space-y-6">
                        <li class="group">
                            <h3 class="text-emerald-500 font-bold text-xs mb-1 uppercase">Contratos (Interfaces)</h3>
                            <p class="text-xs leading-relaxed">Definimos el "qué" antes del "cómo". Garantiza escalabilidad total.</p>
                        </li>
                        <li class="group">
                            <h3 class="text-emerald-500 font-bold text-xs mb-1 uppercase">Aritmética Entera</h3>
                            <p class="text-xs leading-relaxed">Operamos en gramos/mm para evitar la imprecisión del punto flotante en PHP.</p>
                        </li>
                        <li class="group">
                            <h3 class="text-emerald-500 font-bold text-xs mb-1 uppercase">Lazy Calculation</h3>
                            <p class="text-xs leading-relaxed">El IMC solo se calcula cuando se solicita, optimizando recursos.</p>
                        </li>
                    </ul>
                </div>

                <div class="glass-card p-8 bg-emerald-500/5 border-emerald-500/10">
                    <h2 class="text-white font-bold flex items-center gap-3 mb-4 uppercase tracking-wider text-sm">
                        <i class="ph-bold ph-terminal text-emerald-500"></i> Execution
                    </h2>
                    <p class="text-xs mb-4">Corre el programa en tu terminal:</p>
                    <div class="bg-black/40 rounded-xl p-4 tech-mono text-[11px] text-emerald-400 border border-white/5">
                        php main.php
                    </div>
                </div>
            </div>

            <!-- RIGHT COLUMN: CODE EXPLORER -->
            <div class="lg:col-span-8 animate-fade-in" style="animation-delay: 0.4s">
                <div class="glass-card overflow-hidden">
                    <!-- Tab Navigation -->
                    <div class="flex overflow-x-auto border-b border-white/5 bg-black/20">
                        <?php foreach ($files as $name => $info): ?>
                            <button onclick="showFile('<?= $name ?>')" 
                                    id="btn-<?= $name ?>" 
                                    class="tab-btn flex items-center gap-2 whitespace-nowrap">
                                <i class="ph-bold <?= $info['icon'] ?>"></i>
                                <?= $name ?>
                            </button>
                        <?php endforeach; ?>
                    </div>

                    <!-- Code Content -->
                    <div class="relative group">
                        <!-- Copy Button -->
                        <button onclick="copyCurrentCode()" class="absolute top-4 right-4 p-2 bg-white/5 hover:bg-emerald-500/20 text-slate-400 hover:text-emerald-500 rounded-lg transition-all z-10 opacity-0 group-hover:opacity-100">
                            <i class="ph-bold ph-copy"></i>
                        </button>

                        <?php foreach ($fileContents as $name => $content): ?>
                            <div id="code-<?= $name ?>" class="file-content hidden">
                                <pre class="language-php"><code><?= htmlspecialchars($content) ?></code></pre>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    
                    <!-- File Footer -->
                    <div class="bg-black/40 p-4 border-t border-white/5 flex justify-between items-center">
                        <span id="current-path" class="text-[10px] tech-mono text-slate-500 italic"></span>
                        <span class="text-[9px] font-black text-slate-700 uppercase tracking-widest">Masterclass Source v17.0</span>
                    </div>
                </div>

                <!-- CLI PREVIEW (SIMULATED) -->
                <div class="mt-8 glass-card overflow-hidden border-emerald-500/10">
                    <div class="terminal-header">
                        <div class="dot bg-red-500"></div>
                        <div class="dot bg-amber-500"></div>
                        <div class="dot bg-emerald-500"></div>
                        <span class="ml-4 text-[10px] font-bold text-slate-500 tech-mono">terminal — php main.php</span>
                    </div>
                    <div class="p-6 bg-black/60 tech-mono text-xs leading-relaxed">
                        <div class="text-emerald-500">CALCULADORA DE IMC v1.0 — ELITE</div>
                        <div class="text-slate-500">==============================================</div>
                        <div class="mt-2"><span class="text-cyan-400">¿Cuál es tu nombre?</span> Ana</div>
                        <div class="mt-4 text-white">RESULTADOS PARA: ANA</div>
                        <div class="text-slate-500">──────────────────────────────────────</div>
                        <div class="mt-2">IMC: <span class="text-white">24.98</span> | Estado: <span class="text-emerald-400">Normal</span></div>
                        <div class="mt-2 text-emerald-400/50">  ──────────▲─────────────────────────────</div>
                        <div class="text-slate-600">  BP        N          SP       O-I   O-II</div>
                        <div class="mt-4 text-emerald-400 italic">"Mantén tus hábitos. ¡Vas por buen camino!"</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- FOOTER -->
        <footer class="mt-32 text-center border-t border-white/5 pt-12">
            <p class="tech-mono text-[10px] text-slate-700 font-black tracking-[1em] uppercase">Elite Academy • Professional PHP Development</p>
        </footer>

    </div>

    <script>
        const filePaths = <?= json_encode(array_combine(array_keys($files), array_column($files, 'path'))) ?>;

        function showFile(name) {
            // Hide all
            document.querySelectorAll('.file-content').forEach(el => el.classList.add('hidden'));
            document.querySelectorAll('.tab-btn').forEach(el => el.classList.remove('active'));

            // Show current
            document.getElementById('code-' + name).classList.remove('hidden');
            document.getElementById('btn-' + name).classList.add('active');
            document.getElementById('current-path').textContent = './' + filePaths[name];
            
            // Re-highlight
            Prism.highlightAll();
        }

        function copyCurrentCode() {
            const activeContent = document.querySelector('.file-content:not(.hidden) code').textContent;
            navigator.clipboard.writeText(activeContent);
            alert('Código copiado al portapapeles');
        }

        // Initialize first file
        showFile('Main');
    </script>
</body>
</html>
