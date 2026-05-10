<!DOCTYPE html>
<html lang="es" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Masterclass — De Coder a Arquitecto Backend | ByChoke</title>
    <meta name="description" content="Domina PHP 8.5 moderno con 50 proyectos reales. Clean Architecture, PDO, APIs REST y más. Por José Luis Choquevillca, ingeniero con 10+ años de experiencia.">
    <meta name="keywords" content="PHP, Masterclass, Backend, Arquitectura, PDO, MVC, Tailwind, ByChoke">
    <meta property="og:title" content="PHP Masterclass — ByChoke Studios">
    <meta property="og:description" content="50 proyectos PHP de grado industrial. Aprende como un Senior Developer.">
    <meta property="og:type" content="website">
    <link rel="icon" type="image/x-icon" href="/favicon.ico">


    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Tipografía -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,700;1,800;1,900&family=JetBrains+Mono:wght@400;500;700&display=swap" rel="stylesheet">
    
    <!-- Íconos -->
    <script src="https://unpkg.com/@phosphor-icons/web" defer></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/devicons/devicon@latest/devicon.min.css">

    <!-- AOS — Animaciones de scroll (liviano, reemplaza GSAP) -->
    <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.4/dist/aos.js" defer></script>

    <!-- Vue.js 3 — Para el grid filtrable de proyectos -->
    <script src="https://unpkg.com/vue@3/dist/vue.global.prod.js" defer></script>

    <style>
        /* ===== DESIGN SYSTEM ===== */
        :root {
            --bg:        #050608;
            --surface:   #0d0f16;
            --surface-2: #141720;
            --border:    rgba(255, 255, 255, 0.07);
            --accent:    #6366f1; /* Indigo */
            --accent-2:  #06b6d4; /* Cyan */
            --text:      #cbd5e1;
            --text-muted:#475569;
        }

        body {
            background: var(--bg);
            color: var(--text);
            font-family: 'Inter', system-ui, sans-serif;
            overflow-x: hidden;
        }

        .tech-mono { font-family: 'JetBrains Mono', monospace; }

        /* Fondo con textura de grid sutil */
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background-image:
                linear-gradient(rgba(255,255,255,0.018) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,0.018) 1px, transparent 1px);
            background-size: 60px 60px;
            z-index: -2;
            pointer-events: none;
        }

        /* Nebulosa ambiental */
        .nebula-bg {
            position: fixed; inset: 0; z-index: -1; pointer-events: none;
            background:
                radial-gradient(ellipse 60% 50% at 10% 10%, rgba(99,102,241,0.06) 0%, transparent 70%),
                radial-gradient(ellipse 50% 40% at 90% 90%, rgba(6,182,212,0.05) 0%, transparent 60%);
        }

        /* Scrollbar */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: var(--bg); }
        ::-webkit-scrollbar-thumb { background: #1e2030; border-radius: 99px; }
        ::-webkit-scrollbar-thumb:hover { background: var(--accent); }

        /* Glass card */
        .glass {
            background: var(--surface);
            border: 1px solid var(--border);
            backdrop-filter: blur(12px);
            transition: border-color 0.3s, box-shadow 0.3s, transform 0.3s;
        }
        .glass:hover {
            border-color: rgba(99,102,241,0.3);
            box-shadow: 0 0 30px rgba(99,102,241,0.08);
            transform: translateY(-3px);
        }

        /* Badge pill */
        .badge-pill {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 4px 12px; border-radius: 99px;
            font-size: 10px; font-weight: 800; letter-spacing: 0.2em; text-transform: uppercase;
            border: 1px solid rgba(99,102,241,0.2);
            background: rgba(99,102,241,0.08);
            color: #a5b4fc;
        }

        /* Section label */
        .section-label {
            font-size: 10px; font-weight: 800; text-transform: uppercase;
            letter-spacing: 0.3em; color: var(--accent);
            font-family: 'JetBrains Mono', monospace;
        }

        /* Gradient text */
        .grad-text {
            background: linear-gradient(135deg, #818cf8 0%, #06b6d4 50%, #6366f1 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Logo filter */
        .logo-filter { filter: brightness(0) invert(1); }

        /* Tag chips */
        .tag-chip {
            font-size: 9px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em;
            padding: 2px 8px; border-radius: 4px;
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.06);
            color: #64748b;
        }

        /* Phase color dots */
        .phase-dot-1 { background: #10b981; }
        .phase-dot-2 { background: #06b6d4; }
        .phase-dot-3 { background: #f59e0b; }
        .phase-dot-4 { background: #f43f5e; }
        .phase-dot-5 { background: #8b5cf6; }

        [v-cloak] { display: none; }
    </style>
</head>
<body>
    <!-- Nebulosa ambiental -->
    <div class="nebula-bg"></div>

    <!-- ====================================================
         NAVIGATION PRINCIPAL DEL HUB
    ==================================================== -->
    <nav class="fixed top-0 w-full z-50 border-b border-white/5" style="background: rgba(5,6,8,0.85); backdrop-filter: blur(24px);">
        <div class="max-w-7xl mx-auto px-6 h-16 flex items-center justify-between">

            <!-- Brand -->
            <a href="/" class="flex items-center gap-3 group">
                <div class="w-9 h-9 rounded-xl overflow-hidden border border-white/10 group-hover:border-indigo-500/40 transition-all bg-white/5 shrink-0">
                    <img src="/assets/img/logo.gif" alt="ByChoke" class="w-full h-full object-cover logo-filter">
                </div>
                <div class="text-white font-black text-lg tracking-tight">
                    ByChoke<span class="text-indigo-400">Studios</span>
                </div>
            </a>

            <!-- Links -->
            <div class="hidden md:flex items-center gap-8">
                <a href="#proyectos" class="text-[11px] font-bold uppercase tracking-widest text-slate-500 hover:text-white transition-colors">Proyectos</a>
                <a href="#mentor" class="text-[11px] font-bold uppercase tracking-widest text-slate-500 hover:text-white transition-colors">Instructor</a>
                <a href="https://github.com/ByChokeYT/php8-masterclass-portfolio" target="_blank" class="flex items-center gap-2 text-[11px] font-bold uppercase tracking-widest text-slate-500 hover:text-white transition-colors">
                    <i class="ph-bold ph-github-logo text-base"></i> GitHub
                </a>
            </div>

            <!-- CTA -->
            <a href="#proyectos" class="px-5 py-2 rounded-xl bg-indigo-600 text-white text-[11px] font-black uppercase tracking-widest hover:bg-indigo-500 transition-colors shadow-lg shadow-indigo-600/20">
                Empezar →
            </a>
        </div>
    </nav>

    <!-- MAIN CONTENT -->
    <main>
        <?php include $viewPath; ?>
    </main>

    <!-- Debug Panel (sutil, solo para desarrollo) -->
    <div id="debugPanel" class="fixed bottom-6 right-6 z-50 hidden">
        <div class="glass rounded-2xl p-4 text-xs tech-mono text-slate-500 min-w-[200px]">
            <div class="text-indigo-400 font-bold mb-3 text-[10px] uppercase tracking-widest">System Info</div>
            <div class="space-y-1.5">
                <div class="flex justify-between gap-8"><span>Memory</span><span class="text-white"><?= $metrics['memory_usage'] ?? '--' ?> MB</span></div>
                <div class="flex justify-between gap-8"><span>Load Time</span><span class="text-white"><?= $metrics['load_time'] ?? '--' ?> ms</span></div>
                <div class="flex justify-between gap-8"><span>PHP</span><span class="text-white">v<?= $metrics['php_version'] ?? PHP_VERSION ?></span></div>
            </div>
        </div>
    </div>

    <script>
        // AOS Init
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof AOS !== 'undefined') {
                AOS.init({ duration: 700, once: true, easing: 'ease-out-cubic', offset: 60 });
            }
        });
    </script>
</body>
</html>
