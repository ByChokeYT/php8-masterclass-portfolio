<?php
declare(strict_types=1);

/**
 * MASTERCLASS PHP 8.5 - CENTRAL HUB
 * Interfaz Industrial de Alta Fidelidad para el Portfolio Global.
 */

readonly class ProjectNode {
    public function __construct(
        public string $id,
        public string $day,
        public string $title,
        public string $path,
        public string $icon,
        public string $status = 'OPERATIONAL'
    ) {}
}

// Escaneo dinámico de proyectos
$projects = [];
$iterator = new DirectoryIterator(__DIR__);

foreach ($iterator as $fileInfo) {
    if ($fileInfo->isDir() && !$fileInfo->isDot() && str_starts_with($fileInfo->getFilename(), 'dia-')) {
        $folderName = $fileInfo->getFilename();
        
        // Parsing de nombre: dia-1-calculadora-minerales -> Dia 1, Calculadora Minerales
        $parts = explode('-', $folderName);
        $dayNum = $parts[1] ?? '??';
        $rawTitle = implode(' ', array_slice($parts, 2));
        $cleanTitle = ucwords(str_replace('-', ' ', $rawTitle));

        // Detección de ruta index (public/index.php vs index.php)
        $indexPath = "/{$folderName}/index.php";
        if (file_exists(__DIR__ . "/{$folderName}/public/index.php")) {
            $indexPath = "/{$folderName}/public/index.php";
        }

        // Mapeo selectivo de iconos basados en el título o día
        $icon = match(true) {
            str_contains(strtolower($cleanTitle), 'calculadora') => 'ph-calculator',
            str_contains(strtolower($cleanTitle), 'conversor') => 'ph-currency-circle-dollar',
            str_contains(strtolower($cleanTitle), 'gestor') => 'ph-chart-pie-slice',
            str_contains(strtolower($cleanTitle), 'prestamos') => 'ph-bank',
            str_contains(strtolower($cleanTitle), 'reloj') => 'ph-clock',
            str_contains(strtolower($cleanTitle), 'texto') => 'ph-text-aa',
            str_contains(strtolower($cleanTitle), 'email') => 'ph-envelope',
            str_contains(strtolower($cleanTitle), 'cajero') => 'ph-atm',
            str_contains(strtolower($cleanTitle), 'landing') => 'ph-browser',
            str_contains(strtolower($cleanTitle), 'cotizacion') => 'ph-receipt',
            str_contains(strtolower($cleanTitle), 'rsvp') => 'ph-envelope-simple',
            str_contains(strtolower($cleanTitle), 'archivos') => 'ph-upload-simple',
            str_contains(strtolower($cleanTitle), 'video') => 'ph-video-camera',
            default => 'ph-cube'
        };

        $projects[] = new ProjectNode(
            $folderName,
            "DÍA " . str_pad($dayNum, 2, '0', STR_PAD_LEFT),
            $cleanTitle,
            $indexPath,
            $icon
        );
    }
}

// Ordenar por día (numéricamente)
usort($projects, fn($a, $b) => (int)filter_var($a->day, FILTER_SANITIZE_NUMBER_INT) <=> (int)filter_var($b->day, FILTER_SANITIZE_NUMBER_INT));

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP 8.5 Masterclass | Global Hub</title>
    <link rel="icon" type="image/x-icon" href="https://www.php.net/favicon.ico">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;700;900&family=JetBrains+Mono:wght@400;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <style>
        :root {
            --php-blue: #4F5B93;
            --php-blue-glow: rgba(79, 91, 147, 0.4);
            --php-blue-light: #8892BF;
            --bg-deep: #050608;
            --panel-bg: rgba(13, 17, 23, 0.7);
            --accent-emerald: #10b981;
        }

        body {
            background-color: var(--bg-deep);
            color: #94a3b8;
            font-family: 'Outfit', sans-serif;
            height: 100vh;
            overflow: hidden;
            background-image: 
                radial-gradient(circle at 50% 50%, rgba(79, 91, 147, 0.05) 0%, transparent 80%);
        }

        .industrial-grid {
            position: fixed;
            inset: 0;
            z-index: -1;
            background-image: 
                linear-gradient(rgba(136, 146, 191, 0.02) 1px, transparent 1px),
                linear-gradient(90deg, rgba(136, 146, 191, 0.02) 1px, transparent 1px);
            background-size: 20px 20px;
        }

        .hub-container {
            max-width: 1200px;
            height: 100vh;
            margin: 0 auto;
            display: flex;
            flex-direction: column;
            padding: 1.5rem;
        }

        /* Compact Node Card */
        .node-card {
            background: var(--panel-bg);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(136, 146, 191, 0.1);
            border-radius: 8px;
            padding: 0.75rem;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .node-card:hover {
            border-color: var(--php-blue);
            background: rgba(79, 91, 147, 0.1);
            transform: scale(1.02);
            box-shadow: 0 0 20px var(--php-blue-glow);
        }

        .node-card.active::before {
            content: '';
            position: absolute;
            top: 0; left: 0; width: 2px; height: 100%;
            background: var(--php-blue);
        }

        .tech-label {
            font-family: 'JetBrains Mono', monospace;
            font-size: 6px;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            color: var(--php-blue-light);
            opacity: 0.6;
        }

        .node-icon {
            width: 28px;
            height: 28px;
            background: rgba(0,0,0,0.4);
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            border: 1px solid rgba(255,255,255,0.05);
            transition: all 0.3s ease;
        }

        .node-card:hover .node-icon {
            background: var(--php-blue);
            color: white;
            border-color: var(--php-blue-light);
        }

        /* Header Compact */
        .portal-header {
            display: flex;
            justify-content: space-between;
            items-center mb-6 border-b border-white/5 pb-4;
        }

        .text-header {
            font-size: 1.5rem;
            font-weight: 900;
            letter-spacing: -0.05em;
            color: white;
            line-height: 1;
        }

        /* Scrollable Grid */
        .nodes-view {
            flex: 1;
            overflow-y: auto;
            padding-right: 0.5rem;
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
            gap: 0.75rem;
            scrollbar-width: thin;
            scrollbar-color: var(--php-blue) transparent;
        }

        .nodes-view::-webkit-scrollbar { width: 2px; }
        .nodes-view::-webkit-scrollbar-thumb { background: var(--php-blue); }

        .btn-launch {
            font-size: 7px;
            font-weight: 800;
            text-transform: uppercase;
            color: var(--php-blue-light);
            display: flex;
            align-items: center;
            gap: 3px;
            margin-top: auto;
            opacity: 0.5;
            transition: all 0.3s ease;
        }

        .node-card:hover .btn-launch {
            opacity: 1;
            color: white;
        }

        @keyframes pulse-dot {
            0%, 100% { transform: scale(1); opacity: 1; }
            50% { transform: scale(1.5); opacity: 0.5; }
        }
        .status-dot {
            width: 3px; height: 3px;
            background: var(--accent-emerald);
            border-radius: 50%;
            animation: pulse-dot 2s infinite;
        }
    </style>
</head>
<body>
    <div class="industrial-grid"></div>

    <div class="hub-container">
        <header class="flex justify-between items-end mb-8 border-b border-white/5 pb-4">
            <div>
                <div class="flex items-center gap-2 mb-1">
                    <span class="status-dot"></span>
                    <span class="tech-label">SYSTEM_CORE_MASTERCLASS // v8.5</span>
                </div>
                <h1 class="text-header uppercase">Terminal_<span style="color: var(--php-blue-light)">Hub</span></h1>
            </div>
            <div class="text-right">
                <span class="tech-label">LOADED_PROJECTS</span><br>
                <span class="text-xl font-black font-mono text-white"><?= str_pad((string)count($projects), 2, '0', STR_PAD_LEFT) ?></span>
            </div>
        </header>

        <main class="nodes-view">
            <?php foreach ($projects as $project): ?>
                <a href="<?= $project->path ?>" class="node-card active group">
                    <div class="flex justify-between items-start">
                        <div class="node-icon">
                            <i class="ph <?= $project->icon ?>"></i>
                        </div>
                        <span class="tech-label opacity-40"><?= $project->day ?></span>
                    </div>
                    
                    <div>
                        <h2 class="text-[10px] font-bold text-white leading-tight mb-0.5"><?= $project->title ?></h2>
                        <span class="text-[6px] font-mono text-slate-500 uppercase tracking-widest">Status: <?= $project->status ?></span>
                    </div>

                    <div class="btn-launch">
                        ACCESS_NODE <i class="ph ph-arrow-right"></i>
                    </div>
                </a>
            <?php endforeach; ?>
        </main>

        <footer class="mt-6 flex justify-between items-center border-t border-white/5 pt-4 opacity-40">
            <span class="tech-label">BY_CHOKE_RESOURCES // PORTFOLIO_LOCKDOWN</span>
            <div class="flex gap-4">
                <span class="tech-label">SYST_0x15</span>
                <span class="tech-label">SYNC_OK</span>
            </div>
        </footer>
    </div>
</body>
</html>
