<!DOCTYPE html>
<html lang="es" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Masterclass // Portfolio V2 Perfection</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&family=JetBrains+Mono:wght@400;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/gh/devicons/devicon@latest/devicon.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
    <style>
        @font-face {
            font-family: 'HackerFont';
            src: url('/public/assets/HACKED.ttf') format('truetype');
        }

        :root { --bg: #030406; --accent: #00f2ff; --obsidian: #0f111a; }
        body { background: var(--bg); color: #cbd5e1; font-family: 'Outfit', sans-serif; overflow-x: hidden; }
        
        /* Cinematic Lighting */
        .nebula {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background: 
                radial-gradient(circle at 10% 20%, rgba(0, 242, 255, 0.03) 0%, transparent 50%),
                radial-gradient(circle at 90% 80%, rgba(139, 92, 246, 0.03) 0%, transparent 50%);
            z-index: -1;
        }
        .light-orb {
            position: fixed; width: 600px; height: 600px;
            background: radial-gradient(circle, rgba(0, 242, 255, 0.05) 0%, transparent 70%);
            border-radius: 50%; pointer-events: none; z-index: -1; filter: blur(80px);
        }

        .tech-grid {
            position: fixed; inset: 0;
            background-image: 
                linear-gradient(rgba(255,255,255,0.01) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,0.01) 1px, transparent 1px);
            background-size: 60px 60px; z-index: -2;
        }

        /* Debug Panel */
        .debug-panel {
            position: fixed; bottom: 30px; right: 30px;
            background: rgba(15, 17, 26, 0.6);
            backdrop-filter: blur(25px);
            border: 1px solid rgba(0, 242, 255, 0.1);
            padding: 24px; border-radius: 24px;
            font-family: 'JetBrains Mono', monospace; font-size: 11px;
            z-index: 100; opacity: 0; transform: scale(0.9) translateY(20px);
            transition: all 0.5s cubic-bezier(0.23, 1, 0.32, 1);
            pointer-events: none;
        }
        .debug-active .debug-panel { opacity: 1; transform: scale(1) translateY(0); pointer-events: auto; }

        .glass-nav {
            background: rgba(3, 4, 6, 0.6);
            backdrop-filter: blur(30px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.03);
            transition: all 0.4s;
        }

        .brand-text {
            font-family: 'HackerFont', sans-serif;
            letter-spacing: 0.1em;
        }

        .nav-link {
            font-size: 10px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.2em;
            color: #64748b; transition: all 0.3s; position: relative;
        }
        .nav-link:hover { color: var(--accent); }
        .nav-link::after {
            content: ''; position: absolute; bottom: -4px; left: 0; width: 0; height: 1px;
            background: var(--accent); transition: width 0.3s;
        }
        .nav-link:hover::after { width: 100%; }

        .logo-white { filter: brightness(0) invert(1); }

        .glow-text { text-shadow: 0 0 20px rgba(0, 242, 255, 0.3); }
        .stagger-item { opacity: 0; }
        
        .terminal-container {
            background: rgba(15, 17, 26, 0.4);
            backdrop-filter: blur(40px);
            border: 1px solid rgba(255, 255, 255, 0.03);
            border-radius: 32px;
        }
    </style>
</head>
<body>
    <div class="nebula"></div>
    <div class="tech-grid"></div>
    <div class="light-orb" id="orb1"></div>
    <div class="light-orb" id="orb2"></div>

    <!-- Navigation Perfection -->
    <nav class="fixed top-0 w-full z-50 px-10 py-8 glass-nav">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <!-- Brand Logo with External Link -->
            <a href="https://bychokeportafolio.netlify.app/" target="_blank" class="flex items-center gap-5 group">
                <div class="w-12 h-12 rounded-xl overflow-hidden border border-white/10 group-hover:border-cyan-400/30 transition-all duration-500 shadow-xl bg-white/5">
                    <img src="/public/assets/img/logo.gif" alt="ByChoke Logo" class="w-full h-full object-cover logo-white">
                </div>
                <div class="text-2xl font-black text-white tracking-tighter uppercase italic brand-text">ByChoke<span class="text-indigo-400 ml-2">Studios</span></div>
            </a>

            <!-- Menu Links -->
            <div class="hidden lg:flex items-center gap-12">
                <a href="#" class="nav-link">Inicio</a>
                <a href="#timeline" class="nav-link">Proyectos</a>
                <a href="https://github.com/ByChokeYT/php8-masterclass-portfolio" target="_blank" class="nav-link flex items-center gap-2">
                    <i class="ph-bold ph-github-logo text-lg"></i> Repo
                </a>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center gap-8">
                <button id="debugToggle" class="flex items-center gap-3 px-5 py-2.5 rounded-full border border-white/5 bg-white/5 text-[10px] font-black uppercase tracking-[0.2em] text-slate-500 hover:text-cyan-400 hover:border-cyan-400/30 transition-all">
                    <span class="w-2 h-2 rounded-full bg-slate-700 transition-all duration-300" id="debugLed"></span>
                    Debug_Mode
                </button>
            </div>
        </div>
    </nav>

    <main>
        <?php include $viewPath; ?>
    </main>

    <!-- Debug Panel -->
    <div class="debug-panel shadow-2xl">
        <div class="text-cyan-400 font-bold mb-6 uppercase tracking-[0.3em] border-b border-white/10 pb-3 flex items-center gap-3">
            <i class="ph ph-cpu"></i> System_Diagnostics
        </div>
        <div class="space-y-4">
            <div class="flex justify-between gap-12">
                <span class="text-slate-500 uppercase tracking-widest text-[9px]">Memory_Usage</span>
                <span class="text-white font-bold"><?= $metrics['memory_usage'] ?> MB</span>
            </div>
            <div class="flex justify-between gap-12">
                <span class="text-slate-500 uppercase tracking-widest text-[9px]">Execution_Time</span>
                <span class="text-white font-bold"><?= $metrics['load_time'] ?> ms</span>
            </div>
            <div class="flex justify-between gap-12">
                <span class="text-slate-500 uppercase tracking-widest text-[9px]">PHP_Runtime</span>
                <span class="text-white font-bold">v<?= $metrics['php_version'] ?></span>
            </div>
            <div class="pt-4 border-t border-white/5 flex items-center gap-2 text-green-400/50">
                <i class="ph ph-check-circle"></i>
                <span class="text-[9px] font-bold uppercase tracking-widest">Environment: Healthy</span>
            </div>
        </div>
    </div>

    <script>
        // Debug Engine
        const debugToggle = document.getElementById('debugToggle');
        const debugLed = document.getElementById('debugLed');
        debugToggle.addEventListener('click', () => {
            document.body.classList.toggle('debug-active');
            const isActive = document.body.classList.contains('debug-active');
            debugLed.style.background = isActive ? '#00f2ff' : '#334155';
            debugLed.style.boxShadow = isActive ? '0 0 10px #00f2ff' : 'none';
        });

        // Cinematic Orb Movement
        gsap.to("#orb1", {
            x: "50vw", y: "30vh", duration: 15, repeat: -1, yoyo: true, ease: "sine.inOut"
        });
        gsap.to("#orb2", {
            x: "-30vw", y: "-20vh", duration: 20, repeat: -1, yoyo: true, ease: "sine.inOut"
        });

        // Page Loader & ScrollTrigger
        window.addEventListener('DOMContentLoaded', () => {
            gsap.registerPlugin(ScrollTrigger);
            
            // Initial Hero Animation
            gsap.to('.stagger-item', {
                opacity: 1, y: 0, duration: 1.5, stagger: 0.15, ease: "expo.out"
            });

            // Timeline Scroll Reveal
            gsap.utils.toArray('.stagger-item').forEach(item => {
                gsap.to(item, {
                    scrollTrigger: {
                        trigger: item,
                        start: "top 90%",
                        toggleActions: "play none none none"
                    },
                    opacity: 1,
                    y: 0,
                    duration: 1.2,
                    ease: "power3.out"
                });
            });
        });
    </script>
</body>
</html>
