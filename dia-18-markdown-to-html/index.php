<?php
declare(strict_types=1);

require_once 'MarkdownParser.php';

// Manejo de AJAX
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['markdown'])) {
    $parser = new MarkdownParser();
    $html = $parser->parse($_POST['markdown']);
    echo $html;
    exit;
}

// Contenido por defecto (Welcome Note)
$defaultMarkdown = "# BIENVENIDO AL RENDERER v1.0\n\nEste es el **Día 18** de la Masterclass PHP 8.5. \n\n## Características:\n- **Parser Propio:** Escrito con Regex puro.\n- **Velocidad:** Renderizado instantáneo vía AJAX.\n- **Seguridad:** XSS Protegido.\n\n### Ejemplo de Código:\n```php\npublic function parse(string $text): string {\n    return preg_replace('/\\*\\*(.*?)\\*\\*/', '<strong>$1</strong>', $text);\n}\n```\n\n*Prueba a escribir algo aquí a la izquierda...*";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Markdown Engine | Masterclass PHP</title>
    <link rel="icon" type="image/x-icon" href="https://www.php.net/favicon.ico">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;700;900&family=JetBrains+Mono:wght@400;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <style>
        :root { --bg: #030406; --cyan: #22d3ee; }
        body { background-color: var(--bg); color: #94a3b8; font-family: 'Outfit', sans-serif; }
        .industrial-grid {
            position: fixed; inset: 0; z-index: -1;
            background-image: linear-gradient(rgba(255,255,255,0.01) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,0.01) 1px, transparent 1px);
            background-size: 30px 30px;
        }
        .tech-label { font-family: 'JetBrains Mono'; text-transform: uppercase; letter-spacing: 0.1em; font-size: 0.6rem; opacity: 0.4; }
        textarea { 
            font-family: 'JetBrains Mono', monospace; 
            resize: none; 
            background: transparent; 
            outline: none;
            scrollbar-width: thin;
            scrollbar-color: #1e293b transparent;
        }
        .preview-area {
            scrollbar-width: thin;
            scrollbar-color: #1e293b transparent;
        }
        .split-divider { width: 1px; background: linear-gradient(to bottom, transparent, rgba(255,255,255,0.05), transparent); }
        
        /* Animación para el preview */
        .preview-content { transition: opacity 0.2s ease; }
        .preview-content.updating { opacity: 0.5; }
    </style>
</head>
<body class="h-screen flex flex-col overflow-hidden">
    <div class="industrial-grid"></div>

    <!-- Header -->
    <header class="h-16 shrink-0 flex items-center justify-between px-8 border-b border-white/5 bg-black/20 backdrop-blur-xl">
        <div class="flex items-center gap-3">
            <div class="p-2 bg-slate-900 rounded-lg border border-white/5"><i class="ph-bold ph-text-aa text-cyan-400 text-lg"></i></div>
            <div>
                <h1 class="text-lg font-black text-white uppercase tracking-tighter">Markdown <span class="text-cyan-400">Core</span></h1>
                <span class="tech-label text-[8px]">Módulo_Procesador // v18.0</span>
            </div>
        </div>
        <div class="flex items-center gap-6">
            <div class="flex items-center gap-2">
                <div class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></div>
                <span class="tech-label">Sincronización_Activa</span>
            </div>
            <a href="../index.php" class="tech-label hover:text-white transition-colors flex items-center gap-2">
                <i class="ph ph-arrow-left"></i> Volver al Portal
            </a>
        </div>
    </header>

    <!-- Main Editor -->
    <main class="flex-1 flex min-h-0 bg-black/10">
        <!-- Editor Column -->
        <section class="flex-1 flex flex-col min-w-0">
            <div class="h-8 flex items-center px-6 bg-white/2">
                <span class="tech-label">EDITOR / SOURCE_CODE</span>
            </div>
            <textarea id="markdownInput" class="flex-1 p-8 text-sm text-slate-300 leading-relaxed" placeholder="Escribe aquí tu Markdown..."><?= $defaultMarkdown ?></textarea>
        </section>

        <!-- Divider -->
        <div class="split-divider"></div>

        <!-- Preview Column -->
        <section class="flex-1 flex flex-col min-w-0 bg-black/5">
            <div class="h-8 flex items-center px-6 bg-white/2 border-l border-white/5">
                <span class="tech-label">PREVIEW / RENDERED_OUTPUT</span>
            </div>
            <div id="previewArea" class="flex-1 p-10 overflow-y-auto preview-area border-l border-white/5">
                <div id="previewContent" class="preview-content">
                    <!-- Aquí cae el HTML parseado -->
                </div>
            </div>
        </section>
    </main>

    <!-- Barrita de Estado -->
    <footer class="h-8 shrink-0 bg-black/40 border-t border-white/5 flex items-center justify-between px-6">
        <div class="flex gap-4">
            <span class="tech-label">Status: <span class="text-emerald-500">Live</span></span>
            <span class="tech-label">UTF-8</span>
        </div>
        <span class="tech-label">By_Choke // Masterclass_Day_18</span>
    </footer>

    <script>
        const input = document.getElementById('markdownInput');
        const content = document.getElementById('previewContent');
        let timer = null;

        const updatePreview = async () => {
            const md = input.value;
            content.classList.add('updating');

            try {
                const response = await fetch('index.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: `markdown=${encodeURIComponent(md)}`
                });
                
                const html = await response.text();
                content.innerHTML = html;
            } catch (err) {
                console.error("Error al renderizar:", err);
            } finally {
                content.classList.remove('updating');
            }
        };

        // Debounce para no saturar al servidor
        input.addEventListener('input', () => {
            clearTimeout(timer);
            timer = setTimeout(updatePreview, 150);
        });

        // Carga inicial
        updatePreview();
    </script>
</body>
</html>
