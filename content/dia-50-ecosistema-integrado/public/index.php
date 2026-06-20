<?php
declare(strict_types=1);

require_once __DIR__ . '/../src/Core/App.php';

use App\Core\App;

$app = new App();

session_start();

$user = $_SESSION['eco_user'] ?? 'bychoke_graduate';
$role = $_SESSION['eco_role'] ?? 'super_admin';

if (isset($_GET['action'])) {
    $action = $_GET['action'];
    $app->logAction($action, $user);
    $message = "Acción '{$action}' ejecutada y auditada.";
}

$logsCount = $app->getLogsCount();

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ecosistema Integrado // Final</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/@phosphor-icons/web" defer></script>
</head>
<body class="bg-slate-100 p-6 font-sans">
    <div class="max-w-4xl mx-auto bg-white p-8 rounded-xl shadow-md border border-slate-200">
        
        <!-- Header -->
        <div class="flex items-center justify-between border-b border-slate-200 pb-6 mb-6">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-xl bg-indigo-600 flex items-center justify-center text-white text-2xl font-black">
                    🎓
                </div>
                <div>
                    <h1 class="text-2xl font-black text-slate-800">Ecosistema Integrado v10.0</h1>
                    <p class="text-xs text-slate-400">Proyecto de Graduación PHP Masterclass</p>
                </div>
            </div>
            <div class="text-right">
                <span class="text-xs text-slate-400 block">Usuario Autenticado</span>
                <span class="text-sm font-bold text-slate-700"><?= htmlspecialchars($user) ?> (<?= htmlspecialchars($role) ?>)</span>
            </div>
        </div>

        <?php if (isset($message)): ?>
            <div class="mb-6 p-3 bg-indigo-50 border border-indigo-200 rounded text-xs text-indigo-700 font-semibold">
                <?= htmlspecialchars($message) ?>
            </div>
        <?php endif; ?>

        <!-- KPI Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-slate-50 p-5 rounded-xl border border-slate-200">
                <span class="text-xs text-slate-400 font-bold uppercase block mb-1">Métricas de Auditoría</span>
                <span class="text-3xl font-black text-slate-800"><?= $logsCount ?></span>
                <span class="text-xs text-slate-500 block mt-2">Operaciones registradas en SQLite</span>
            </div>
            
            <div class="bg-slate-50 p-5 rounded-xl border border-slate-200">
                <span class="text-xs text-slate-400 font-bold uppercase block mb-1">Seguridad (RBAC)</span>
                <span class="text-lg font-black text-emerald-600">Activo (TLS)</span>
                <span class="text-xs text-slate-500 block mt-2">Firmas y tokens habilitados</span>
            </div>

            <div class="bg-slate-50 p-5 rounded-xl border border-slate-200">
                <span class="text-xs text-slate-400 font-bold uppercase block mb-1">Estado de la Ruta</span>
                <span class="text-lg font-black text-indigo-600">50 / 50 Proyectos</span>
                <span class="text-xs text-slate-500 block mt-2">100% completado con éxito</span>
            </div>
        </div>

        <!-- Acciones consolidadas -->
        <h3 class="text-xs font-bold text-slate-700 mb-3 uppercase tracking-wider">Consola de Control del Ecosistema</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <a href="?action=Auditar Base de Datos" class="p-4 bg-slate-50 border border-slate-200 rounded-lg hover:border-indigo-500 hover:bg-slate-100/50 transition-all flex items-center justify-between">
                <div>
                    <span class="font-bold text-xs text-slate-800 block">Ejecutar Auditoría</span>
                    <span class="text-[10px] text-slate-400">Verifica la integridad de datos</span>
                </div>
                <i class="ph-bold ph-database text-lg text-slate-400"></i>
            </a>

            <a href="?action=Generar Reporte Consolidado" class="p-4 bg-slate-50 border border-slate-200 rounded-lg hover:border-indigo-500 hover:bg-slate-100/50 transition-all flex items-center justify-between">
                <div>
                    <span class="font-bold text-xs text-slate-800 block">Exportar PDF del Sistema</span>
                    <span class="text-[10px] text-slate-400">Genera reporte final consolidado</span>
                </div>
                <i class="ph-bold ph-file-pdf text-lg text-slate-400"></i>
            </a>
        </div>

    </div>
</body>
</html>
