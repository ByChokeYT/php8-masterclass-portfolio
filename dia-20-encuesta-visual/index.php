<?php
declare(strict_types=1);

require_once __DIR__ . '/src/SurveyManager.php';

use App\SurveyManager;

$manager = new SurveyManager(__DIR__ . '/votes.txt');

// Manejo de AJAX
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['option'])) {
    $manager->vote($_POST['option']);
    header('Content-Type: application/json');
    echo json_encode($manager->getResults());
    exit;
}

if (isset($_GET['results'])) {
    header('Content-Type: application/json');
    echo json_encode($manager->getResults());
    exit;
}

$results = $manager->getResults();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Encuesta Visual | Masterclass PHP</title>
    <link rel="icon" type="image/x-icon" href="https://www.php.net/favicon.ico">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;700;900&family=JetBrains+Mono:wght@400;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <style>
        :root { --bg: #030406; --accent: #8b5cf6; }
        body { background-color: var(--bg); color: #94a3b8; font-family: 'Outfit', sans-serif; overflow: hidden; }
        .industrial-grid {
            position: fixed; inset: 0; z-index: -1;
            background-image: linear-gradient(rgba(255,255,255,0.01) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,0.01) 1px, transparent 1px);
            background-size: 30px 30px;
        }
        .tech-label { font-family: 'JetBrains Mono'; text-transform: uppercase; letter-spacing: 0.1em; font-size: 0.6rem; opacity: 0.4; }
        .glass-panel { background: rgba(13, 17, 23, 0.7); backdrop-filter: blur(20px); border: 1px solid rgba(255,255,255,0.05); }
        .vote-card { transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275); }
        .vote-card:hover { border-color: var(--accent); background: rgba(139, 92, 246, 0.05); transform: translateY(-2px); }
        .progress-bar { transition: width 1s cubic-bezier(0.65, 0, 0.35, 1); }
    </style>
</head>
<body class="h-screen flex items-center justify-center p-8">
    <div class="industrial-grid"></div>

    <div class="w-full max-w-4xl flex flex-col gap-10">
        <!-- Header -->
        <header class="flex justify-between items-end border-b border-white/5 pb-8">
            <div>
                <div class="flex items-center gap-3 mb-2">
                    <div class="p-2 bg-violet-500/10 rounded-lg border border-violet-500/20"><i class="ph-bold ph-chart-bar text-violet-400 text-lg"></i></div>
                    <span class="tech-label">Módulo // Data_Analysis_v20</span>
                </div>
                <h1 class="text-4xl font-black text-white uppercase tracking-tighter">Encuesta <span class="text-violet-400">Lenguajes</span></h1>
            </div>
            <a href="../index.php" class="tech-label hover:text-white transition-colors flex items-center gap-2">
                <i class="ph ph-arrow-left"></i> Volver al Portal
            </a>
        </header>

        <main class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-start">
            <!-- Panel de Votación -->
            <section class="space-y-6">
                <div class="tech-label mb-2">Selecciona tu Entorno Preferido</div>
                <div class="grid grid-cols-2 gap-4" id="optionsContainer">
                    <?php foreach ($results['options'] as $opt): ?>
                        <button onclick="vote('<?= $opt['option'] ?>')" class="vote-card group p-6 rounded-2xl border border-white/5 bg-white/2 text-left relative overflow-hidden">
                            <i class="ph ph-cpu text-2xl mb-4 opacity-20 group-hover:opacity-100 group-hover:text-violet-400 transition-all"></i>
                            <h3 class="text-white font-bold text-lg"><?= $opt['option'] ?></h3>
                            <p class="text-[10px] tech-label mt-1">Runtime_Identity</p>
                        </button>
                    <?php endforeach; ?>
                </div>
            </section>

            <!-- Panel de Resultados -->
            <section class="glass-panel p-8 rounded-[2rem] space-y-8">
                <div class="flex justify-between items-center">
                    <div class="tech-label">Analítica en Tiempo Real</div>
                    <div class="px-3 py-1 rounded-full bg-violet-500/10 border border-violet-500/20 text-[10px] text-violet-400 font-bold">
                        Votos Totales: <span id="totalVotes"><?= $results['total'] ?></span>
                    </div>
                </div>

                <div id="resultsContainer" class="space-y-6">
                    <?php foreach ($results['options'] as $opt): ?>
                        <div class="space-y-2">
                            <div class="flex justify-between text-[11px] font-mono uppercase tracking-widest leading-none">
                                <span class="text-white font-bold"><?= $opt['option'] ?></span>
                                <span class="text-violet-400" id="pct-<?= $opt['option'] ?>"><?= $opt['percentage'] ?>%</span>
                            </div>
                            <div class="h-2 w-full bg-white/5 rounded-full overflow-hidden">
                                <div id="bar-<?= $opt['option'] ?>" class="progress-bar h-full bg-gradient-to-r from-violet-600 to-indigo-500 rounded-full" style="width: <?= $opt['percentage'] ?>%"></div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <footer class="pt-6 border-t border-white/5 flex justify-center">
                    <div class="flex items-center gap-2 opacity-30">
                        <div class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></div>
                        <span class="tech-label">Buffer_Sync: Activo</span>
                    </div>
                </footer>
            </section>
        </main>
    </div>

    <script>
        async function vote(option) {
            const formData = new FormData();
            formData.append('option', option);

            try {
                const response = await fetch('index.php', {
                    method: 'POST',
                    body: formData
                });
                const data = await response.json();
                updateUI(data);
            } catch (err) {
                console.error("Error al votar:", err);
            }
        }

        function updateUI(data) {
            document.getElementById('totalVotes').innerText = data.total;
            data.options.forEach(opt => {
                const bar = document.getElementById(`bar-${opt.option}`);
                const pct = document.getElementById(`pct-${opt.option}`);
                if (bar && pct) {
                    bar.style.width = `${opt.percentage}%`;
                    pct.innerText = `${opt.percentage}%`;
                }
            });
        }
    </script>
</body>
</html>
