<?php
declare(strict_types=1);

require_once __DIR__ . '/../src/Classes/RSVP.php';
use App\Classes\RSVP;

$dataFile = __DIR__ . '/../data/reservations.json';
$successMessage = null;
$errorMessage = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $guests = (int)($_POST['guests'] ?? 0);
    $message = $_POST['message'] ?? '';

    try {
        $rsvp = new RSVP($name, $email, $guests, $message, date('Y-m-d H:i:s'));
        
        // Save to JSON
        $data = json_decode(file_get_contents($dataFile), true) ?: [];
        $data[] = $rsvp->toArray();
        file_put_contents($dataFile, json_encode($data, JSON_PRETTY_PRINT));
        
        $successMessage = "¡Gracias, " . htmlspecialchars($rsvp->name) . "! Tu asistencia ha sido confirmada.";
    } catch (InvalidArgumentException $e) {
        $errorMessage = $e->getMessage();
    }
}

// Load current stats
$data = json_decode(file_get_contents($dataFile), true) ?: [];
$totalReservations = count($data);
$totalGuests = array_reduce($data, fn($carry, $item) => $carry + $item['guests'], 0);

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RSVP Premium | Lanzamiento Industrial</title>
    <link rel="icon" type="image/x-icon" href="https://www.php.net/favicon.ico">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;700;900&family=JetBrains+Mono:wght@400;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <style>
        :root {
            /* PHP Official Palette - Refined */
            --php-blue: #4F5B93;
            --php-blue-glow: rgba(79, 91, 147, 0.2);
            --php-blue-light: #8892BF;
            --php-dark: #232733;
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

        /* Technical Background */
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
            background-size: 60px 60px;
            mask-image: radial-gradient(circle at center, black, transparent 80%);
        }

        .coordinate-marker {
            position: absolute;
            font-family: 'JetBrains Mono', monospace;
            font-size: 9px;
            color: var(--php-blue-light);
            opacity: 0.4;
            pointer-events: none;
            letter-spacing: 0.1em;
        }

        /* Glass Panel - Compact */
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
            padding-left: 1.5rem;
        }

        /* Input - Compact & Professional */
        .input-technical {
            background: rgba(6, 7, 10, 0.5);
            border: 1px solid rgba(136, 146, 191, 0.15);
            color: white;
            padding: 0.85rem 1.25rem;
            border-radius: 0.75rem;
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }

        .input-technical:focus {
            border-color: var(--php-blue);
            box-shadow: 0 0 25px var(--php-blue-glow);
            outline: none;
        }

        /* Typography */
        .text-huge {
            font-size: clamp(3rem, 6vw, 5.5rem);
            line-height: 0.9;
            font-weight: 900;
            letter-spacing: -0.04em;
        }

        /* Animations */
        .animate-stagger > * {
            opacity: 0;
            animation: slideIn 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        @keyframes slideIn {
            from { opacity: 0; transform: translateY(15px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .delay-1 { animation-delay: 0.1s; }
        .delay-2 { animation-delay: 0.2s; }

        /* Compact Ticker */
        .ticker-container {
            border-top: 1px solid rgba(136, 146, 191, 0.1);
            background: rgba(6, 7, 10, 0.3);
            padding: 0.75rem;
            overflow: hidden;
            border-bottom-left-radius: 2rem;
            border-bottom-right-radius: 2rem;
        }

        .ticker-track {
            display: flex;
            gap: 3rem;
            animation: ticker 35s linear infinite;
            white-space: nowrap;
        }

        @keyframes ticker {
            from { transform: translateX(30%); }
            to { transform: translateX(-100%); }
        }

        /* Bitácora / Log Styles */
        .log-panel {
            flex: 1;
            min-height: 0;
            display: flex;
            flex-direction: column;
        }

        .log-scroll {
            overflow-y: auto;
            scrollbar-width: thin;
            scrollbar-color: var(--php-blue) transparent;
        }

        .log-scroll::-webkit-scrollbar {
            width: 4px;
        }

        .log-scroll::-webkit-scrollbar-track {
            background: transparent;
        }

        .log-scroll::-webkit-scrollbar-thumb {
            background: var(--php-blue);
            border-radius: 10px;
        }

        /* Scanning Line Animation */
        .scan-line {
            position: absolute;
            left: 0;
            width: 100%;
            height: 2px;
            background: var(--php-blue);
            box-shadow: 0 0 10px var(--php-blue-glow);
            z-index: 10;
            animation: scan 3s linear infinite;
            opacity: 0.1;
        }

        @keyframes scan {
            0% { top: 0; }
            100% { top: 100%; }
        }

        .bitacora-header {
            background: rgba(79, 91, 147, 0.05);
            border-bottom: 1px solid rgba(136, 146, 191, 0.1);
        }

        .btn-php {
            background: var(--php-blue);
            color: white;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.15em;
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }

        .btn-php:hover {
            background: var(--php-blue-light);
            box-shadow: 0 10px 30px var(--php-blue-glow);
            transform: translateY(-2px);
        }

        .btn-php:active {
            transform: translateY(0);
        }
    </style>
</head>
<body class="min-h-screen relative selection:bg-sky-500/30">
<?php
$dayLabel = 'DÍA 13';
$dayTitle = 'Recepción RSVP';
$prevUrl  = '';
$nextUrl  = '';
require_once __DIR__ . '/../../_nav.php';
?>
    <div class="industrial-bg">
        <div class="grid-pattern"></div>
        <span class="coordinate-marker" style="top: 1.5rem; left: 1.5rem;">[NODE: 17.96.67.10]</span>
        <span class="coordinate-marker" style="top: 1.5rem; right: 1.5rem;">PHP_v8.5.5 :: OK</span>
        <span class="coordinate-marker" style="bottom: 1.5rem; left: 1.5rem;">BY_CHOKE_2026</span>
    </div>

    <main class="relative z-10 h-screen flex flex-col items-center justify-center p-4 md:p-8">
        <div class="w-full max-w-6xl grid lg:grid-cols-12 gap-8 items-center">
            
            <!-- Left Content: Industrial Specs & Bitácora -->
            <div class="lg:col-span-12 xl:col-span-5 h-[75vh] flex flex-col gap-4 animate-stagger">
                <div class="industrial-border">
                    <div class="inline-flex items-center gap-2 px-3 py-1 bg-indigo-500/5 border border-indigo-500/10 rounded-full mb-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-[#4F5B93] animate-pulse"></span>
                        <span class="text-[9px] font-black tracking-[0.2em] text-[#8892BF] uppercase">PHP Masterclass Hub v013</span>
                    </div>

                    <h1 class="text-huge">
                        <span class="text-white opacity-90">SISTEMA</span><br>
                        <span style="color: var(--php-blue-light)">RSVP.013</span>
                    </h1>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="glass-panel p-4 rounded-xl border-l-2 border-[#4F5B93] group hover:bg-[#4F5B93]/5 transition-colors">
                        <div class="text-[#8892BF] text-[8px] font-black uppercase tracking-widest mb-0.5">Total_Logs</div>
                        <div class="text-4xl font-black text-white"><?= $totalReservations ?></div>
                    </div>
                    <div class="glass-panel p-4 rounded-xl border-l-2 border-[#8892BF] group hover:bg-[#8892BF]/5 transition-colors">
                        <div class="text-[#8892BF] text-[8px] font-black uppercase tracking-widest mb-0.5">Operacionales</div>
                        <div class="text-4xl font-black text-white"><?= $totalGuests ?></div>
                    </div>
                </div>

                <!-- Bitácora de Sincronización -->
                <div class="glass-panel rounded-2xl flex-1 flex flex-col overflow-hidden">
                    <div class="bitacora-header p-4 flex justify-between items-center relative">
                        <div class="scan-line"></div>
                        <div class="flex items-center gap-2">
                            <i class="ph ph-list-numbers text-[#4F5B93]"></i>
                            <span class="text-[10px] font-black uppercase tracking-widest text-[#8892BF]">Bitácora de Sincronización</span>
                        </div>
                        <span class="text-[8px] font-mono text-[#4F5B93] opacity-60">LIVE_DATA_STREAM</span>
                    </div>

                    <div class="log-scroll flex-1 p-2">
                        <?php if (empty($data)): ?>
                            <div class="h-full flex flex-col items-center justify-center opacity-30 gap-2">
                                <i class="ph ph-database text-4xl"></i>
                                <span class="text-[10px] font-mono">SIN_REGISTROS_DETECTADOS</span>
                            </div>
                        <?php else: ?>
                            <table class="w-full text-left font-mono">
                                <thead class="text-[8px] text-[#4F5B93] uppercase">
                                    <tr>
                                        <th class="p-2">Timestamp</th>
                                        <th class="p-2">Operador</th>
                                        <th class="p-2 text-right">Dot.</th>
                                    </tr>
                                </thead>
                                <tbody class="text-[9px] text-[#8892BF]">
                                    <?php foreach (array_reverse($data) as $row): ?>
                                        <tr class="border-b border-white/5 hover:bg-white/5 transition-colors">
                                            <td class="p-2 opacity-60"><?= substr($row['timestamp'], 11, 8) ?></td>
                                            <td class="p-2 text-white font-bold"><?= htmlspecialchars($row['name']) ?></td>
                                            <td class="p-2 text-right text-emerald-400">+<?= $row['guests'] ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php endif; ?>
                    </div>
                    
                    <div class="p-3 border-t border-white/5 bg-black/20 flex justify-between items-center">
                        <div class="flex gap-1">
                            <div class="w-1 h-1 rounded-full bg-emerald-500 animate-pulse"></div>
                            <div class="w-1 h-1 rounded-full bg-emerald-500 animate-pulse delay-75"></div>
                            <div class="w-1 h-1 rounded-full bg-emerald-500 animate-pulse delay-150"></div>
                        </div>
                        <span class="text-[8px] font-mono opacity-40">SYNC_COMPLETE</span>
                    </div>
                </div>
            </div>

            <!-- Right Content: Confirmation Console -->
            <div class="lg:col-span-12 xl:col-span-7">
                <div class="glass-panel rounded-[2rem] overflow-hidden">
                    <div class="p-8 md:p-10">
                        <div class="flex justify-between items-center mb-10">
                            <div>
                                <h2 class="text-2xl font-black uppercase tracking-tight text-white">Consola de Nodo</h2>
                                <p class="text-[#8892BF] text-xs font-medium opacity-50">Ingrese parámetros de validación.</p>
                            </div>
                            <div class="w-12 h-12 rounded-xl bg-white/5 flex items-center justify-center border border-white/5">
                                <i class="ph-bold ph-key text-[#4F5B93] text-2xl"></i>
                            </div>
                        </div>

                        <?php if ($successMessage): ?>
                            <div class="mb-8 p-4 bg-emerald-500/10 border border-emerald-500/20 rounded-xl flex items-center gap-4">
                                <i class="ph-fill ph-check-circle text-2xl text-emerald-400"></i>
                                <p class="text-emerald-100 font-bold text-sm"><?= $successMessage ?></p>
                            </div>
                        <?php endif; ?>

                        <?php if ($errorMessage): ?>
                            <div class="mb-8 p-4 bg-rose-500/10 border border-rose-500/20 rounded-xl flex items-center gap-4">
                                <i class="ph-fill ph-warning-octagon text-2xl text-rose-400"></i>
                                <p class="text-rose-100 font-bold text-sm"><?= $errorMessage ?></p>
                            </div>
                        <?php endif; ?>

                        <form method="POST" class="space-y-6">
                            <div class="grid md:grid-cols-2 gap-6">
                                <div class="space-y-2">
                                    <label class="text-[9px] font-black uppercase tracking-[0.3em] text-[#8892BF]">Operador</label>
                                    <input type="text" name="name" required class="input-technical w-full" placeholder="NOMBRE">
                                </div>
                                <div class="space-y-2">
                                    <label class="text-[9px] font-black uppercase tracking-[0.3em] text-[#8892BF]">Canal (Email)</label>
                                    <input type="email" name="email" required class="input-technical w-full" placeholder="EMAIL">
                                </div>
                                <div class="space-y-2">
                                    <label class="text-[9px] font-black uppercase tracking-[0.3em] text-[#8892BF]">Dotación</label>
                                    <input type="number" name="guests" min="1" max="10" value="1" required class="input-technical w-full">
                                </div>
                                <div class="space-y-2">
                                    <label class="text-[9px] font-black uppercase tracking-[0.3em] text-[#8892BF]">Firma / Notas</label>
                                    <input type="text" name="message" class="input-technical w-full" placeholder="OPCIONAL">
                                </div>
                            </div>

                            <button type="submit" class="btn-php w-full h-14 rounded-xl">
                                Ejecutar Sincronización
                            </button>
                        </form>
                    </div>

                    <!-- Ticker -->
                    <div class="ticker-container">
                        <div class="ticker-track">
                            <?php foreach (array_merge($data, $data) as $recent): ?>
                                <div class="flex items-center gap-3 text-[10px] font-bold uppercase text-[#8892BF]">
                                    <span class="w-1 h-1 rounded-full bg-emerald-500"></span>
                                    <span class="text-white"><?= htmlspecialchars($recent['name']) ?></span> 
                                    <span class="opacity-30">ACK</span>
                                    <span class="text-[#4F5B93]">+<?= $recent['guests'] ?></span>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer class="fixed bottom-0 left-0 w-full py-6 px-8 flex justify-between items-center opacity-30 pointer-events-none">
        <span class="text-[8px] font-black uppercase tracking-[0.4em] text-[#8892BF]">
            RSVP_PRTCL.8.5
        </span>
        <div class="flex items-center gap-4">
            <img src="https://www.php.net/images/logos/new-php-logo.svg" class="h-4 grayscale" alt="PHP logo">
            <span class="text-[8px] font-mono">HASH: <?= substr(md5(time()), 0, 8) ?></span>
        </div>
    </footer>
</body>
</html>

