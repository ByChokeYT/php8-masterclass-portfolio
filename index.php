<?php
declare(strict_types=1);

$proyectos = [
    [
        'id' => '01',
        'folder' => '01-calculadora-minerales',
        'title' => 'Calculadora de Minerales',
        'description' => 'Cálculo de leyes y valores para Estaño y Zinc.',
        'icon' => '💎'
    ],
    [
        'id' => '02',
        'folder' => '02-conversor-divisas',
        'title' => 'Conversor de Divisas',
        'description' => 'Conversión de Bolivianos a USD con tasa fija.',
        'icon' => '💱'
    ],
    [
        'id' => '03',
        'folder' => '03-gestor-gastos',
        'title' => 'Gestor de Gastos',
        'description' => 'Registro y control de gastos personales diarios.',
        'icon' => '📉'
    ],
    [
        'id' => '04',
        'folder' => '04-simulador-prestamos',
        'title' => 'Simulador de Préstamos',
        'description' => 'Cálculo de cuotas mensuales con interés compuesto.',
        'icon' => '🏦'
    ],
    [
        'id' => '05',
        'folder' => '05-calculadora-imc',
        'title' => 'Calculadora de IMC',
        'description' => 'Cálculo del Índice de Masa Corporal con salud.',
        'icon' => '⚖️'
    ],
    [
        'id' => '06',
        'folder' => '06-reloj-tiempo-real',
        'title' => 'Reloj en Tiempo Real',
        'description' => 'Reloj dinámico usando PHP y funciones de tiempo.',
        'icon' => '⏱️'
    ],
    [
        'id' => '07',
        'folder' => '07-analizador-texto',
        'title' => 'Analizador de Texto',
        'description' => 'Cuenta palabras, caracteres y lee textos largos.',
        'icon' => '📝'
    ],
    [
        'id' => '08',
        'folder' => '08-adivina-numero',
        'title' => 'Adivina el Número',
        'description' => 'Juego interactivo usando la sesión de PHP.',
        'icon' => '🎲'
    ],
    [
        'id' => '09',
        'folder' => '09-validador-email',
        'title' => 'Validador de Correos',
        'description' => 'Validador con expresiones regulares y DNS MX.',
        'icon' => '📧'
    ],
    [
        'id' => '10',
        'folder' => '10-simulador-cajero',
        'title' => 'Simulador de Cajero ATM',
        'description' => 'Manejo de saldo, retiros y depósitos interactivos.',
        'icon' => '💳'
    ],
];
?>
<!DOCTYPE html>
<html lang="es" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>php8-masterclass-portfolio | Bychoke</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="https://www.php.net/favicon.ico">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Outfit', 'sans-serif'] },
                    animation: {
                        'gradient-x': 'gradient-x 15s ease infinite',
                        'float': 'float 6s ease-in-out infinite',
                    },
                    keyframes: {
                        'gradient-x': {
                            '0%, 100%': {
                                'background-size': '200% 200%',
                                'background-position': 'left center'
                            },
                            '50%': {
                                'background-size': '200% 200%',
                                'background-position': 'right center'
                            }
                        },
                        'float': {
                            '0%, 100%': { transform: 'translateY(0)' },
                            '50%': { transform: 'translateY(-10px)' },
                        }
                    }
                }
            }
        }
    </script>
    <style>
        .glass-card {
            background: rgba(15, 23, 42, 0.6);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.05);
            transition: all 0.3s ease;
        }
        .glass-card:hover {
            transform: translateY(-5px);
            border-color: rgba(56, 189, 248, 0.5); /* cyan-400 */
            box-shadow: 0 20px 40px -10px rgba(8, 145, 178, 0.3);
        }
    </style>
</head>
<body class="bg-slate-950 text-slate-200 min-h-screen relative overflow-x-hidden selection:bg-cyan-500/30">

    <!-- Background Effects -->
    <div class="fixed inset-0 z-0 pointer-events-none">
        <div class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] bg-blue-600/20 rounded-full blur-[120px] mix-blend-screen animate-float"></div>
        <div class="absolute bottom-[-10%] right-[-10%] w-[50%] h-[50%] bg-indigo-600/20 rounded-full blur-[150px] mix-blend-screen animate-float" style="animation-delay: 2s;"></div>
        <div class="absolute top-[40%] left-[60%] w-[30%] h-[30%] bg-cyan-600/10 rounded-full blur-[100px] mix-blend-screen animate-float" style="animation-delay: 4s;"></div>
        
        <!-- Grid Pattern Overlay -->
        <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGcgc3Ryb2tlPSIjMWUzYTg3IiBzdHJva2Utd2lkdGg9IjAuNSIgZmlsbD0ibm9uZSI+PHBhdGggZD0iTTAgNjBoNjBWMHoiLz48L2c+PC9zdmc+')] opacity-[0.03]"></div>
    </div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-24">
        
        <!-- Header Section -->
        <div class="text-center md:text-left mb-16 md:flex md:items-end justify-between border-b border-slate-800/60 pb-8">
            <div class="max-w-3xl">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-cyan-500/10 text-cyan-400 text-sm font-medium mb-6 border border-cyan-500/20">
                    <span class="w-2 h-2 rounded-full bg-cyan-400 animate-pulse"></span>
                    Nivel 1: Fundamentos y Lógica
                </div>
                <h1 class="text-5xl md:text-5xl lg:text-6xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 via-blue-500 to-indigo-600 tracking-tight mb-4 animate-gradient-x break-words">
                    php8-masterclass-portfolio
                </h1>
                <p class="text-lg md:text-xl text-slate-400 font-light leading-relaxed">
                    Colección de 10 proyectos interactivos desarrollados para consolidar los fundamentos de programación, POO y lógica usando las últimas características de PHP en entorno Linux (Fedora).
                </p>
            </div>
            <div class="mt-8 md:mt-0 flex flex-col items-center md:items-end gap-2">
                <div class="text-sm text-slate-500 font-medium">Desarrollador</div>
                <div class="flex items-center gap-3 bg-slate-900/50 px-4 py-2 rounded-xl border border-slate-800">
                    <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-cyan-500 to-blue-600 flex items-center justify-center text-white font-bold shadow-lg">
                        B
                    </div>
                    <div class="text-left">
                        <div class="text-slate-200 font-semibold leading-tight">Bychoke</div>
                        <div class="text-xs text-cyan-500">Sr. Software Engineer</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Projects Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
            
            <?php foreach ($proyectos as $proyecto): ?>
            <!-- Project Card -->
            <a href="/<?= $proyecto['folder'] ?>/public/" class="glass-card rounded-2xl p-6 group block relative overflow-hidden focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:ring-offset-2 focus:ring-offset-slate-950">
                <!-- Hover gradient effect inside card -->
                <div class="absolute inset-0 bg-gradient-to-br from-cyan-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                
                <div class="relative z-10">
                    <div class="flex justify-between items-start mb-4">
                        <div class="w-12 h-12 rounded-xl bg-slate-900 border border-slate-700/50 flex items-center justify-center text-2xl shadow-inner group-hover:scale-110 transition-transform duration-300 group-hover:border-cyan-500/30">
                            <?= $proyecto['icon'] ?>
                        </div>
                        <span class="text-4xl font-black text-slate-800/80 group-hover:text-slate-700 transition-colors select-none">
                            <?= $proyecto['id'] ?>
                        </span>
                    </div>
                    
                    <h3 class="text-xl font-bold text-slate-100 mb-2 group-hover:text-cyan-400 transition-colors">
                        <?= $proyecto['title'] ?>
                    </h3>
                    
                    <p class="text-sm text-slate-400 leading-relaxed mb-6 group-hover:text-slate-300 transition-colors line-clamp-2">
                        <?= htmlspecialchars($proyecto['description']) ?>
                    </p>
                    
                    <div class="flex items-center text-sm font-semibold text-cyan-500 group-hover:text-cyan-400 group-hover:translate-x-1 transition-all">
                        <span>Lanzar Proyecto</span>
                        <svg class="w-4 h-4 ml-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </div>
                </div>
            </a>
            <?php endforeach; ?>

        </div>

        <!-- Footer -->
        <footer class="mt-20 pt-8 border-t border-slate-800/60 text-center">
            <p class="text-slate-500 text-sm flex items-center justify-center gap-2">
                <span>Construido con</span>
                <svg class="w-4 h-4 text-rose-500 animate-pulse" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                </svg>
                <span>& PHP 8.5.3 en Linux.</span>
            </p>
            <p class="mt-2 text-xs text-slate-600">Sistema local optimizado para alto rendimiento y UI moderna.</p>
        </footer>

    </div>

</body>
</html>
