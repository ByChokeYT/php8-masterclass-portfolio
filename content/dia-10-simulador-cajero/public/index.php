<?php

declare(strict_types=1);

session_start();

require_once __DIR__ . '/../src/Classes/CajeroAutomatico.php';

use App\Classes\CajeroAutomatico;

// Iniciar sesión con un saldo por defecto
if (!isset($_SESSION['saldo'])) {
    $_SESSION['saldo'] = 2500.0;
}

$cajero = new CajeroAutomatico($_SESSION['saldo']);
$mensaje = '';
$tipoMensaje = '';
$isSessionActive = true;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $accion = $_POST['accion'] ?? '';
    $montoStr = $_POST['monto'] ?? '';
    // Limpiar comas por si acaso y castear a float
    $monto = is_numeric(str_replace(',', '', $montoStr)) ? (float) str_replace(',', '', $montoStr) : 0;

    try {
        switch ($accion) {
            case 'depositar':
                if ($monto <= 0) {
                     throw new \InvalidArgumentException("Ingresa un monto válido mayor a 0.");
                }
                $cajero->depositar($monto);
                $_SESSION['saldo'] = $cajero->consultarSaldo();
                $mensaje = "Depósito de Bs. " . number_format($monto, 2) . " exitoso.";
                $tipoMensaje = 'success';
                break;

            case 'retirar':
                if ($monto <= 0) {
                     throw new \InvalidArgumentException("Ingresa un monto válido mayor a 0.");
                }
                $cajero->retirar($monto);
                $_SESSION['saldo'] = $cajero->consultarSaldo();
                $mensaje = "Retiro exitoso de Bs. " . number_format($monto, 2) . ".";
                $tipoMensaje = 'success';
                break;

            case 'salir':
                 session_destroy();
                 $mensaje = "Sesión cerrada. Retire su tarjeta.";
                 $tipoMensaje = 'info';
                 $isSessionActive = false;
                 $cajero = new CajeroAutomatico(0); // Para resetear la vista
                 break;

            case 'reiniciar':
                $_SESSION['saldo'] = 2500.0;
                $cajero = new CajeroAutomatico($_SESSION['saldo']);
                $mensaje = "Sistema reiniciado. Bienvenido.";
                $tipoMensaje = 'success';
                $isSessionActive = true;
                break;

            default:
                throw new \InvalidArgumentException("Acción no reconocida.");
        }
    } catch (\Exception $e) {
        $mensaje = $e->getMessage();
        $tipoMensaje = 'error';
    }
}
?>
<!DOCTYPE html>
<html lang="es" class="antialiased">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cajero Virtual ATM | UI Premium Compact</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                    animation: {
                        'fade-in': 'fadeIn 0.3s ease-out forwards',
                        'slide-up': 'slideUp 0.3s ease-out forwards',
                    },
                    keyframes: {
                        fadeIn: { '0%': { opacity: '0' }, '100%': { opacity: '1' } },
                        slideUp: { '0%': { opacity: '0', transform: 'translateY(10px)' }, '100%': { opacity: '1', transform: 'translateY(0)' } }
                    }
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="/favicon.ico">
    <style>
        input[type="number"]::-webkit-inner-spin-button, 
        input[type="number"]::-webkit-outer-spin-button { -webkit-appearance: none; margin: 0; }
        input[type="number"] { -moz-appearance: textfield; }
        
        .glass-panel {
            background: rgba(15, 23, 42, 0.7);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.08);
        }
        .screen-inner {
            background: #0f172a;
            box-shadow: inset 0 2px 8px rgba(0,0,0,0.6);
        }
    </style>
</head>
<body class="bg-[#020617] text-slate-200 min-h-screen flex items-center justify-center p-4 relative overflow-hidden selection:bg-cyan-500/30">
<?php
$dayLabel = 'DÍA 10';
$dayTitle = 'Simulador de Cajero ATM';
$prevUrl  = '';
$nextUrl  = '';
require_once __DIR__ . '/../../../_nav.php';
?>

    <!-- Ambient glow -->
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[300px] h-[300px] bg-cyan-600/20 rounded-full blur-[80px] pointer-events-none"></div>

    <!-- Main Container (Smaller width max-w-[340px]) -->
    <main class="relative z-10 w-full max-w-[340px] glass-panel rounded-2xl p-1 shadow-2xl shadow-cyan-900/10 animate-slide-up">
        
        <div class="bg-slate-900 rounded-[14px] p-5 border border-slate-800 relative">
            
            <!-- Header -->
            <header class="flex justify-between items-center mb-5 relative z-10">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-cyan-500 to-blue-600 flex items-center justify-center shadow-lg shadow-blue-500/20">
                        <!-- Icono de tarjeta limpio (Heroicons SVG) en lugar de emoji -->
                        <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-base font-semibold text-white leading-tight">ByBank</h1>
                        <p class="text-[9px] text-cyan-400 font-medium tracking-wider uppercase">ATM Virtual</p>
                    </div>
                </div>
                <!-- Status Dots -->
                <div class="flex gap-1 border border-slate-700 px-2 py-1 rounded-full bg-slate-800">
                    <div class="w-1.5 h-1.5 rounded-full bg-cyan-400 animate-pulse"></div>
                </div>
            </header>

            <!-- Screen Area -->
            <div class="screen-inner rounded-xl p-4 border border-slate-700/50 mb-5 relative overflow-hidden">
                <div class="absolute top-0 left-0 right-0 h-1/2 bg-gradient-to-b from-white/5 to-transparent pointer-events-none"></div>
                
                <?php if ($isSessionActive): ?>
                    <div class="text-center animate-fade-in py-2">
                        <p class="text-slate-400 text-xs font-medium mb-1">Saldo Disponible</p>
                        <h2 class="text-3xl font-bold text-white tracking-tight flex justify-center items-center gap-1">
                            <span class="text-lg text-cyan-400 font-normal">Bs.</span>
                            <?= number_format($cajero->consultarSaldo(), 2) ?>
                        </h2>
                    </div>
                <?php else: ?>
                    <div class="text-center py-4 animate-fade-in flex flex-col items-center">
                        <svg class="w-8 h-8 text-cyan-500 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                           <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <h2 class="text-lg font-medium text-white mb-1">Hasta Pronto</h2>
                        <p class="text-slate-400 text-xs">Sesión finalizada</p>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Notifications / Alerts sin emojis -->
            <?php if ($mensaje): ?>
                <div class="animate-fade-in mb-4 px-3 py-2.5 rounded-lg text-xs font-medium flex items-start gap-2
                    <?= $tipoMensaje === 'success' ? 'bg-emerald-500/10 text-emerald-400 border border-emerald-500/20' : '' ?>
                    <?= $tipoMensaje === 'error' ? 'bg-rose-500/10 text-rose-400 border border-rose-500/20' : '' ?>
                    <?= $tipoMensaje === 'info' ? 'bg-blue-500/10 text-blue-400 border border-blue-500/20' : '' ?>
                ">
                    <?php if ($tipoMensaje === 'success'): ?>
                        <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                    <?php elseif ($tipoMensaje === 'error'): ?>
                        <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    <?php else: ?>
                        <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    <?php endif; ?>
                    <p class="leading-relaxed"><?= htmlspecialchars($mensaje) ?></p>
                </div>
            <?php endif; ?>

            <!-- Controls -->
            <div class="relative z-10">
                <?php if ($isSessionActive): ?>
                    <form method="POST" action="" class="space-y-3 animate-fade-in">
                        
                        <!-- Input monto -->
                        <div class="relative flex items-center group">
                            <div class="absolute left-3.5 z-10 text-slate-500 group-focus-within:text-cyan-400 transition-colors">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <input type="number" name="monto" id="monto" step="0.01" min="0" required
                                class="w-full bg-slate-950/50 border border-slate-700/80 text-white rounded-lg py-2.5 pl-10 pr-3 text-sm placeholder-slate-600 focus:outline-none focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500 transition-all font-medium"
                                placeholder="Monto (Ej. 150)">
                        </div>

                        <!-- Botones de Acción -->
                        <div class="grid grid-cols-2 gap-2">
                            <button type="submit" name="accion" value="depositar" 
                                    class="flex items-center justify-center gap-1.5 rounded-lg bg-slate-800 border border-slate-700 hover:border-cyan-500/50 hover:text-cyan-400 py-2.5 transition-colors active:bg-slate-700 text-slate-300">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" /></svg>
                                <span class="text-xs font-medium">Depositar</span>
                            </button>
                            
                            <button type="submit" name="accion" value="retirar" 
                                    class="flex items-center justify-center gap-1.5 rounded-lg bg-slate-800 border border-slate-700 hover:border-blue-500/50 hover:text-blue-400 py-2.5 transition-colors active:bg-slate-700 text-slate-300">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" /></svg>
                                <span class="text-xs font-medium">Retirar</span>
                            </button>
                        </div>

                        <button type="submit" name="accion" value="salir" formnovalidate
                                class="w-full flex items-center justify-center gap-1.5 py-2.5 mt-1 rounded-lg border border-slate-700 text-slate-400 text-xs font-medium hover:bg-slate-800 hover:text-rose-400 hover:border-rose-500/30 transition-colors">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                            Retirar Tarjeta
                        </button>
                    </form>
                <?php else: ?>
                    <form method="POST" action="" class="animate-fade-in mt-3">
                        <button type="submit" name="accion" value="reiniciar" 
                                class="w-full flex items-center justify-center gap-2 bg-cyan-600 hover:bg-cyan-500 text-white py-2.5 rounded-lg text-sm font-medium transition-colors shadow-lg shadow-cyan-500/20 active:scale-95">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" /></svg>
                            Insertar Tarjeta
                        </button>
                    </form>
                <?php endif; ?>
            </div>

        </div>
    </main>

</body>
</html>
