<?php
declare(strict_types=1);

/**
 * PHP 8.5 MASTERCLASS - PROFESSOR EDITION v9.0
 * Diseñado para inspirar maestría técnica y elegancia arquitectónica.
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
        public array $skills = []
    ) {}
}

$projectMetadata = [
    1 => ['desc' => 'Arquitectura de consola con Enums e Inmutabilidad.', 'skills' => ['Logic', 'Enums', 'CLI']],
    2 => ['desc' => 'Precisión aritmética y manejo de tipos estrictos.', 'skills' => ['Types', 'Math']],
    3 => ['desc' => 'Algoritmos de búsqueda y procesamiento de streams.', 'skills' => ['Algorithms', 'Streams']],
    4 => ['desc' => 'Lógica financiera y proyecciones dinámicas.', 'skills' => ['Finance', 'Logic']],
    5 => ['desc' => 'Parsing de datos y serialización industrial.', 'skills' => ['JSON/CSV', 'Data']],
    6 => ['desc' => 'Generación de tokens seguros y claves.', 'skills' => ['Security', 'Tokens']],
    7 => ['desc' => 'Análisis semántico de textos.', 'skills' => ['Strings', 'Parsing']],
    8 => ['desc' => 'Estructuras de decisión y bucles.', 'skills' => ['Loops', 'Control']],
    9 => ['desc' => 'Limpieza de datos con Regex.', 'skills' => ['Regex', 'Validation']],
    10 => ['desc' => 'Simulación de flujos de caja.', 'skills' => ['States', 'Math']],
    11 => ['desc' => 'Interfaces reactivas con PHP y Tailwind CSS.', 'skills' => ['UI/UX', 'Tailwind']],
    12 => ['desc' => 'Gestión de formularios en tiempo real.', 'skills' => ['POST/GET', 'Forms']],
    13 => ['desc' => 'Confirmaciones seguras y validación.', 'skills' => ['Validation', 'Logic']],
    14 => ['desc' => 'Manejo seguro de archivos y carga.', 'skills' => ['File System', 'Security']],
    15 => ['desc' => 'Galería dinámica de contenidos.', 'skills' => ['Dynamic Content']],
    16 => ['desc' => 'Manejo de sesiones y accesos.', 'skills' => ['Sessions', 'Auth']],
    17 => ['desc' => 'Dashboard para cálculos masivos.', 'skills' => ['Dashboard', 'Math']],
    18 => ['desc' => 'Conversión de Markdown a HTML.', 'skills' => ['Markdown', 'Parser']],
    19 => ['desc' => 'Procesamiento de assets mediante GD Library.', 'skills' => ['Graphics', 'GD']],
    20 => ['desc' => 'Persistencia manual en archivos .txt.', 'skills' => ['Text DB', 'AJAX']],
    21 => ['desc' => 'Arquitecturas inmutables modernas.', 'skills' => ['Readonly', 'POO']],
    22 => ['desc' => 'Arquitectura de persistencia con PDO y SQLite.', 'skills' => ['SQL', 'PDO']],
    23 => ['desc' => 'Transacciones industriales y tablas.', 'skills' => ['SQL', 'Transactions']],
    24 => ['desc' => 'Hashing y seguridad de contraseñas.', 'skills' => ['Hashing', 'Security']],
    25 => ['desc' => 'Metadatos y persistencia visual.', 'skills' => ['QR Codes', 'Data']],
    26 => ['desc' => 'Interacción pública con bases de datos.', 'skills' => ['SQL', 'Interaction']],
    27 => ['desc' => 'Renderizado dinámico de servicios.', 'skills' => ['SQL', 'Frontend']],
    28 => ['desc' => 'Filtros avanzados y búsquedas SQL.', 'skills' => ['SQL Search', 'Like']],
    29 => ['desc' => 'Reportes financieros industriales.', 'skills' => ['Reports', 'Finance']],
    30 => ['desc' => 'Métricas técnicas de administración.', 'skills' => ['Admin', 'Stats']],
    31 => ['desc' => 'Gestión de dependencias modernas con Composer.', 'skills' => ['Composer', 'Packages']],
    32 => ['desc' => 'Extracción de datos mediante Scraping.', 'skills' => ['Web Scraping', 'Data']],
    33 => ['desc' => 'Consumo de APIs REST en tiempo real.', 'skills' => ['APIs', 'JSON']],
    34 => ['desc' => 'Generación de documentos PDF de alta fidelidad.', 'skills' => ['PDF', 'Dompdf']],
    35 => ['desc' => 'Generación masiva de reportes Excel.', 'skills' => ['Excel', 'CSV']],
    37 => ['desc' => 'Gestión de redirecciones HTTP.', 'skills' => ['HTTP Status', 'Routing']],
    38 => ['desc' => 'Autenticación y exposición de API.', 'skills' => ['Auth', 'API REST']],
    39 => ['desc' => 'Consumo de feeds XML y parsing avanzado.', 'skills' => ['XML', 'Parsing']]
];

$faseDefinitions = [
    1 => ['title' => 'Módulo 01: Fundamentos de Ingeniería', 'hex' => '#10b981', 'ph' => 'ph-terminal-window'],
    2 => ['title' => 'Módulo 02: Arquitectura Web & UI', 'hex' => '#06b6d4', 'ph' => 'ph-palette'],
    3 => ['title' => 'Módulo 03: Persistencia & SQL Pro', 'hex' => '#f59e0b', 'ph' => 'ph-database'],
    4 => ['title' => 'Módulo 04: Ecosistema Enterprise', 'hex' => '#f43f5e', 'ph' => 'ph-cloud-arrow-up'],
    5 => ['title' => 'Módulo 05: Expert Deploy & Sec', 'hex' => '#8b5cf6', 'ph' => 'ph-shield-check']
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
        $hex = $faseDefinitions[$faseNum]['hex'] ?? '#4F5B93';

        $path = "/{$folderName}/index.php";
        if (file_exists(__DIR__ . "/{$folderName}/public/index.php")) {
            $path = "/{$folderName}/public/index.php";
        }

        $meta = $projectMetadata[$dayNum] ?? ['desc' => 'Exploración de conceptos avanzados de PHP 8.5...', 'skills' => ['PHP Pro']];

        $allNodes[] = new ProjectNode(
            $folderName, 
            "D" . str_pad((string)$dayNum, 2, '0', STR_PAD_LEFT), 
            $dayNum, 
            $cleanTitle, 
            $meta['desc'], 
            $path, 
            match(true) { 
                $dayNum <= 10 => 'ph-terminal', 
                $dayNum <= 20 => 'ph-browser', 
                $dayNum <= 30 => 'ph-database', 
                default => 'ph-lightning' 
            },
            $hex,
            $meta['skills']
        );
    }
}
usort($allNodes, fn($a, $b) => $a->dayNum <=> $b->dayNum);
$progressPercent = (count($allNodes) / 50) * 100;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Academia PHP // Professional Edition</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <style>
        :root { --bg: #0b0e14; --php-p: #4F5B93; --php-l: #8892BF; }
        body { background: var(--bg); color: #94a3b8; font-family: 'Plus Jakarta Sans', sans-serif; overflow-x: hidden; }
        
        /* Grid de Ingeniería */
        .grid-bg {
            position: fixed; inset: 0;
            background-image: radial-gradient(rgba(79, 91, 147, 0.15) 1px, transparent 1px);
            background-size: 30px 30px; z-index: -1;
        }
        .grid-bg::after {
            content: ''; position: absolute; inset: 0;
            background: radial-gradient(circle at 50% 50%, transparent, var(--bg) 90%);
        }

        /* Tarjetas Professional Edition */
        .pro-card {
            background: linear-gradient(145deg, rgba(255,255,255,0.03) 0%, rgba(255,255,255,0.01) 100%);
            border: 1px solid rgba(255,255,255,0.05);
            border-radius: 28px;
            transition: all 0.5s cubic-bezier(0.23, 1, 0.32, 1);
            position: relative;
        }
        .pro-card:hover {
            transform: translateY(-10px);
            border-color: var(--accent);
            background: linear-gradient(145deg, rgba(255,255,255,0.05) 0%, rgba(255,255,255,0.02) 100%);
            box-shadow: 0 40px 80px -20px rgba(0,0,0,0.6), 0 0 30px -10px var(--accent);
        }

        .icon-box {
            width: 52px; height: 52px;
            background: rgba(255,255,255,0.03);
            border: 1px solid rgba(255,255,255,0.05);
            border-radius: 18px;
            display: flex; align-items: center; justify-content: center;
            box-shadow: inset 0 2px 4px rgba(0,0,0,0.3);
            transition: all 0.3s;
        }
        .pro-card:hover .icon-box { transform: scale(1.15) rotate(5deg); background: rgba(255,255,255,0.08); }

        .skill-tag {
            background: rgba(255,255,255,0.03);
            border: 1px solid rgba(255,255,255,0.05);
            color: #64748b; font-size: 9px; font-weight: 700;
            padding: 4px 10px; border-radius: 8px; text-transform: uppercase;
        }
        
        .progress-rail { height: 6px; background: rgba(255,255,255,0.03); border-radius: 10px; overflow: hidden; border: 1px solid rgba(255,255,255,0.05); }
        .progress-thumb { height: 100%; background: linear-gradient(90deg, #4f5b93, #8892bf); position: relative; }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .stagger-load { animation: fadeInUp 0.8s cubic-bezier(0.23, 1, 0.32, 1) forwards; opacity: 0; }
    </style>
</head>
<body class="p-6 md:p-20">
    <div class="grid-bg"></div>

    <div class="max-w-7xl mx-auto">
        
        <!-- HEADER -->
        <header class="flex flex-col lg:flex-row justify-between items-start gap-20 mb-40 stagger-load" style="animation-delay: 0.1s">
            <div class="space-y-8">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-[#4F5B93] rounded-2xl flex items-center justify-center shadow-2xl">
                        <i class="ph-fill ph-elephant text-white text-3xl"></i>
                    </div>
                    <div class="h-8 w-px bg-white/10"></div>
                    <span class="tech-mono text-[10px] font-bold text-[#8892BF] uppercase tracking-[0.4em]">Academic_Core_v9.0</span>
                </div>
                <h1 class="text-7xl md:text-9xl font-black text-white tracking-tighter leading-none uppercase italic">
                    PHP_MASTER<br><span class="text-[#8892BF]">ACADEMY</span>
                </h1>
                <p class="text-xl text-slate-500 max-w-xl font-medium leading-relaxed">
                    Un viaje pedagógico diseñado para transformar la teoría en ingeniería de software industrial de alto rendimiento.
                </p>
            </div>

            <div class="w-full lg:w-96 p-10 bg-white/[0.02] border border-white/5 rounded-[2.5rem] backdrop-blur-xl">
                <div class="flex justify-between items-end mb-6">
                    <div class="space-y-1">
                        <span class="text-[10px] font-black text-slate-600 uppercase tracking-widest">Global_Status</span>
                        <div class="text-4xl font-black text-white italic"><?= round($progressPercent) ?>%</div>
                    </div>
                </div>
                <div class="progress-rail mb-6">
                    <div class="progress-thumb" style="width: <?= $progressPercent ?>%"></div>
                </div>
                <div class="text-[9px] text-slate-600 font-bold uppercase text-center tracking-[0.2em]">
                    <?= count($allNodes) ?> / 50 Desafíos Superados
                </div>
            </div>
        </header>

        <!-- MÓDULOS -->
        <div class="space-y-48">
            <?php 
            $fasesInNodes = [];
            foreach ($allNodes as $node) {
                $fNum = (int)ceil($node->dayNum / 10);
                $fasesInNodes[$fNum][] = $node;
            }
            ksort($fasesInNodes);

            $delay = 0.2;
            foreach ($fasesInNodes as $fNum => $nodes): 
                $f = $faseDefinitions[$fNum];
            ?>
                <section class="stagger-load" style="animation-delay: <?= $delay ?>s">
                    <div class="flex items-center gap-10 mb-20">
                        <div class="w-24 h-24 rounded-[2.5rem] flex items-center justify-center text-white shadow-2xl border-2 border-white/5" style="background: <?= $f['hex'] ?>">
                            <i class="ph-bold <?= $f['ph'] ?> text-4xl"></i>
                        </div>
                        <div>
                            <span class="tech-mono text-[10px] font-black opacity-30 uppercase tracking-[0.4em]">Módulo_0<?= $fNum ?></span>
                            <h2 class="text-5xl font-black text-white uppercase italic tracking-tighter"><?= $f['title'] ?></h2>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-12">
                        <?php foreach ($nodes as $p): ?>
                            <a href="<?= $p->path ?>" class="pro-card p-12 flex flex-col justify-between min-h-[380px]" style="--accent: <?= $p->hex ?>">
                                <div>
                                    <div class="flex justify-between items-start mb-12">
                                        <div class="space-y-1">
                                            <div class="text-[10px] font-black text-slate-600 tech-mono uppercase tracking-widest"><?= $p->day ?></div>
                                            <div class="h-1 w-8 rounded-full" style="background: <?= $p->hex ?>50"></div>
                                        </div>
                                        <div class="icon-box">
                                            <i class="ph-bold <?= $p->icon ?> text-2xl" style="color: <?= $p->hex ?>"></i>
                                        </div>
                                    </div>
                                    <h3 class="text-2xl font-black text-white mb-4 uppercase tracking-tight leading-none group-hover:text-blue-400"><?= $p->title ?></h3>
                                    <p class="text-sm text-slate-500 leading-relaxed font-medium mb-10"><?= $p->description ?></p>
                                </div>

                                <div class="flex flex-wrap gap-2 pt-8 border-t border-white/5">
                                    <?php foreach ($p->skills as $skill): ?>
                                        <span class="skill-tag"><?= $skill ?></span>
                                    <?php endforeach; ?>
                                </div>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </section>
            <?php 
                $delay += 0.1;
            endforeach; ?>
        </div>

        <footer class="mt-60 pt-24 border-t border-white/5 flex flex-col md:flex-row justify-between items-center gap-12">
            <div class="flex items-center gap-8">
                <div class="text-3xl font-black text-white italic tracking-tighter">PHOENIX<span class="text-[#8892BF]">_ACADEMY</span></div>
                <div class="h-10 w-px bg-white/10"></div>
                <div class="tech-mono text-[10px] font-bold text-slate-600 uppercase tracking-[0.4em]">
                    Engineering_Excellence_2026
                </div>
            </div>
            <div class="flex gap-12 text-slate-700 text-[10px] font-black uppercase tracking-[0.6em]">
                <span>By_Choke // Professional_Professor_Runtime</span>
            </div>
        </footer>

    </div>
</body>
</html>
