<?php
/**
 * Plantilla Pedagógica Universal para Días 1 al 10.
 * Variables requeridas:
 * $dayNumber, $dayLabel, $dayTitle, $dayDescription
 * $learningObjectives (array: ['title', 'desc'])
 * $professorNote (string)
 * $files (array: ['Name' => ['path', 'icon']])
 * $executionMode (string: 'cli' | 'web')
 * $cliOutput (string) | $webAppUrl (string)
 */

require_once __DIR__ . '/../src/Core/ProjectScanner.php';
$scanner = new \App\Core\ProjectScanner(__DIR__ . '/../content');
$allProjects = $scanner->getProjects();

$prevUrl = '';
$nextUrl = '';

foreach ($allProjects as $idx => $p) {
    if ($p['day'] === $dayNumber) {
        if (isset($allProjects[$idx - 1])) $prevUrl = $allProjects[$idx - 1]['path'];
        if (isset($allProjects[$idx + 1])) $nextUrl = $allProjects[$idx + 1]['path'];
        break;
    }
}

$fileContents = [];
$firstFile = '';
$currentProjectDir = '';

foreach ($allProjects as $p) {
    if ($p['day'] === $dayNumber) {
        $projectRoot = realpath(__DIR__ . '/..');
        $currentProjectDir = dirname($projectRoot . $p['path']);
        break;
    }
}


foreach ($files as $name => $info) {
    if (empty($firstFile)) $firstFile = $name;
    
    $filePath = $info['path'];
    // Si la ruta es relativa, la hacemos relativa al directorio del proyecto
    if (!str_starts_with($filePath, '/') && !str_contains($filePath, ':')) {
        $fullPath = $currentProjectDir . '/' . $filePath;
    } else {
        $fullPath = $filePath;
    }
    
    $fileContents[$name] = file_exists($fullPath) ? file_get_contents($fullPath) : "// Archivo no encontrado en: {$fullPath}";
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $dayLabel ?> — <?= $dayTitle ?> | Masterclass PHP</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    
    <link href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/themes/prism.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/prism.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-php.min.js"></script>

    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8fafc; color: #334155; }
        .font-mono { font-family: 'JetBrains Mono', monospace; }
        ::-webkit-scrollbar { width: 8px; height: 8px; }
        ::-webkit-scrollbar-track { background: #f1f5f9; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
        .tab-btn { padding: 0.6rem 1.2rem; color: #64748b; font-weight: 500; font-size: 0.875rem; transition: all 0.2s; border-bottom: 2px solid transparent; background: transparent; }
        .tab-btn:hover { color: #0f172a; background: #f1f5f9; }
        .tab-btn.active { color: #2563eb; border-bottom-color: #2563eb; background: #eff6ff; font-weight: 600; }
        pre[class*="language-"] { margin: 0 !important; padding: 1.5rem !important; background: #ffffff !important; font-size: 0.875rem !important; border: none !important; border-radius: 0 !important; box-shadow: none !important; max-height: 500px; overflow-y: auto;}
        code[class*="language-"] { text-shadow: none !important; }
        .terminal-output { text-shadow: 0 0 5px rgba(74, 222, 128, 0.2); }
        .custom-tree div { transition: all 0.2s ease; }
        .custom-tree .group:hover { background: rgba(37, 99, 235, 0.05); border-radius: 4px; }
    </style>

</head>
<body class="antialiased selection:bg-blue-200 selection:text-blue-900">

    <?php require_once __DIR__ . '/../_nav.php'; ?>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        
        <header class="mb-10">
            <div class="flex items-center gap-2 text-sm font-semibold text-blue-600 mb-2 uppercase tracking-wider">
                <i class="ph-bold ph-graduation-cap text-lg"></i>
                Módulo 1 • Lección <?= str_pad((string)$dayNumber, 2, '0', STR_PAD_LEFT) ?>
            </div>
            <h1 class="text-3xl md:text-4xl font-extrabold text-slate-900 mb-4 tracking-tight">
                <?= $dayTitle ?>
            </h1>
            <p class="text-lg text-slate-600 max-w-3xl">
                <?= $dayDescription ?>
            </p>
        </header>



        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            <div class="lg:col-span-4 space-y-6">
                
                <!-- Project Structure -->
                <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200">
                    <h2 class="text-lg font-bold text-slate-900 mb-4 flex items-center gap-2 border-b border-slate-100 pb-3">
                        <i class="ph-bold ph-tree-structure text-blue-600"></i> Arquitectura del Proyecto
                    </h2>
                    <div class="font-mono text-sm text-slate-700 space-y-1 bg-slate-50 p-4 rounded-lg border border-slate-100 max-h-[400px] overflow-y-auto custom-tree">
                        <?php
                        // Función para construir el árbol de archivos
                        function buildTree($files) {
                            $tree = [];
                            foreach ($files as $name => $info) {
                                $parts = explode('/', $info['path']);
                                $current = &$tree;
                                foreach ($parts as $i => $part) {
                                    if ($i === count($parts) - 1) {
                                        $current[$part] = [
                                            'isDir' => false,
                                            'name'  => $name,
                                            'icon'  => $info['icon'],
                                            'path'  => $info['path']
                                        ];
                                    } else {
                                        if (!isset($current[$part])) {
                                            $current[$part] = ['isDir' => true, 'children' => []];
                                        }
                                        $current = &$current[$part]['children'];
                                    }
                                }
                            }
                            return $tree;
                        }

                        function renderTree($tree, $level = 0) {
                            foreach ($tree as $key => $node) {
                                $indent = $level * 16;
                                if (isset($node['isDir']) && $node['isDir']) {
                                    echo "<div class='flex items-center gap-2 text-slate-900 font-bold mb-1' style='margin-left: {$indent}px;'>";
                                    echo "<i class='ph-fill ph-folder text-blue-500'></i> {$key}/";
                                    echo "</div>";
                                    renderTree($node['children'], $level + 1);
                                } else {
                                    $icon = $node['icon'] ?? 'ph-file-code';
                                    $name = $node['name'];
                                    echo "<div class='flex items-center gap-2 text-slate-600 hover:text-blue-600 transition-colors cursor-pointer group mb-1' 
                                               style='margin-left: {$indent}px;' 
                                               onclick=\"showFile('{$name}')\">";
                                    echo "<i class='ph-bold ph-arrow-elbow-down-right text-slate-300 opacity-0 group-hover:opacity-100'></i>";
                                    echo "<i class='ph-fill {$icon} text-slate-400'></i> {$key}";
                                    echo "</div>";
                                }
                            }
                        }

                        $projectTree = buildTree($files);
                        ?>
                        
                        <div class="flex items-center gap-2 text-slate-900 font-black mb-3 border-b border-slate-200 pb-2 italic">
                            <i class="ph-bold ph-package text-blue-600 text-lg"></i> <?= basename($currentProjectDir) ?>/
                        </div>

                        
                        <?php renderTree($projectTree); ?>
                    </div>

                </div>

                <!-- Learning Objectives -->
                <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200">
                    <h2 class="text-lg font-bold text-slate-900 mb-4 flex items-center gap-2 border-b border-slate-100 pb-3">
                        <i class="ph-bold ph-target text-blue-600"></i> Objetivos de la Lección
                    </h2>
                    <ul class="space-y-4 text-slate-700 text-sm">
                        <?php foreach ($learningObjectives as $obj): ?>
                        <li class="flex items-start gap-3">
                            <i class="ph-fill ph-check-circle text-emerald-500 mt-0.5 text-lg shrink-0"></i>
                            <div>
                                <strong class="block text-slate-900"><?= $obj['title'] ?></strong>
                                <span class="text-slate-600"><?= $obj['desc'] ?></span>
                            </div>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>

                <!-- Professor Note -->
                <?php if (!empty($professorNote)): ?>
                <div class="bg-blue-50 p-6 rounded-xl border border-blue-200">
                    <h3 class="text-blue-900 font-bold mb-3 flex items-center gap-2">
                        <i class="ph-bold ph-chalkboard-teacher text-xl"></i> Nota del Profesor
                    </h3>
                    <div class="text-blue-800 text-sm leading-relaxed space-y-2">
                        <?= $professorNote ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>

            <!-- RIGHT COLUMN -->
            <div class="lg:col-span-8 space-y-6">
                
                <!-- Code Explorer -->
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden flex flex-col">
                    <div class="bg-slate-50 border-b border-slate-200 px-2 pt-2 flex overflow-x-auto">
                        <?php foreach ($files as $name => $info): ?>
                            <button onclick="showFile('<?= $name ?>')" 
                                    id="btn-<?= $name ?>" 
                                    class="tab-btn flex items-center gap-2 whitespace-nowrap rounded-t-lg">
                                <i class="ph <?= $info['icon'] ?> text-lg"></i>
                                <?= $name ?>
                            </button>
                        <?php endforeach; ?>
                    </div>
                    <div class="relative bg-white flex-grow">
                        <button onclick="copyCurrentCode()" class="absolute top-4 right-4 p-2 bg-slate-100 hover:bg-slate-200 text-slate-500 rounded-md transition-all z-10" title="Copiar código">
                            <i class="ph-bold ph-copy"></i>
                        </button>
                        <?php foreach ($fileContents as $name => $content): ?>
                            <div id="code-<?= $name ?>" class="file-content hidden">
                                <pre class="language-php"><code><?= htmlspecialchars($content) ?></code></pre>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="bg-slate-50 p-3 border-t border-slate-200 flex justify-between items-center text-xs">
                        <span id="current-path" class="font-mono text-slate-500 font-medium"></span>
                        <span class="text-slate-400 font-semibold uppercase tracking-wider">Modo Lectura</span>
                    </div>
                </div>

                <!-- Execution Area -->
                <?php if ($executionMode === 'cli'): ?>
                    <div class="bg-[#1e1e1e] rounded-xl shadow-lg overflow-hidden border border-slate-800">
                        <div class="bg-[#2d2d2d] px-4 py-2.5 flex items-center gap-2 border-b border-slate-700/50">
                            <div class="w-3 h-3 rounded-full bg-[#ff5f56]"></div>
                            <div class="w-3 h-3 rounded-full bg-[#ffbd2e]"></div>
                            <div class="w-3 h-3 rounded-full bg-[#27c93f]"></div>
                            <span class="ml-3 text-[11px] text-slate-400 font-mono tracking-wide">bash — php <?= basename($files[array_key_first($files)]['path']) ?></span>
                        </div>
                        <div class="p-6 font-mono text-[13px] leading-relaxed text-slate-300 terminal-output">
                            <?= $cliOutput ?>
                            <div class="mt-4 flex items-center text-slate-500">
                                <span class="text-[#e06c75] mr-2">➜</span> <span class="animate-pulse">_</span>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                        <div class="bg-slate-50 px-4 py-3 flex items-center justify-between border-b border-slate-200">
                            <div class="flex items-center gap-2">
                                <div class="w-3 h-3 rounded-full bg-slate-300"></div>
                                <div class="w-3 h-3 rounded-full bg-slate-300"></div>
                                <div class="w-3 h-3 rounded-full bg-slate-300"></div>
                            </div>
                            <div class="bg-white border border-slate-200 rounded text-xs px-3 py-1 font-mono text-slate-500 flex-grow max-w-sm mx-4 text-center">
                                <?= $webAppUrl ?>
                            </div>

                            <a href="<?= $webAppUrl ?>" target="_blank" class="text-blue-600 hover:text-blue-700 text-sm font-medium flex items-center gap-1">
                                Abrir App <i class="ph-bold ph-arrow-square-out"></i>
                            </a>
                        </div>
                        <div class="w-full h-[600px] bg-slate-100 relative">
                            <iframe src="<?= $webAppUrl ?>" class="w-full h-full border-none" title="Web App Preview"></iframe>
                        </div>
                    </div>
                <?php endif; ?>
                
            </div>
        </div>

    </main>

    <script>
        const filePaths = <?= json_encode(array_combine(array_keys($files), array_column($files, 'path'))) ?>;

        function showFile(name) {
            document.querySelectorAll('.file-content').forEach(el => el.classList.add('hidden'));
            document.querySelectorAll('.tab-btn').forEach(el => el.classList.remove('active'));
            document.getElementById('code-' + name).classList.remove('hidden');
            document.getElementById('btn-' + name).classList.add('active');
            document.getElementById('current-path').textContent = './' + filePaths[name];
            Prism.highlightAll();
        }

        function copyCurrentCode() {
            const activeContent = document.querySelector('.file-content:not(.hidden) code').textContent;
            navigator.clipboard.writeText(activeContent);
            alert('Código copiado al portapapeles');
        }

        showFile('<?= $firstFile ?>');
    </script>
</body>
</html>
