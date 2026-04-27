<?php
declare(strict_types=1);

require_once __DIR__ . '/dia-18-markdown-to-html/MarkdownParser.php';

$parser = new MarkdownParser();
$content = file_get_contents(__DIR__ . '/MASTERCLASS_BLOG.md');

// Limpiar la imagen del banner para manejarla por separado en la UI
$content = preg_replace('/\!\[.*?\]\(assets\/banner_blog\.png\)/', '', $content);

$htmlContent = $parser->parse($content);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GUÍA MAESTRA // MASTERCLASS PHP</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;700;900&family=JetBrains+Mono:wght@400;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <style>
        body {
            background-color: #05070a;
            color: #94a3b8;
            font-family: 'Outfit', sans-serif;
        }
        .industrial-grid {
            position: fixed; inset: 0; z-index: -1;
            background-image: 
                linear-gradient(rgba(255, 255, 255, 0.012) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255, 255, 255, 0.012) 1px, transparent 1px);
            background-size: 40px 40px;
        }
        .prose h1, .prose h2, .prose h3 { font-family: 'Outfit', sans-serif; color: white; }
        .prose pre { border: 1px solid rgba(255,255,255,0.05); }
    </style>
</head>
<body class="p-6 md:p-12 lg:p-20">
    <div class="industrial-grid"></div>

    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <header class="mb-12 flex justify-between items-center">
            <a href="index.php" class="flex items-center gap-2 text-xs font-bold text-slate-500 hover:text-emerald-400 transition-colors uppercase tracking-widest">
                <i class="ph-bold ph-arrow-left"></i> Volver_al_Hub
            </a>
            <div class="text-[10px] font-mono opacity-30 uppercase tracking-widest">Masterclass_v3.0 // By_Choke</div>
        </header>

        <!-- Banner -->
        <div class="relative w-full aspect-[21/9] rounded-3xl overflow-hidden mb-16 border border-white/5 shadow-2xl">
            <img src="assets/banner_blog.png" alt="Masterclass Banner" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-t from-[#05070a] via-transparent to-transparent"></div>
        </div>

        <!-- Content -->
        <article class="prose prose-invert max-w-none">
            <?= $htmlContent ?>
        </article>

        <!-- Footer -->
        <footer class="mt-32 pt-12 border-t border-white/5 opacity-30 flex justify-between items-center">
            <div class="flex items-center gap-3">
                <i class="ph-fill ph-graduation-cap text-2xl"></i>
                <span class="text-[10px] font-mono uppercase tracking-widest">By Choke // Academia Masterclass 2024</span>
            </div>
            <div class="text-[10px] font-mono uppercase tracking-widest">Propiedad Intelectual</div>
        </footer>
    </div>

    <!-- Script para renderizar Mermaid (Opcional si se desea real) -->
    <script type="module">
        import mermaid from 'https://cdn.jsdelivr.net/npm/mermaid@10/dist/mermaid.esm.min.mjs';
        mermaid.initialize({ startOnLoad: true, theme: 'dark' });
    </script>
</body>
</html>
