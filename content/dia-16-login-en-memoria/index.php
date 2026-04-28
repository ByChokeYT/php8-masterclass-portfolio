<?php
declare(strict_types=1);

/**
 * MASTERCLASS PHP 8.5 - DÍA 16: LOGIN EN MEMORIA (ULTRA-ELITE EDITION)
 * Enfoque: Experiencia de Usuario, Estética Industrial y Persistencia.
 */

session_start();

const AUTH_USER = 'admin';
const AUTH_PASS = 'master85';

$error = null;

// Logout handler
if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    session_destroy();
    header('Location: index.php');
    exit;
}

// Login handler
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS);
    $pass = $_POST['password'] ?? '';

    if ($user === AUTH_USER && $pass === AUTH_PASS) {
        session_regenerate_id(true);
        $_SESSION['user_auth'] = [
            'username' => $user,
            'login_time' => time(),
            'client_ip' => $_SERVER['REMOTE_ADDR']
        ];
        $_SESSION['access_count'] = 0;
        header('Location: index.php');
        exit;
    } else {
        $error = "ERROR DE ACCESO: CREDENCIALES NO VERIFICADAS";
    }
}

$isLoggedIn = isset($_SESSION['user_auth']);
if ($isLoggedIn) {
    $_SESSION['access_count']++;
    $userData = $_SESSION['user_auth'];
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal de Autenticación | Sistema de Acceso</title>
    <link rel="icon" type="image/x-icon" href="https://www.php.net/favicon.ico">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;700;900&family=JetBrains+Mono:wght@400;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <style>
        :root {
            --php-blue: #4F5B93;
            --bg-deep: #020305;
            --cyan-glow: rgba(34, 211, 238, 0.4);
        }

        body {
            background-color: var(--bg-deep);
            color: #94a3b8;
            font-family: 'Outfit', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            background-image: 
                radial-gradient(circle at 20% 20%, rgba(79, 91, 147, 0.1) 0%, transparent 40%),
                radial-gradient(circle at 80% 80%, rgba(34, 211, 238, 0.05) 0%, transparent 40%);
        }

        .industrial-grid {
            position: fixed;
            inset: 0;
            z-index: -1;
            background-image: 
                linear-gradient(rgba(136, 146, 191, 0.02) 1px, transparent 1px),
                linear-gradient(90deg, rgba(136, 146, 191, 0.02) 1px, transparent 1px);
            background-size: 50px 50px;
        }

        /* Boot overlay animation */
        #boot-overlay {
            position: fixed;
            inset: 0;
            background: var(--bg-deep);
            z-index: 1000;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            transition: opacity 0.8s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .boot-text {
            font-family: 'JetBrains Mono', monospace;
            font-size: 10px;
            letter-spacing: 0.2em;
            color: var(--php-blue);
            text-transform: uppercase;
        }

        .glass-portal {
            background: linear-gradient(165deg, rgba(15, 23, 42, 0.8), rgba(2, 3, 5, 0.95));
            backdrop-filter: blur(40px);
            border: 1px solid rgba(255, 255, 255, 0.05);
            box-shadow: 0 40px 100px -20px rgba(0, 0, 0, 0.9), inset 0 1px 0 rgba(255,255,255,0.02);
            transition: transform 0.6s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .input-box {
            background: rgba(0, 0, 0, 0.5);
            border: 1px solid rgba(255, 255, 255, 0.05);
            transition: all 0.3s ease;
        }

        .input-box:focus-within {
            border-color: #22d3ee;
            box-shadow: 0 0 20px rgba(34, 211, 238, 0.1);
            transform: translateY(-2px);
        }

        .tech-label {
            font-family: 'JetBrains Mono', monospace;
            text-transform: uppercase;
            letter-spacing: 0.2em;
            opacity: 0.4;
        }

        .btn-glow:hover {
            box-shadow: 0 0 25px var(--cyan-glow);
            filter: brightness(1.1);
        }

        @keyframes scanline {
            0% { transform: translateY(-100%); }
            100% { transform: translateY(100%); }
        }
        .scanline {
            position: absolute;
            inset: 0;
            height: 2px;
            background: linear-gradient(to right, transparent, rgba(34, 211, 238, 0.1), transparent);
            animation: scanline 4s linear infinite;
            pointer-events: none;
        }
    </style>
</head>
<body>
    <div id="boot-overlay">
        <div class="mb-4">
            <i class="ph-bold ph-circle-notch animate-spin text-3xl text-cyan-400"></i>
        </div>
        <div class="boot-text animate-pulse">Iniciando Protocolo de Seguridad...</div>
    </div>

    <div class="industrial-grid"></div>

    <!-- Login Portal -->
    <?php if (!$isLoggedIn): ?>
        <div class="w-full max-w-[280px] p-6 rounded-2xl glass-portal relative overflow-hidden">
            <div class="scanline opacity-10"></div>
            
            <header class="text-center mb-5 relative z-10">
                <div class="w-12 h-12 bg-slate-900/80 rounded-xl mx-auto flex items-center justify-center border border-white/5 mb-4 group">
                    <i class="ph-bold ph-shield-check text-2xl text-cyan-400 group-hover:scale-110 transition-transform"></i>
                </div>
                <h1 class="text-base font-black text-white uppercase tracking-tighter">Acceso Sistema</h1>
                <p class="tech-label text-[6px] mt-1.5 opacity-40">DÍA 16 // MEMOR_AUTH_CORE</p>
            </header>

            <?php if ($error): ?>
                <div class="mb-5 p-2.5 bg-red-400/5 border border-red-500/20 rounded-lg flex items-center gap-2 animate-bounce">
                    <i class="ph-bold ph-warning text-red-500 text-base"></i>
                    <span class="text-[8px] font-mono text-red-400 uppercase font-black"><?= $error ?></span>
                </div>
            <?php endif; ?>

            <form method="POST" class="space-y-4 relative z-10">
                <div class="space-y-1">
                    <label class="tech-label text-[7px] block ml-1">Clave Identificación</label>
                    <div class="input-box flex items-center px-3 py-2 rounded-lg">
                        <i class="ph ph-user text-slate-500 mr-2 text-[10px]"></i>
                        <input type="text" name="username" required placeholder="Usuario" autocomplete="off"
                               class="bg-transparent border-none outline-none text-[10px] text-white w-full">
                    </div>
                </div>

                <div class="space-y-1">
                    <label class="tech-label text-[7px] block ml-1">Token Seguridad</label>
                    <div class="input-box flex items-center px-3 py-2 rounded-lg">
                        <i class="ph ph-key text-slate-500 mr-2 text-[10px]"></i>
                        <input type="password" name="password" required placeholder="••••••••"
                               class="bg-transparent border-none outline-none text-[10px] text-white w-full">
                    </div>
                </div>

                <button type="submit" class="w-full bg-cyan-500 hover:bg-cyan-400 text-black font-black py-3 rounded-lg text-[9px] uppercase tracking-[0.2em] transition-all btn-glow mt-2">
                    Iniciar Sesión
                </button>
            </form>

            <footer class="mt-6 text-center relative z-10">
                <p class="tech-label text-[6px] opacity-20 hover:opacity-50 transition-opacity uppercase">Pista: admin / master85</p>
                <div class="mt-4 pt-4 border-t border-white/5 flex justify-center">
                    <a href="../index.php" class="text-slate-500 hover:text-white transition-colors tech-label text-[7px] flex items-center gap-1.5">
                        <i class="ph ph-arrow-left"></i> Volver al Hub
                    </a>
                </div>
            </footer>
        </div>

    <!-- Dashboard Compacto -->
    <?php else: ?>
        <div class="w-full max-w-[400px] p-8 rounded-2xl glass-portal">
            <header class="flex justify-between items-center mb-6 pb-4 border-b border-white/5">
                <div>
                    <div class="flex items-center gap-1.5 mb-1">
                        <div class="w-1.5 h-1.5 bg-emerald-500 rounded-full animate-pulse"></div>
                        <span class="tech-label text-[7px] text-emerald-500">Sesión_Activa</span>
                    </div>
                    <h1 class="text-lg font-black text-white uppercase tracking-tighter">Panel Control</h1>
                </div>
                <a href="?action=logout" class="px-3 py-1.5 rounded-md border border-red-500/20 text-red-500 tech-label text-[7px] hover:bg-red-500/10 transition-all flex items-center gap-1.5">
                    Cerrar <i class="ph ph-power"></i>
                </a>
            </header>

            <div class="grid grid-cols-2 gap-3 mb-6">
                <div class="bg-black/40 p-4 rounded-xl border border-white/5 text-center">
                    <span class="tech-label text-[6px] block mb-2 opacity-40">Persistencia</span>
                    <span class="text-xl font-black text-white font-mono"><?= str_pad((string)$_SESSION['access_count'], 2, '0', STR_PAD_LEFT) ?></span>
                </div>
                <div class="bg-black/40 p-4 rounded-xl border border-white/5 text-center">
                    <span class="tech-label text-[6px] block mb-2 opacity-40">Uptime</span>
                    <span class="text-xl font-black text-cyan-400 font-mono"><?= time() - $userData['login_time'] ?>s</span>
                </div>
            </div>

            <div class="bg-black/20 rounded-xl border border-white/5 p-4">
                <div class="font-mono text-[9px] space-y-3">
                    <div class="flex justify-between items-center border-b border-white/5 pb-2">
                        <span class="text-slate-500 uppercase tracking-widest text-[7px]">Identidad</span>
                        <span class="text-cyan-400 font-bold">@<?= strtoupper($userData['username']) ?></span>
                    </div>
                    <div class="flex justify-between items-center border-b border-white/5 pb-2">
                        <span class="text-slate-500 uppercase tracking-widest text-[7px]">Session_ID</span>
                        <span class="text-slate-400"><?= substr(session_id(), 0, 8) ?>...</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-slate-500 uppercase tracking-widest text-[7px]">Estado</span>
                        <span class="text-emerald-500 text-[6px] font-black uppercase">Seguro</span>
                    </div>
                </div>
            </div>

            <footer class="mt-8 flex justify-between items-center opacity-40">
                <a href="../index.php" class="hover:text-white transition-colors tech-label text-[7px] flex items-center gap-1.5">
                    <i class="ph ph-arrow-left"></i> Volver al Hub Maestro
                </a>
                <span class="tech-label text-[6px]">v1.0.5 // Estable</span>
            </footer>
        </div>
    <?php endif; ?>

    <script>
        // Simulate real system boot loading
        window.addEventListener('load', () => {
            setTimeout(() => {
                const overlay = document.getElementById('boot-overlay');
                overlay.style.opacity = '0';
                setTimeout(() => overlay.style.display = 'none', 800);
            }, 1200);
        });
    </script>
</body>
</html>
