<?php
declare(strict_types=1);

require_once __DIR__ . '/../src/AuditLogger.php';

use App\AuditLogger;

$logger = new AuditLogger();

$user = $_GET['user'] ?? 'bychoke_studios';

if (isset($_GET['trigger_action'])) {
    $action = $_GET['trigger_action'];
    $logger->log($action, $user);
    header("Location: index.php?user=" . urlencode($user));
    exit;
}

$logs = $logger->getLogs();

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Log de Auditoría</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100 p-6 font-sans">
    <div class="max-w-4xl mx-auto bg-white p-8 rounded-xl shadow-md border border-slate-200">
        
        <div class="flex items-center justify-between border-b border-slate-200 pb-4 mb-6">
            <div>
                <h1 class="text-xl font-bold text-slate-800">Sistema de Log de Auditoría</h1>
                <p class="text-xs text-slate-400">Trazabilidad de operaciones críticas en base de datos SQLite</p>
            </div>
            
            <div class="flex items-center gap-2">
                <span class="text-xs font-bold text-slate-500">Usuario Simulado:</span>
                <select onchange="location.href='?user=' + this.value" class="border rounded px-2 py-1 text-xs font-bold text-slate-700 bg-slate-50">
                    <option value="bychoke_studios" <?= $user === 'bychoke_studios' ? 'selected' : '' ?>>bychoke_studios (Admin)</option>
                    <option value="operador_regional" <?= $user === 'operador_regional' ? 'selected' : '' ?>>operador_regional</option>
                    <option value="invitado_99" <?= $user === 'invitado_99' ? 'selected' : '' ?>>invitado_99</option>
                </select>
            </div>
        </div>

        <!-- Trigger Actions -->
        <h3 class="text-xs font-bold text-slate-700 mb-3 uppercase tracking-wider">Simular Operación Crítica</h3>
        <div class="flex gap-4 mb-8">
            <a href="?trigger_action=Inicio de Sesión&user=<?= urlencode($user) ?>" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold rounded-lg transition-colors">
                Iniciar Sesión
            </a>
            <a href="?trigger_action=Transferencia de Fondos&user=<?= urlencode($user) ?>" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded-lg transition-colors">
                Transferir Fondos
            </a>
            <a href="?trigger_action=Modificar Parámetros&user=<?= urlencode($user) ?>" class="px-4 py-2 bg-amber-600 hover:bg-amber-700 text-white text-xs font-bold rounded-lg transition-colors">
                Modificar Ajustes
            </a>
        </div>

        <!-- Audit Table -->
        <h3 class="text-xs font-bold text-slate-700 mb-3 uppercase tracking-wider">Últimos 10 Registros en Base de Datos (Inmutable)</h3>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 border border-slate-200 rounded-lg overflow-hidden text-xs">
                <thead class="bg-slate-50 font-bold text-slate-700">
                    <tr>
                        <th class="px-4 py-2 text-left">Fecha/Hora</th>
                        <th class="px-4 py-2 text-left">Operación</th>
                        <th class="px-4 py-2 text-left">Usuario</th>
                        <th class="px-4 py-2 text-left">Dirección IP</th>
                        <th class="px-4 py-2 text-left">Navegador</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 bg-white text-slate-600">
                    <?php if (empty($logs)): ?>
                        <tr>
                            <td colspan="5" class="px-4 py-4 text-center text-slate-400">No se han registrado operaciones.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($logs as $lg): ?>
                            <tr>
                                <td class="px-4 py-2 font-mono whitespace-nowrap"><?= htmlspecialchars($lg['timestamp']) ?></td>
                                <td class="px-4 py-2 font-bold text-slate-800"><?= htmlspecialchars($lg['action']) ?></td>
                                <td class="px-4 py-2 font-mono"><?= htmlspecialchars($lg['user']) ?></td>
                                <td class="px-4 py-2 font-mono"><?= htmlspecialchars($lg['ip_address']) ?></td>
                                <td class="px-4 py-2 text-slate-400 max-w-xs truncate" title="<?= htmlspecialchars($lg['user_agent']) ?>"><?= htmlspecialchars($lg['user_agent']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

    </div>
</body>
</html>
