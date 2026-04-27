<?php
declare(strict_types=1);

/**
 * PHP 8.5 ARCHITECT NEXUS - v6.0
 * HUB PRINCIPAL: LA EXPERIENCIA DE APRENDIZAJE DEFINITIVA
 */

readonly class ProjectNode {
    public function __construct(
        public string $id,
        public string $day,
        public int $dayNum,
        public string $title,
        public string $description,
        public string $path,
        public string $icon,
        public string $hex,
        public array $tags = []
    ) {}
}

$projectMetadata = [
    1 => 'Ingeniería de Consola (CLI): El nacimiento de la lógica inmutable con Enums y DTOs.',
    2 => 'Evaluación de salud profesional: Manejo de tipos de punto flotante y rangos de clasificación.',
    3 => 'Filtrado de logs de sistema y búsqueda de patrones.',
    4 => 'Lógica matemática aplicada a proyecciones financieras.',
    5 => 'Formateo de datos crudos JSON a CSV industrial.',
    6 => 'Generación de tokens seguros y claves complejas.',
    7 => 'Manipulación de strings y análisis semántico.',
    8 => 'Estructuras de decisión y bucles interactivos.',
    9 => 'Regex avanzado para limpieza de datos de usuario.',
    10 => 'Simulación de estados complejos y flujos de caja.',
    11 => 'Primeros pasos con Tailwind CSS y renderizado PHP.',
    12 => 'Datos dinámicos en tiempo real mediante formularios.',
    13 => 'Confirmaciones seguras y validación estricta POST.',
    14 => 'Manejo seguro de assets y carga de archivos.',
    15 => 'Galería de video dinámica gestionada por ID.',
    16 => 'Manejo de sesiones y seguridad de acceso inicial.',
    17 => 'Dashboard web profesional para cálculos masivos.',
    18 => 'Renderizado de contenido técnico Markdown a HTML.',
    19 => 'Identidad profesional modular con GD Library.',
    20 => 'Persistencia manual en archivos .txt y AJAX.',
    21 => 'Propiedades readonly y arquitectura inmutable.',
    22 => 'Gestión completa de invitados con base de datos SQLite.',
    23 => 'Transacciones industriales y auditoría de tablas.',
    24 => 'Hashing de contraseñas y capas de seguridad SQL.',
    25 => 'Persistencia de URLs y metadatos con códigos QR.',
    26 => 'Interacción pública masiva con base de datos.',
    27 => 'Renderizado dinámico de servicios desde SQL.',
    28 => 'Buscador con filtros SQL avanzados (LIKE/WHERE).',
    29 => 'Categorización y reportes de gastos industriales.',
    30 => 'Métricas y resúmenes técnicos de administración.',
    31 => 'Integración de librerías externas vía Composer.',
    32 => 'Consumo de datos externos mediante Web Scraping.',
    33 => 'Mercado de metales en tiempo real (APIs REST).',
    34 => 'Exportación de documentos oficiales en PDF.',
    35 => 'Generación de reportes masivos en CSV/Excel.',
    37 => 'Gestión de redirecciones y estados HTTP.',
    38 => 'Autenticación híbrida y exposición de API REST.',
    39 => 'Consumo de feeds XML técnicos y de minería.'
];

$faseDefinitions = [
    1 => ['num' => '01', 'title' => 'Fundamentos', 'ph' => 'ph-terminal-window', 'hex' => '#10b981', 'desc' => 'Dominio de lógica CLI y algoritmos.'],
    2 => ['num' => '02', 'title' => 'Web Architecture', 'ph' => 'ph-palette', 'hex' => '#06b6d4', 'desc' => 'Interfaces reactivas y gestión web.'],
    3 => ['num' => '03', 'title' => 'SQL Persistencia', 'ph' => 'ph-database', 'hex' => '#f59e0b', 'desc' => 'Bases de datos y hardening SQL.'],
    4 => ['num' => '04', 'title' => 'Enterprise APIs', 'ph' => 'ph-cloud-arrow-up', 'hex' => '#f43f5e', 'desc' => 'Microservicios y Composer.'],
    5 => ['num' => '05', 'title' => 'Expert Deploy', 'ph' => 'ph-rocket-launch', 'hex' => '#8b5cf6', 'desc' => 'Seguridad y despliegue real.']
];

$allNodes = [];
$iterator = new DirectoryIterator(__DIR__);
foreach ($iterator as $fileInfo) {
    if ($fileInfo->isDir() && !$fileInfo->isDot() && str_starts_with($fileInfo->getFilename(), 'dia-')) {
        $folderName = $fileInfo->getFilename();
        $parts = explode('-', $folderName);
        $dayNum = (int)($parts[1] ?? 0);
        $rawTitle = implode(' ', array_slice($parts, 2));
        $cleanTitle = ucwords(str_replace('-', ' ', $rawTitle));
        $faseNum = (int)ceil($dayNum / 10);
        $hex = $faseDefinitions[$faseNum]['hex'] ?? '#3b82f6';

        $allNodes[] = new ProjectNode(
            $folderName, 
            "D" . str_pad((string)$dayNum, 2, '0', STR_PAD_LEFT), 
            $dayNum, 
            $cleanTitle, 
            $projectMetadata[$dayNum] ?? 'Iniciando reto técnico...', 
            "/{$folderName}/index.php", 
            match($dayNum) { 1 => 'ph-calculator', 2 => 'ph-currency-circle-dollar', default => 'ph-cube' },
            $hex,
            ['PHP 8.5', 'Industrial']
        );
    }
}
usort($allNodes, fn($a, $b) => $a->dayNum <=> $b->dayNum);
$latestDay = !empty($allNodes) ? max(array_column($allNodes, 'dayNum')) : 0;
$progressPercent = (count($allNodes) / 50) * 100;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP ARCHITECT NEXUS // HUB</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <style>
        :root { --bg: #050608; }
        body { background: var(--bg); color: #cbd5e1; font-family: 'Plus Jakarta Sans', sans-serif; overflow-x: hidden; }
        
        /* Efecto de Rejilla Dinámica */
        .dynamic-grid { position: fixed; inset: 0; background-image: 
            linear-gradient(rgba(255,255,255,0.02) 1px, transparent 1px),
            linear-gradient(90deg, rgba(255,255,255,0.02) 1px, transparent 1px);
            background-size: 50px 50px; z-index: -1;
        }
        .dynamic-grid::after { content: ''; position: absolute; inset: 0; background: radial-gradient(circle at 50% 50%, transparent, var(--bg) 80%); }

        .tech-mono { font-family: 'JetBrains Mono', monospace; }
        
        /* Glassmorphism Cards */
        .glass-card { 
            background: rgba(255, 255, 255, 0.02);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 24px;
            transition: all 0.5s cubic-bezier(0.23, 1, 0.32, 1);
            position: relative;
            overflow: hidden;
        }
        .glass-card:hover {
            background: rgba(255, 255, 255, 0.05);
            border-color: var(--glow);
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 30px 60px -15px rgba(0,0,0,0.5), 0 0 20px -5px var(--glow);
        }
        .glass-card::before {
            content: ''; position: absolute; top: 0; left: -100%; width: 100%; height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.05), transparent);
            transition: 0.5s;
        }
        .glass-card:hover::before { left: 100%; }

        /* Level-Up Progress Bar */
        .xp-bar { height: 10px; background: rgba(255,255,255,0.05); border-radius: 20px; overflow: hidden; position: relative; border: 1px solid rgba(255,255,255,0.1); }
        .xp-fill { height: 100%; background: linear-gradient(90deg, #3b82f6, #60a5fa); position: relative; }
        .xp-fill::after { content: ''; position: absolute; inset: 0; background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent); animation: sweep 2s infinite; }

        @keyframes sweep { 0% { transform: translateX(-100%); } 100% { transform: translateX(100%); } }

        .floating { animation: floating 3s ease-in-out infinite; }
        @keyframes floating { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-10px); } }

        .search-input { background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.1); border-radius: 20px; padding: 1rem 3rem; color: white; width: 100%; transition: all 0.3s; }
        .search-input:focus { outline: none; border-color: #3b82f6; background: rgba(255,255,255,0.07); box-shadow: 0 0 20px rgba(59, 130, 246, 0.2); }
    </style>
</head>
<body class="p-6 md:p-16 lg:p-24">
    <div class="dynamic-grid"></div>

    <div class="max-w-7xl mx-auto">
        
        <!-- HEADER Dashboard -->
        <header class="flex flex-col lg:flex-row justify-between items-start gap-12 mb-32">
            <div class="space-y-4">
                <div class="flex items-center gap-3">
                    <span class="px-3 py-1 bg-blue-500/10 text-blue-400 rounded-full text-[10px] font-black tracking-widest uppercase border border-blue-500/20">SYSTEM_READY // PHP_8.5</span>
                    <span class="tech-mono text-[10px] opacity-30">Nexus_Core_v6.0</span>
                </div>
                <h1 class="text-6xl md:text-8xl font-black text-white tracking-tighter leading-none italic uppercase">
                    HELLO!<br><span class="text-blue-500">WORLD_PHP</span>
                </h1>
                <p class="text-lg text-slate-400 max-w-xl font-medium leading-relaxed">
                    Bienvenido a la academia de ingeniería de élite. Supera los <span class="text-white">50 retos</span> para alcanzar el rango de Arquitecto Enterprise.
                </p>
            </div>

            <div class="w-full lg:w-96 space-y-6">
                <div class="relative group">
                    <i class="ph ph-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-slate-500 group-focus-within:text-blue-500 transition-colors"></i>
                    <input type="text" id="projectSearch" placeholder="Buscar reto o tecnología..." class="search-input tech-mono text-xs">
                </div>
                <div class="space-y-2">
                    <div class="flex justify-between items-end px-1">
                        <span class="tech-mono text-[10px] font-bold">Overall_Progress</span>
                        <span class="text-2xl font-black text-white italic"><?= round($progressPercent) ?>%</span>
                    </div>
                    <div class="xp-bar">
                        <div class="xp-fill" style="width: <?= $progressPercent ?>%"></div>
                    </div>
                </div>
            </div>
        </header>

        <!-- MÓDULOS Dashboard -->
        <div id="nodesContainer" class="space-y-32">
            <?php 
            $fasesInNodes = [];
            foreach ($allNodes as $node) {
                $fNum = (int)ceil($node->dayNum / 10);
                $fasesInNodes[$fNum][] = $node;
            }
            ksort($fasesInNodes);

            foreach ($fasesInNodes as $fNum => $nodes): 
                $f = $faseDefinitions[$fNum];
            ?>
                <section class="phase-section" data-fase="<?= $fNum ?>">
                    <div class="flex items-center gap-6 mb-12 border-l-4 pl-8" style="border-color: <?= $f['hex'] ?>">
                        <div class="p-4 rounded-2xl bg-white/5 floating" style="color: <?= $f['hex'] ?>">
                            <i class="ph-fill <?= $f['ph'] ?> text-4xl"></i>
                        </div>
                        <div>
                            <div class="tech-mono text-[10px] font-bold" style="color: <?= $f['hex'] ?>">Módulo_<?= $f['num'] ?></div>
                            <h2 class="text-4xl font-black text-white uppercase italic tracking-tighter"><?= $f['title'] ?></h2>
                            <p class="text-sm text-slate-500 font-medium"><?= $f['desc'] ?></p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        <?php foreach ($nodes as $p): 
                            $isLatest = ($p->dayNum === $latestDay);
                        ?>
                            <a href="<?= $p->path ?>" class="glass-card p-8 group flex flex-col justify-between min-h-[280px]" style="--glow: <?= $p->hex ?>50">
                                <div>
                                    <div class="flex justify-between items-center mb-8">
                                        <div class="tech-mono text-[11px] font-black" style="color: <?= $p->hex ?>"><?= $p->day ?></div>
                                        <div class="w-10 h-10 rounded-xl bg-white/5 flex items-center justify-center group-hover:scale-125 transition-transform duration-500">
                                            <i class="ph-bold <?= $p->icon ?> text-xl" style="color: <?= $p->hex ?>"></i>
                                        </div>
                                    </div>
                                    <h3 class="text-lg font-black text-white mb-3 group-hover:text-blue-400 transition-colors uppercase leading-tight"><?= $p->title ?></h3>
                                    <p class="text-xs leading-relaxed opacity-40 font-medium group-hover:opacity-100 transition-opacity"><?= $p->description ?></p>
                                </div>

                                <div class="mt-8 flex justify-between items-center">
                                    <div class="flex gap-1">
                                        <?php foreach ($p->tags as $tag): ?>
                                            <span class="px-2 py-0.5 rounded-md bg-white/5 text-[7px] font-bold tech-mono text-slate-500"><?= $tag ?></span>
                                        <?php endforeach; ?>
                                    </div>
                                    <div class="w-8 h-8 rounded-full border border-white/10 flex items-center justify-center transform group-hover:translate-x-2 transition-all duration-300">
                                        <i class="ph ph-arrow-right text-xs"></i>
                                    </div>
                                </div>

                                <?php if ($isLatest): ?>
                                    <div class="absolute top-0 right-0 p-1">
                                        <div class="px-2 py-0.5 bg-blue-500 text-[6px] font-black text-white rounded-bl-lg">NEW_RETO</div>
                                    </div>
                                <?php endif; ?>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </section>
            <?php endforeach; ?>
        </div>

        <!-- FOOTER Dashboard -->
        <footer class="mt-48 pt-24 border-t border-white/5 flex flex-col md:flex-row justify-between items-center gap-10">
            <div class="flex items-center gap-6">
                <div class="text-2xl font-black text-white italic">HELLO!<span class="text-blue-500">W_PHP</span></div>
                <div class="h-10 w-px bg-white/10"></div>
                <div class="tech-mono text-[10px] space-y-1">
                    <p class="text-blue-500 font-bold">Architect_Nexus_System</p>
                    <p class="opacity-30">Build_Status: Operational_2026</p>
                </div>
            </div>
            <div class="flex gap-12 text-slate-600 tech-mono text-[8px] font-bold uppercase tracking-[4px]">
                <span>Engineering_Excellence</span>
                <span>By_Choke // Professional_Edition</span>
            </div>
        </footer>

    </div>

    <script>
        document.getElementById('projectSearch').addEventListener('input', (e) => {
            const term = e.target.value.toLowerCase();
            document.querySelectorAll('.glass-card').forEach(node => {
                const title = node.querySelector('h3').innerText.toLowerCase();
                const desc = node.querySelector('p').innerText.toLowerCase();
                const isMatch = title.includes(term) || desc.includes(term);
                node.parentElement.style.display = isMatch ? 'block' : 'none';
            });
            document.querySelectorAll('.phase-section').forEach(section => {
                const visible = Array.from(section.querySelectorAll('.glass-card')).some(n => n.parentElement.style.display !== 'none');
                section.style.display = visible ? 'block' : 'none';
            });
        });
    </script>
</body>
</html>
