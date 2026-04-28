<?php
declare(strict_types=1);

require_once __DIR__ . '/../src/Classes/FileRecord.php';
require_once __DIR__ . '/../src/Services/SecurityService.php';

use App\Classes\FileRecord;
use App\Services\SecurityService;

$uploadDir = __DIR__ . '/uploads';
$manifestFile = $uploadDir . '/manifest.json';
$successMessage = null;
$errorMessage = null;

$security = new SecurityService();

// Logic for processing the upload
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['attachment'])) {
    try {
        $record = $security->processUpload($_FILES['attachment'], $uploadDir);
        
        // Save to manifest
        $manifest = file_exists($manifestFile) ? json_decode(file_get_contents($manifestFile), true) : [];
        $manifest[] = $record->toArray();
        file_put_contents($manifestFile, json_encode($manifest, JSON_PRETTY_PRINT));
        
        $successMessage = "Archivo " . htmlspecialchars($record->originalName) . " sincronizado con el nodo.";
    } catch (Exception $e) {
        $errorMessage = $e->getMessage();
    }
}

// Load current manifest
$manifest = file_exists($manifestFile) ? json_decode(file_get_contents($manifestFile), true) : [];
$totalFiles = count($manifest);
$totalSize = array_reduce($manifest, fn($carry, $item) => $carry + $item['size'], 0);
$formattedTotalSize = round($totalSize / 1048576, 2) . ' MB';

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Terminal | PHP 8.5 Security</title>
    <link rel="icon" type="image/x-icon" href="https://www.php.net/favicon.ico">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;700;900&family=JetBrains+Mono:wght@400;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <style>
        :root {
            --php-blue: #4F5B93;
            --php-blue-glow: rgba(79, 91, 147, 0.2);
            --php-blue-light: #8892BF;
            --bg-deep: #06070a;
            --panel-bg: rgba(30, 34, 45, 0.6);
        }

        body {
            background-color: var(--bg-deep);
            color: #d1d5db;
            font-family: 'Outfit', sans-serif;
            overflow: hidden;
            height: 100vh;
        }

        /* Typography Refined */
        .text-huge {
            font-size: clamp(2.5rem, 4vw, 3.5rem);
            line-height: 1;
            font-weight: 900;
            letter-spacing: -0.04em;
        }

        .industrial-bg {
            position: fixed;
            inset: 0;
            z-index: 0;
            background-image: 
                radial-gradient(circle at 0% 0%, rgba(79, 91, 147, 0.1) 0%, transparent 40%),
                radial-gradient(circle at 100% 100%, rgba(136, 146, 191, 0.05) 0%, transparent 40%);
        }

        .grid-pattern {
            position: absolute;
            inset: 0;
            background-image: 
                linear-gradient(rgba(136, 146, 191, 0.05) 1px, transparent 1px),
                linear-gradient(90deg, rgba(136, 146, 191, 0.05) 1px, transparent 1px);
            background-size: 50px 50px;
            mask-image: radial-gradient(circle at center, black, transparent 80%);
        }

        /* Glass Panel - Ultra Compact */
        .glass-panel {
            background: var(--panel-bg);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(136, 146, 191, 0.08);
            box-shadow: 0 20px 60px -10px rgba(0, 0, 0, 0.7);
            position: relative;
        }

        .industrial-border {
            border-left: 3px solid var(--php-blue);
            padding-left: 1.25rem;
        }

        /* Dropzone Styling - Precise */
        .dropzone-container {
            border: 1px dashed rgba(136, 146, 191, 0.15);
            background: rgba(6, 7, 10, 0.4);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .dropzone-container:hover, .dropzone-container.drag-over {
            border-color: var(--php-blue);
            background: rgba(79, 91, 147, 0.04);
            box-shadow: 0 0 25px var(--php-blue-glow);
        }

        .scan-line {
            position: absolute;
            left: 0;
            width: 100%;
            height: 1px;
            background: var(--php-blue);
            opacity: 0.15;
            animation: scan 3s linear infinite;
        }

        @keyframes scan { 0% { top: 0%; } 100% { top: 100%; } }

        /* Gallery Scroll */
        .gallery-scroll {
            overflow-y: auto;
            scrollbar-width: thin;
            scrollbar-color: var(--php-blue) transparent;
        }
        .gallery-scroll::-webkit-scrollbar { width: 3px; }
        .gallery-scroll::-webkit-scrollbar-thumb { background: var(--php-blue); border-radius: 10px; }

        .btn-php {
            background: var(--php-blue);
            color: white;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            font-size: 0.85rem;
            transition: all 0.3s ease;
        }

        .btn-php:hover:not(:disabled) {
            background: var(--php-blue-light);
            box-shadow: 0 8px 25px var(--php-blue-glow);
            transform: translateY(-1px);
        }
    </style>
</head>
<body class="flex items-center justify-center">
<?php
$dayLabel = 'DÍA 14';
$dayTitle = 'Subida de Archivos';
$prevUrl  = '';
$nextUrl  = '';
require_once __DIR__ . '/../../../_nav.php';
?>
    <div class="industrial-bg">
        <div class="grid-pattern"></div>
    </div>

    <main class="relative z-10 w-full max-w-6xl h-screen flex items-center justify-center p-4">
        <div class="w-full grid lg:grid-cols-12 gap-6 items-stretch h-[85vh]">
            
            <!-- Left Section: Upload Control -->
            <div class="lg:col-span-5 flex flex-col gap-4">
                <div class="industrial-border">
                    <div class="inline-flex items-center gap-2 px-2.5 py-0.5 bg-indigo-500/5 border border-indigo-500/10 rounded-full mb-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-[#4F5B93] animate-pulse"></span>
                        <span class="text-[8px] font-black tracking-[0.2em] text-[#8892BF] uppercase">Integrity_Guard v14</span>
                    </div>
                    <h1 class="text-huge">
                        <span class="text-white opacity-90">SECURE</span><br>
                        <span style="color: var(--php-blue-light)">UPLOAD</span>
                    </h1>
                </div>

                <div class="glass-panel rounded-2xl p-6 flex-1 flex flex-col">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-lg font-black uppercase text-white tracking-tight">Consola de Carga</h2>
                        <i class="ph ph-shield-check text-[#4F5B93] text-xl"></i>
                    </div>

                    <form method="POST" enctype="multipart/form-data" class="flex-1 flex flex-col gap-4">
                        <div id="dropzone" class="dropzone-container flex-1 rounded-xl flex flex-col items-center justify-center gap-3 text-center p-5 border-dashed group relative">
                            <div class="scan-line"></div>
                            <div class="w-12 h-12 rounded-xl bg-white/5 flex items-center justify-center group-hover:scale-105 transition-transform">
                                <i class="ph ph-cloud-arrow-up text-[#4F5B93] text-3xl"></i>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-white mb-0.5">ARRASTRA O SELECCIONA</p>
                                <p class="text-[9px] text-[#8892BF] font-mono uppercase">Límite: 2MB | JPG, PNG, WEBP</p>
                            </div>
                            <div class="relative">
                                <input type="file" name="attachment" id="fileInput" accept="image/*" required class="absolute inset-0 opacity-0 cursor-pointer">
                                <span class="text-[9px] text-[#4F5B93] font-bold border-b border-[#4F5B93] cursor-pointer">EXAMINAR_LOCAL</span>
                            </div>
                            <div id="fileName" class="hidden text-[9px] font-mono text-emerald-400 mt-1"></div>
                        </div>

                        <?php if ($successMessage): ?>
                            <div class="p-3 bg-emerald-500/10 border border-emerald-500/20 rounded-lg flex items-center gap-3">
                                <i class="ph ph-check-circle text-lg text-emerald-400"></i>
                                <p class="text-emerald-200 text-[10px] font-bold"><?= $successMessage ?></p>
                            </div>
                        <?php endif; ?>

                        <?php if ($errorMessage): ?>
                            <div class="p-3 bg-rose-500/10 border border-rose-500/20 rounded-lg flex items-center gap-3">
                                <i class="ph ph-warning-octagon text-lg text-rose-400"></i>
                                <p class="text-rose-200 text-[10px] font-bold"><?= $errorMessage ?></p>
                            </div>
                        <?php endif; ?>

                        <button type="submit" class="btn-php w-full h-12 rounded-lg flex items-center justify-center gap-2">
                            EJECUTAR CARGA <i class="ph ph-caret-right font-bold"></i>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Right Section: Node Gallery -->
            <div class="lg:col-span-7 flex flex-col gap-4">
                <div class="grid grid-cols-2 gap-4">
                    <div class="glass-panel p-3.5 rounded-xl border-l-2 border-[#4F5B93] hover:bg-white/5 transition-colors">
                        <div class="text-[#8892BF] text-[8px] font-black uppercase tracking-widest mb-0.5">Logs_Activos</div>
                        <div class="text-3xl font-black text-white"><?= $totalFiles ?></div>
                    </div>
                    <div class="glass-panel p-3.5 rounded-xl border-l-2 border-[#8892BF] hover:bg-white/5 transition-colors">
                        <div class="text-[#8892BF] text-[8px] font-black uppercase tracking-widest mb-0.5">Nodo_Ocupado</div>
                        <div class="text-3xl font-black text-white"><?= $formattedTotalSize ?></div>
                    </div>
                </div>

                <div class="glass-panel rounded-2xl flex-1 flex flex-col overflow-hidden">
                    <div class="p-4 border-b border-white/5 bg-black/20 flex justify-between items-center">
                        <h3 class="text-xs font-black uppercase text-white flex items-center gap-2">
                            <i class="ph ph-grid-four text-[#4F5B93]"></i> Galería de Acceso
                        </h3>
                        <span class="text-[8px] font-mono text-[#4F5B93] opacity-50">NODE_GALLERY_ACTIVE</span>
                    </div>

                    <div class="gallery-scroll flex-1 p-4 grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                        <?php if (empty($manifest)): ?>
                            <div class="col-span-full h-full flex flex-col items-center justify-center opacity-20 gap-3">
                                <i class="ph ph-image-square text-5xl"></i>
                                <span class="text-[9px] font-mono">NODE_STORAGE_EMPTY</span>
                            </div>
                        <?php else: ?>
                            <?php foreach (array_reverse($manifest) as $file): ?>
                                <div class="group relative aspect-square rounded-xl overflow-hidden border border-white/5 hover:border-[#4F5B93] transition-all bg-black/40">
                                    <img src="uploads/<?= $file['savedName'] ?>" class="w-full h-full object-cover opacity-50 group-hover:opacity-100 transition-opacity" alt="Subida">
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/90 to-transparent opacity-0 group-hover:opacity-100 transition-opacity flex flex-col justify-end p-2">
                                        <p class="text-[8px] font-bold text-white truncate"><?= htmlspecialchars($file['originalName']) ?></p>
                                        <p class="text-[7px] font-mono text-[#8892BF]"><?= round($file['size'] / 1024, 1) ?> KB</p>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>

                    <div class="p-3 border-t border-white/5 bg-black/40 flex justify-between items-center">
                        <div class="flex gap-1">
                            <div class="w-1 h-1 rounded-full bg-emerald-500 animate-pulse"></div>
                            <div class="w-1 h-1 rounded-full bg-emerald-500 animate-pulse delay-75"></div>
                        </div>
                        <span class="text-[8px] font-mono opacity-20">SYNC_STATUS: OK</span>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
        const dropzone = document.getElementById('dropzone');
        const fileInput = document.getElementById('fileInput');
        const fileNameDisplay = document.getElementById('fileName');

        ['dragenter', 'dragover'].forEach(eventName => {
            dropzone.addEventListener(eventName, (e) => {
                e.preventDefault();
                dropzone.classList.add('drag-over');
            });
        });

        ['dragleave', 'drop'].forEach(eventName => {
            dropzone.addEventListener(eventName, (e) => {
                e.preventDefault();
                dropzone.classList.remove('drag-over');
            });
        });

        fileInput.addEventListener('change', () => {
            const file = fileInput.files[0];
            if (file) {
                fileNameDisplay.textContent = `[DETECCIÓN]: ${file.name.toUpperCase()}`;
                fileNameDisplay.classList.remove('hidden');
            }
        });
    </script>
</body>
</html>
