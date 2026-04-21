<?php
declare(strict_types=1);

/**
 * MASTERCLASS PHP 8.5 - ACADEMIC HUB v3.0
 * Interfaz Educativa para Alumnos con Progreso Global y Fases por Colores.
 */

readonly class ProjectNode {
    public function __construct(
        public string $id,
        public string $day,
        public string $title,
        public string $description,
        public string $path,
        public string $icon,
        public string $status = 'OPERATIONAL'
    ) {}
}

// Mapeo oficial de Descripciones (Roadmap)
$projectMetadata = [
    1 => 'Script CLI con lógica match para valorar pureza de Estaño, Zinc y Plata.',
    2 => 'Generador de enlaces de WhatsApp parametrizados mediante consola.',
    3 => 'Filtro dinámico de archivos .log buscando errores críticos de sistema.',
    4 => 'Automatización para renombrar assets masivamente en directorios.',
    5 => 'Conversor de datos crudos JSON a formato tabular CSV para Excel.',
    6 => 'Generador de passwords complejos usando tipado fuerte y aleatoriedad.',
    7 => 'Lógica matemática para cálculo de fletes por peso y distancia.',
    8 => 'Juego interactivo CLI basado en arrays y bucles de control.',
    9 => 'Limpieza y estandarización estricta de strings mediante Regex.',
    10 => 'Simulador de ATM con manejo de estados y bucles interactivos.',
    11 => 'Landing Page dinámica con secciones renderizadas desde arrays.',
    12 => 'Formulario con tablas de precios que actualizan totales dinámicamente.',
    13 => 'Sistema de confirmación a eventos con validación de datos POST.',
    14 => 'Módulo de carga segura restringiendo extensiones JPG y PNG.',
    15 => 'Visor de cards que carga videos dinámicamente según ID en URL.',
    16 => 'Sistema de acceso con manejo de sesiones ($_SESSION) en memoria.',
    17 => 'Calculadora de liquidaciones con diseño Tailwind y lógica de Fase 1.',
    18 => 'Motor de renderizado para convertir notas Markdown a HTML real.',
    19 => 'Generador modular de identidad profesional con carga de retrato.',
    20 => 'Sistema de votos con persistencia manual en .txt y analíticas AJAX.'
];

// Definición de Fases Académicas con Paleta de Colores por Dificultad
$faseDefinitions = [
    1 => [
        'title' => 'Fase 1: Fundamentos y Sintaxis Core',
        'desc' => 'Nivel Inicial: Lógica pura en terminal para dominar las bases del lenguaje.',
        'icon' => 'ph-terminal-window',
        'color' => 'emerald', // Verde
        'border' => 'border-emerald-500/30',
        'bg_glow' => 'rgba(16, 185, 129, 0.1)',
        'text' => 'text-emerald-400'
    ],
    2 => [
        'title' => 'Fase 2: UI/UX, Tailwind y Formularios',
        'desc' => 'Nivel Intermedio: Conexión frontend-backend y manejo de datos interactivos.',
        'icon' => 'ph-palette',
        'color' => 'cyan', // Azul
        'border' => 'border-cyan-500/30',
        'bg_glow' => 'rgba(6, 182, 212, 0.1)',
        'text' => 'text-cyan-400'
    ],
    3 => [
        'title' => 'Fase 3: Bases de Datos y Persistencia',
        'desc' => 'Nivel Desafío: Integración con MySQL/PDO y arquitecturas de datos.',
        'icon' => 'ph-database',
        'color' => 'amber', // Amarillo/Ámbar
        'border' => 'border-amber-500/30',
        'bg_glow' => 'rgba(245, 158, 11, 0.1)',
        'text' => 'text-amber-400'
    ],
    4 => [
        'title' => 'Fase 4: APIs y Arquitectura Moderna',
        'desc' => 'Nivel Avanzado: Servicios REST, POO avanzada y patrones de diseño.',
        'icon' => 'ph-cloud-arrow-up',
        'color' => 'rose', // Robusto/Rojo
        'border' => 'border-rose-500/30',
        'bg_glow' => 'rgba(244, 63, 94, 0.1)',
        'text' => 'text-rose-400'
    ],
    5 => [
        'title' => 'Fase 5: Proyectos Full-Stack Real-World',
        'desc' => 'Nivel Experto: Aplicaciones completas, seguridad extrema y despliegue.',
        'icon' => 'ph-rocket-launch',
        'color' => 'violet', // Púrpura/Indigo
        'border' => 'border-violet-500/30',
        'bg_glow' => 'rgba(139, 92, 246, 0.1)',
        'text' => 'text-violet-400'
    ]
];

// Escaneo dinámico y Agrupación por Fase
$fases = [];
$projectsTotal = 0;
$iterator = new DirectoryIterator(__DIR__);

foreach ($iterator as $fileInfo) {
    if ($fileInfo->isDir() && !$fileInfo->isDot() && str_starts_with($fileInfo->getFilename(), 'dia-')) {
        $folderName = $fileInfo->getFilename();
        
        $parts = explode('-', $folderName);
        $dayNum = (int)($parts[1] ?? 0);
        $rawTitle = implode(' ', array_slice($parts, 2));
        $cleanTitle = ucwords(str_replace('-', ' ', $rawTitle));

        $indexPath = "/{$folderName}/index.php";
        if (file_exists(__DIR__ . "/{$folderName}/public/index.php")) {
            $indexPath = "/{$folderName}/public/index.php";
        }

        $icon = match(true) {
            str_contains(strtolower($cleanTitle), 'calculadora') => 'ph-calculator',
            str_contains(strtolower($cleanTitle), 'conversor') => 'ph-currency-circle-dollar',
            str_contains(strtolower($cleanTitle), 'gestor') => 'ph-chart-pie-slice',
            str_contains(strtolower($cleanTitle), 'prestamos') => 'ph-bank',
            str_contains(strtolower($cleanTitle), 'reloj') => 'ph-clock',
            str_contains(strtolower($cleanTitle), 'texto') => 'ph-text-aa',
            str_contains(strtolower($cleanTitle), 'email') => 'ph-envelope',
            str_contains(strtolower($cleanTitle), 'cajero') => 'ph-credit-card',
            str_contains(strtolower($cleanTitle), 'landing') => 'ph-browser',
            str_contains(strtolower($cleanTitle), 'cotizacion') => 'ph-receipt',
            str_contains(strtolower($cleanTitle), 'rsvp') => 'ph-envelope-simple',
            str_contains(strtolower($cleanTitle), 'archivos') => 'ph-upload-simple',
            str_contains(strtolower($cleanTitle), 'video') => 'ph-video-camera',
            str_contains(strtolower($cleanTitle), 'markdown') => 'ph-code-block',
            str_contains(strtolower($cleanTitle), 'tarjetas') => 'ph-identification-card',
            str_contains(strtolower($cleanTitle), 'encuesta') => 'ph-chart-bar',
            default => 'ph-cube'
        };

        $faseNum = (int)ceil($dayNum / 10);
        $fases[$faseNum][] = new ProjectNode(
            $folderName,
            "DÍA " . str_pad((string)$dayNum, 2, '0', STR_PAD_LEFT),
            $cleanTitle,
            $projectMetadata[$dayNum] ?? 'Descripción técnica oficial en proceso...',
            $indexPath,
            $icon
        );
        $projectsTotal++;
    }
}

// Ordenar cada fase y calcular progreso
foreach ($fases as $fNum => $projList) {
    usort($fases[$fNum], fn($a, $b) => (int)filter_var($a->day, FILTER_SANITIZE_NUMBER_INT) <=> (int)filter_var($b->day, FILTER_SANITIZE_NUMBER_INT));
}
ksort($fases);

$progressPercent = ($projectsTotal / 50) * 100;

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>50_PROYECTOS_PHP // MASTERCLASS</title>
    <link rel="icon" type="image/x-icon" href="https://www.php.net/favicon.ico">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;700;900&family=JetBrains+Mono:wght@400;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <style>
        :root {
            --bg-deep: #05070a;
            --panel-bg: rgba(13, 17, 23, 0.4);
        }

        body {
            background-color: var(--bg-deep);
            color: #94a3b8;
            font-family: 'Outfit', sans-serif;
            min-height: 100vh;
        }

        .industrial-grid {
            position: fixed; inset: 0; z-index: -1;
            background-image: 
                linear-gradient(rgba(255, 255, 255, 0.012) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255, 255, 255, 0.012) 1px, transparent 1px);
            background-size: 40px 40px;
        }

        .tech-label { font-family: 'JetBrains Mono', monospace; font-size: 8px; text-transform: uppercase; letter-spacing: 0.1em; opacity: 0.5; }
        
        .fase-section { margin-bottom: 5rem; }
        .fase-header { border-left: 3px solid currentColor; padding-left: 1.5rem; margin-bottom: 2.5rem; position: relative; }
        
        .node-card {
            background: var(--panel-bg);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.03);
            border-radius: 16px;
            padding: 1.25rem;
            transition: all 0.4s cubic-bezier(0.2, 1, 0.2, 1);
            display: flex; flex-direction: column; gap: 0.75rem;
            height: 100%;
        }

        .node-card:hover {
            transform: translateY(-5px) scale(1.02);
            background: rgba(255, 255, 255, 0.02);
        }

        .node-icon {
            width: 40px; height: 40px;
            background: rgba(255,255,255,0.03);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 20px;
            transition: all 0.3s ease;
        }

        .node-card:hover .node-icon { color: white; }

        .progress-bar-container { height: 6px; background: rgba(255,255,255,0.05); border-radius: 10px; overflow: hidden; position: relative; }
        .progress-bar-fill { height: 100%; background: linear-gradient(90deg, #10b981, #3b82f6); transition: width 1.5s ease-out; }
        
        .status-badge { font-size: 7px; padding: 2px 6px; border-radius: 4px; border: 1px solid currentColor; display: inline-flex; align-items: center; gap: 4px; }
        .status-dot { width: 4px; height: 4px; background: currentColor; border-radius: 50%; display: inline-block; animation: pulse 2s infinite; }
        @keyframes pulse { 0%, 100% { opacity: 1; transform: scale(1); } 50% { opacity: 0.5; transform: scale(1.3); } }

        ::-webkit-scrollbar { width: 4px; }
        ::-webkit-scrollbar-thumb { background: #3b82f6; border-radius: 10px; }
    </style>
</head>
<body class="p-8 lg:p-12 xl:p-16">
    <div class="industrial-grid"></div>

    <div class="max-w-7xl mx-auto">
        <!-- GLOBAL HEADER EDUCATIVO -->
        <header class="mb-20 space-y-10">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-6">
                <div>
                    <div class="flex items-center gap-3 mb-2">
                        <div class="status-badge text-emerald-400"><span class="status-dot"></span> ACADEMIA_PHP_ACTIVA</div>
                        <span class="tech-label">CURSO_PREMIUM // 50_DÍAS // v3.0</span>
                    </div>
                    <h1 class="text-6xl font-black text-white uppercase tracking-tighter leading-none">
                        50_PROYECTOS_<span class="text-[#4F5B93]">PHP</span><br>
                        <span class="text-3xl font-light tracking-[0.2em] opacity-40">MASTERCLASS</span>
                    </h1>
                </div>
                <div class="text-right w-full md:w-auto">
                    <div class="flex justify-between md:justify-end gap-12 mb-4">
                        <div class="text-left">
                            <span class="tech-label">Progreso_Global</span>
                            <div class="text-3xl font-black text-white"><?= round($progressPercent) ?>%</div>
                        </div>
                        <div>
                            <span class="tech-label">Nodos_Completos</span>
                            <div class="text-3xl font-black text-white font-mono"><?= str_pad((string)$projectsTotal, 2, '0', STR_PAD_LEFT) ?>/50</div>
                        </div>
                    </div>
                    <div class="progress-bar-container w-full md:w-64">
                        <div class="progress-bar-fill" style="width: <?= $progressPercent ?>%"></div>
                    </div>
                </div>
            </div>
        </header>

        <!-- FASES ACADÉMICAS -->
        <?php foreach ($fases as $fNum => $nodes): 
            $f = $faseDefinitions[$fNum];
        ?>
            <section class="fase-section">
                <div class="fase-header <?= $f['text'] ?>">
                    <div class="flex items-center gap-4 mb-3">
                        <div class="p-3 bg-white/5 rounded-xl border <?= $f['border'] ?>">
                            <i class="ph-bold <?= $f['icon'] ?> text-2xl"></i>
                        </div>
                        <div>
                            <h2 class="text-2xl font-black uppercase tracking-tight text-white"><?= $f['title'] ?></h2>
                            <span class="tech-label opacity-100 <?= $f['text'] ?>">Dificultad_Nivel_<?= $fNum ?></span>
                        </div>
                    </div>
                    <p class="text-sm text-slate-500 max-w-3xl leading-relaxed">
                        <?= $f['desc'] ?>
                    </p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                    <?php foreach ($nodes as $project): ?>
                        <a href="<?= $project->path ?>" class="node-card group hover:<?= $f['border'] ?>" style="--hover-glow: <?= $f['bg_glow'] ?>">
                            <div class="flex justify-between items-start">
                                <div class="node-icon group-hover:bg-<?= $f['color'] ?>-500">
                                    <i class="ph <?= $project->icon ?> group-hover:text-white transition-colors opacity-40 group-hover:opacity-100"></i>
                                </div>
                                <span class="tech-label opacity-40 font-bold group-hover:opacity-100 transition-opacity"><?= $project->day ?></span>
                            </div>
                            
                            <div class="flex-1 space-y-2">
                                <h3 class="text-white font-bold text-base group-hover:<?= $f['text'] ?> transition-colors leading-tight">
                                    <?= $project->title ?>
                                </h3>
                                <p class="text-[10px] text-slate-500 leading-relaxed font-medium">
                                    <?= $project->description ?>
                                </p>
                            </div>

                            <div class="flex items-center justify-between mt-4 pt-4 border-t border-white/5 h-8">
                                <div class="status-badge !border-none !p-0 opacity-40 group-hover:opacity-100 <?= $f['text'] ?>">
                                    <span class="status-dot"></span> ENTRAR_AL_RETO
                                </div>
                                <i class="ph-bold ph-arrow-right text-[10px] transform group-hover:translate-x-1 transition-transform opacity-0 group-hover:opacity-100 <?= $f['text'] ?>"></i>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>
            </section>
        <?php endforeach; ?>

        <!-- FOOTER ACADÉMICO -->
        <footer class="mt-32 border-t border-white/5 pt-12 flex flex-col md:flex-row justify-between items-center gap-8 opacity-20">
            <div class="flex items-center gap-4">
                <i class="ph-fill ph-graduation-cap text-3xl"></i>
                <span class="tech-label text-[10px]">Plataforma de Formación Continua // By Choke // 2024</span>
            </div>
            <div class="flex gap-12">
                <span class="tech-label text-[10px]">Fase_Current: 0x02</span>
                <span class="tech-label text-[10px]">Data_Sync: Cloud_Active</span>
            </div>
        </footer>
    </div>

    <style>
        /* Inyectar dinámicamente los estilos de hover glow */
        .node-card:hover {
            box-shadow: 0 15px 40px -10px var(--hover-glow);
        }
    </style>
</body>
</html>
