<?php
declare(strict_types=1);

require_once __DIR__ . '/../src/Classes/Video.php';
use App\Classes\Video;

// Dataset de Nodos de Video (Simulado)
$videoNodes = [
    new Video(
        'node-01',
        'Núcleo de Datos L-01',
        'https://assets.mixkit.co/videos/preview/mixkit-futuristic-computer-interface-9625-large.mp4',
        'https://images.unsplash.com/photo-1550745165-9bc0b252726f?q=80&w=300&h=200&fit=crop',
        '00:24',
        ['RES' => '4K', 'FPS' => '60', 'CODEC' => 'H.265', 'BIT' => '45mbps']
    ),
    new Video(
        'node-02',
        'Sincronización de Circuito',
        'https://assets.mixkit.co/videos/preview/mixkit-circuit-board-interface-animation-1152-large.mp4',
        'https://images.unsplash.com/photo-1518770660439-4636190af475?q=80&w=300&h=200&fit=crop',
        '00:18',
        ['RES' => '1080p', 'FPS' => '30', 'CODEC' => 'H.264', 'BIT' => '22mbps']
    ),
    new Video(
        'node-03',
        'Algoritmo Cifrado',
        'https://assets.mixkit.co/videos/preview/mixkit-cyber-security-code-animation-9626-large.mp4',
        'https://images.unsplash.com/photo-1531297484001-80022131f5a1?q=80&w=300&h=200&fit=crop',
        '00:30',
        ['RES' => '720p', 'FPS' => '24', 'CODEC' => 'AV1', 'BIT' => '8mbps']
    ),
    new Video(
        'node-04',
        'Monitoreo de Sistema',
        'https://assets.mixkit.co/videos/preview/mixkit-scanning-a-human-body-on-a-futuristic-screen-9624-large.mp4',
        'https://images.unsplash.com/photo-1451187580459-43490279c0fa?q=80&w=300&h=200&fit=crop',
        '00:15',
        ['RES' => '1080p', 'FPS' => '60', 'CODEC' => 'VP9', 'BIT' => '18mbps']
    ),
    new Video(
        'node-05',
        'Frecuencia Externa I',
        'https://www.youtube.com/embed/c0m6om_S5pE',
        'https://images.unsplash.com/photo-1498050108023-c5249f4df085?q=80&w=300&h=200&fit=crop',
        '04:20',
        ['RES' => '4K', 'FPS' => '60', 'CODEC' => 'YT_HDR', 'BIT' => 'VBR']
    ),
    new Video(
        'node-06',
        'Frecuencia Externa II',
        'https://www.youtube.com/embed/S6f-96BshhE',
        'https://images.unsplash.com/photo-1511671782779-c97d3d27a1d4?q=80&w=300&h=200&fit=crop',
        '03:45',
        ['RES' => '1080p', 'FPS' => '60', 'CODEC' => 'YT_STREAM', 'BIT' => '24mbps']
    ),
    new Video(
        'node-07',
        'Frecuencia Externa III',
        'https://www.youtube.com/embed/tO01J-M3g0U',
        'https://images.unsplash.com/photo-1470225620780-dba8ba36b745?q=80&w=300&h=200&fit=crop',
        '05:12',
        ['RES' => '4K', 'FPS' => '30', 'CODEC' => 'YT_CORE', 'BIT' => '18mbps']
    ),
    new Video(
        'node-08',
        'Frecuencia Externa IV',
        'https://www.youtube.com/embed/m7CHeU8Dk20',
        'https://images.unsplash.com/photo-1514525253344-a812da99a46c?q=80&w=300&h=200&fit=crop',
        '04:50',
        ['RES' => '1080p', 'FPS' => '24', 'CODEC' => 'YT_STRM', 'BIT' => '15mbps']
    )
];

// Enrutamiento vía PHP 8.5 Match
$currentId = $_GET['id'] ?? 'node-01';
$currentVideo = match($currentId) {
    'node-01' => $videoNodes[0],
    'node-02' => $videoNodes[1],
    'node-03' => $videoNodes[2],
    'node-04' => $videoNodes[3],
    'node-05' => $videoNodes[4],
    'node-06' => $videoNodes[5],
    'node-07' => $videoNodes[6],
    'node-08' => $videoNodes[7],
    default => $videoNodes[0]
};

$isYouTube = str_contains($currentVideo->url, 'youtube.com');
$externalUrl = $isYouTube ? "https://www.youtube.com/watch?v=" . basename($currentVideo->url) : $currentVideo->url;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cinema Node | Industrial Previewer</title>
    <link rel="icon" type="image/x-icon" href="https://www.php.net/favicon.ico">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;700;900&family=JetBrains+Mono:wght@400;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <style>
        :root {
            --php-blue: #4F5B93;
            --php-blue-glow: rgba(79, 91, 147, 0.3);
            --php-blue-light: #8892BF;
            --bg-deep: #050608;
            --panel-bg: rgba(13, 17, 23, 0.7);
            --accent-emerald: #10b981;
        }

        body {
            background-color: var(--bg-deep);
            color: #94a3b8;
            font-family: 'Outfit', sans-serif;
            overflow: hidden;
            height: 100vh;
        }

        /* High-Definition Grid */
        .industrial-bg {
            position: fixed;
            inset: 0;
            z-index: 0;
            background: 
                radial-gradient(circle at 0% 0%, rgba(79, 91, 147, 0.15) 0%, transparent 50%),
                radial-gradient(circle at 100% 100%, rgba(16, 185, 129, 0.05) 0%, transparent 50%);
        }

        .grid-pattern {
            position: absolute;
            inset: 0;
            background-image: 
                linear-gradient(rgba(136, 146, 191, 0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(136, 146, 191, 0.03) 1px, transparent 1px);
            background-size: 40px 40px;
        }

        .fine-grid {
            position: absolute;
            inset: 0;
            background-image: 
                linear-gradient(rgba(136, 146, 191, 0.01) 1px, transparent 1px),
                linear-gradient(90deg, rgba(136, 146, 191, 0.01) 1px, transparent 1px);
            background-size: 8px 8px;
        }

        /* Glassmorphism Pro */
        .glass-panel {
            background: var(--panel-bg);
            backdrop-filter: blur(24px);
            border: 1px solid rgba(136, 146, 191, 0.1);
            box-shadow: 
                0 4px 24px -1px rgba(0, 0, 0, 0.5),
                inset 0 1px 1px rgba(255, 255, 255, 0.02);
            position: relative;
        }

        .industrial-border {
            border-left: 2px solid var(--php-blue);
            padding-left: 1rem;
            position: relative;
        }

        .industrial-border::before {
            content: '';
            position: absolute;
            top: 0; left: -2px; width: 2px; height: 15%;
            background: white; opacity: 0.5;
        }

        /* Cinema Node Visuals */
        .video-container {
            position: relative;
            background: #000;
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid rgba(136, 146, 191, 0.15);
            box-shadow: 0 0 60px -20px var(--php-blue-glow);
        }

        .video-overlay {
            position: absolute;
            inset: 0;
            pointer-events: none;
            background: radial-gradient(circle at center, transparent, rgba(0,0,0,0.4));
            box-shadow: inset 0 0 100px rgba(0,0,0,0.8);
        }

        .btn-node {
            transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
            border: 1px solid transparent;
            position: relative;
        }

        .btn-node:hover {
            background: rgba(255, 255, 255, 0.02);
            transform: scale(1.02);
        }

        .btn-node.active {
            background: rgba(79, 91, 147, 0.1);
            border-color: rgba(79, 91, 147, 0.4);
            box-shadow: 0 0 20px rgba(79, 91, 147, 0.1);
        }

        .btn-node.active::after {
            content: '';
            position: absolute;
            right: 8px; top: 50%; transform: translateY(-50%);
            width: 3px; height: 3px; background: var(--accent-emerald);
            border-radius: 50%; box-shadow: 0 0 8px var(--accent-emerald);
        }

        /* Typography */
        .text-huge {
            font-size: clamp(1.8rem, 4vw, 2.5rem);
            line-height: 0.9;
            font-weight: 900;
            letter-spacing: -0.05em;
            text-transform: uppercase;
        }

        .tech-label {
            font-family: 'JetBrains Mono', monospace;
            font-size: 7px;
            font-weight: 700;
            letter-spacing: 0.25em;
            color: var(--php-blue-light);
            opacity: 0.6;
        }

        /* Interactive Elements */
        .hud-corner {
            position: absolute;
            width: 6px; height: 6px;
            border-color: var(--php-blue);
            opacity: 0.4;
        }

        .sidebar-scroll {
            overflow-y: auto;
            scrollbar-width: thin;
            scrollbar-color: var(--php-blue) transparent;
        }
        .sidebar-scroll::-webkit-scrollbar { width: 2px; }
        .sidebar-scroll::-webkit-scrollbar-thumb { background: var(--php-blue); }

        @keyframes pulse-slow {
            0%, 100% { opacity: 0.3; }
            50% { opacity: 0.7; }
        }
        .animate-pulse-slow { animation: pulse-slow 3s infinite; }

        .btn-external {
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.1);
            transition: all 0.3s ease;
        }

        .btn-external:hover {
            background: rgba(255,255,255,0.1);
            border-color: var(--php-blue);
            color: white;
        }
    </style>
</head>
<body class="flex items-center justify-center p-2">
<?php
$dayLabel = 'DÍA 15';
$dayTitle = 'Video Previewer';
$prevUrl  = '';
$nextUrl  = '';
require_once __DIR__ . '/../../../_nav.php';
?>
    <div class="industrial-bg">
        <div class="grid-pattern"></div>
        <div class="fine-grid"></div>
    </div>

    <main class="relative z-10 w-full max-w-5xl h-screen flex flex-col items-center justify-center p-2">
        <div class="w-full grid lg:grid-cols-12 gap-3 items-stretch h-[70vh]">
            
            <!-- Sidebar: Video List -->
            <div class="lg:col-span-3 flex flex-col gap-2">
                <div class="industrial-border">
                    <div class="flex items-center gap-1.5 mb-1">
                        <span class="w-1 h-1 rounded-full bg-emerald-500 animate-pulse-slow"></span>
                        <span class="tech-label uppercase">System_Active // Node_v15</span>
                    </div>
                    <h1 class="text-huge text-white">Cinema<br><span style="color: var(--php-blue-light)">Node</span></h1>
                </div>

                <div class="glass-panel rounded-lg flex-1 flex flex-col overflow-hidden">
                    <div class="p-2.5 border-b border-white/5 bg-black/40 flex justify-between items-center">
                        <span class="tech-label">STORAGE_NODES</span>
                        <i class="ph ph-list text-[10px] opacity-40"></i>
                    </div>

                    <div class="sidebar-scroll flex-1 p-1.5 flex flex-col gap-1">
                        <?php foreach ($videoNodes as $node): ?>
                            <a href="?id=<?= $node->id ?>" class="btn-node group p-1.5 rounded-md flex items-center gap-2 <?= $currentId === $node->id ? 'active' : '' ?>">
                                <div class="w-10 h-7 rounded overflow-hidden bg-black flex-shrink-0 border border-white/5 group-hover:border-white/10 transition-colors">
                                    <img src="<?= $node->thumbnail ?>" class="w-full h-full object-cover opacity-20 group-hover:opacity-100 transition-opacity" alt="">
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h3 class="text-[8px] font-bold text-white/90 truncate group-hover:text-white"><?= $node->title ?></h3>
                                    <p class="text-[6px] font-mono text-slate-500 tracking-wider uppercase"><?= $node->duration ?> // FLX_RT</p>
                                </div>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <!-- Main Player -->
            <div class="lg:col-span-9 flex flex-col gap-3">
                <div class="video-container flex-1 relative group">
                    <!-- HUD Corners -->
                    <div class="hud-corner top-4 left-4 border-t border-l"></div>
                    <div class="hud-corner top-4 right-4 border-t border-r"></div>
                    <div class="hud-corner bottom-4 left-4 border-b border-l"></div>
                    <div class="hud-corner bottom-4 right-4 border-b border-r"></div>

                    <?php if ($isYouTube): ?>
                        <iframe class="w-full h-full" src="<?= $currentVideo->url ?>?autoplay=1&mute=1&modestbranding=1&controls=0&showinfo=0&rel=0" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    <?php else: ?>
                        <video id="mainPlayer" class="w-full h-full object-cover" autoplay controls loop src="<?= $currentVideo->url ?>"></video>
                    <?php endif; ?>
                    
                    <div class="video-overlay"></div>

                    <!-- Tech Info Overlay -->
                    <div class="absolute top-6 left-6 flex flex-col gap-1 opacity-0 group-hover:opacity-100 transition-all duration-500">
                        <div class="flex items-center gap-2">
                            <span class="px-2 py-0.5 bg-black/80 rounded text-[6px] font-mono text-white border border-white/10">ID: <?= $currentVideo->id ?></span>
                            <span class="px-2 py-0.5 bg-[#4F5B93]/40 rounded text-[6px] font-mono text-white border border-[#4F5B93]/20">LIVE_DATA_FEED</span>
                        </div>
                    </div>
                </div>

                <!-- Info Panel -->
                <div class="grid grid-cols-4 gap-3 h-16">
                    <div class="col-span-2 glass-panel rounded-lg px-4 flex flex-col justify-center overflow-hidden border-l-2 border-l-[#4F5B93]">
                        <div class="flex justify-between items-center mb-0.5">
                            <div class="tech-label uppercase">Playback_Metadata</div>
                            <?php if ($isYouTube): ?>
                                <a href="<?= $externalUrl ?>" target="_blank" class="btn-external px-2 py-0.5 rounded text-[5px] font-bold uppercase flex items-center gap-1">
                                    <i class="ph ph-arrow-square-out"></i> Abrir en YouTube
                                </a>
                            <?php endif; ?>
                        </div>
                        <h2 class="text-[10px] font-black uppercase text-white truncate"><?= $currentVideo->title ?></h2>
                        <div class="flex items-center gap-3 text-[7px] font-mono text-[#8892BF] mt-0.5">
                            <span class="flex items-center gap-1 opacity-60"><i class="ph ph-clock text-[9px]"></i> <?= $currentVideo->duration ?></span>
                            <span class="flex items-center gap-1 opacity-60 uppercase"><i class="ph ph-cpu text-[9px]"></i> <?= $currentVideo->techSpecs['CODEC'] ?></span>
                        </div>
                    </div>
                    <?php foreach ($currentVideo->techSpecs as $key => $val): ?>
                        <?php if ($key !== 'CODEC'): ?>
                            <div class="glass-panel rounded-lg p-1.5 flex flex-col justify-center items-center hover:bg-white/5 transition-colors group">
                                <span class="tech-label mb-0.5 group-hover:text-white transition-colors"><?= $key ?></span>
                                <span class="text-[9px] font-black text-white/90 group-hover:text-white"><?= $val ?></span>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </main>

    <footer class="fixed bottom-3 left-0 w-full px-6 flex justify-between items-center opacity-40 pointer-events-none">
        <div class="flex items-center gap-2">
             <div class="w-1 h-3 bg-[#4F5B93]"></div>
             <span class="text-[7px] font-black uppercase tracking-[0.4em] text-white">Cinema_Protocol</span>
        </div>
        <div class="flex items-center gap-4">
            <span class="text-[7px] font-mono tracking-tighter">SEC_ENCRYPTION: AES-2026 // NODE_STATUS: SYNCED</span>
            <div class="flex gap-0.5">
                <div class="w-1 h-1 bg-white opacity-20"></div>
                <div class="w-1 h-1 bg-white opacity-40"></div>
                <div class="w-1 h-1 bg-white opacity-60"></div>
            </div>
        </div>
    </footer>
</body>
</html>
