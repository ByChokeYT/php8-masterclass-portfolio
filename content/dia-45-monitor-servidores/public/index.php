<?php
declare(strict_types=1);

require_once __DIR__ . '/../src/ServerMonitor.php';

use App\ServerMonitor;

$monitor = new ServerMonitor();

$servers = [
    ['name' => 'Google Public DNS', 'host' => '8.8.8.8', 'port' => 53],
    ['name' => 'Localhost Web (PHP Server)', 'host' => '127.0.0.1', 'port' => 8080],
    ['name' => 'GitHub HTTP Service', 'host' => 'github.com', 'port' => 80],
    ['name' => 'Servidor Caído (Prueba)', 'host' => '192.0.2.1', 'port' => 80], // IP reservada para pruebas
];

$results = [];
foreach ($servers as $srv) {
    $results[] = array_merge($srv, $monitor->ping($srv['host'], $srv['port'], 1.5));
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Server Status Monitor</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/@phosphor-icons/web" defer></script>
</head>
<body class="bg-slate-100 p-6 font-sans">
    <div class="max-w-3xl mx-auto bg-white p-6 rounded-xl shadow-md border border-slate-200">
        
        <div class="flex items-center justify-between border-b border-slate-200 pb-4 mb-6">
            <div>
                <h1 class="text-xl font-bold text-slate-800">Monitor de Estado de Servidores</h1>
                <p class="text-xs text-slate-400">Verificación en tiempo real usando sockets TCP en PHP</p>
            </div>
            <a href="index.php" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold rounded-lg transition-colors">
                Forzar Check
            </a>
        </div>

        <div class="space-y-4">
            <?php foreach ($results as $res): ?>
                <div class="p-4 rounded-xl border flex items-center justify-between <?= $res['status'] === 'online' ? 'bg-emerald-50/50 border-emerald-200' : 'bg-red-50/50 border-red-200' ?>">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center <?= $res['status'] === 'online' ? 'bg-emerald-100 text-emerald-600' : 'bg-red-100 text-red-600' ?>">
                            <i class="ph-bold <?= $res['status'] === 'online' ? 'ph-check-circle' : 'ph-x-circle' ?> text-lg"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-sm text-slate-800"><?= htmlspecialchars($res['name']) ?></h3>
                            <p class="text-xs text-slate-500 font-mono"><?= htmlspecialchars($res['host']) ?>:<?= $res['port'] ?></p>
                        </div>
                    </div>

                    <div class="text-right">
                        <?php if ($res['status'] === 'online'): ?>
                            <span class="text-xs font-bold text-emerald-600 bg-emerald-100 px-2.5 py-1 rounded-full">ONLINE</span>
                            <div class="text-xs text-slate-500 font-mono mt-1">Latencia: <?= $res['latency'] ?> ms</div>
                        <?php else: ?>
                            <span class="text-xs font-bold text-red-600 bg-red-100 px-2.5 py-1 rounded-full">OFFLINE</span>
                            <div class="text-xs text-red-500 font-mono mt-1">Error: <?= htmlspecialchars($res['error']) ?></div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

    </div>
</body>
</html>
