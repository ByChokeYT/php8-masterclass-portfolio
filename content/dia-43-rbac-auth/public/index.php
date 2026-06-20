<?php
declare(strict_types=1);

require_once __DIR__ . '/../src/RBAC.php';

use App\RBAC;

$rbac = new RBAC();

// Simulación de sesión
session_start();

if (isset($_GET['switch_role'])) {
    $newRole = $_GET['switch_role'] === 'admin' ? 'admin' : 'cliente';
    $_SESSION['user_role'] = $newRole;
    header("Location: index.php");
    exit;
}

$currentRole = $_SESSION['user_role'] ?? 'cliente';

$action = $_GET['action'] ?? null;
$log = '';

if ($action) {
    if ($rbac->hasPermission($currentRole, $action)) {
        $log = "✅ Acción '{$action}' ejecutada con éxito por el rol: " . strtoupper($currentRole);
    } else {
        $log = "❌ ACCESO DENEGADO: El rol " . strtoupper($currentRole) . " no tiene el permiso '{$action}'!";
    }
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>RBAC - Simulación de Roles</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100 p-6 font-sans">
    <div class="max-w-2xl mx-auto bg-white p-8 rounded-xl shadow-md border border-slate-200">
        <h1 class="text-2xl font-black mb-2 text-slate-800">Control de Acceso basado en Roles (RBAC)</h1>
        <p class="text-slate-500 mb-6 text-sm">Cambia tu rol y experimenta cómo el servidor autoriza o bloquea cada acción crítica.</p>

        <!-- Selector de Rol -->
        <div class="flex items-center gap-4 bg-slate-50 p-4 rounded-lg border border-slate-200 mb-6">
            <span class="text-sm font-bold text-slate-700">Rol Actual:</span>
            <span class="px-3 py-1 text-xs font-black uppercase rounded-full <?= $currentRole === 'admin' ? 'bg-red-100 text-red-700 border border-red-200' : 'bg-blue-100 text-blue-700 border border-blue-200' ?>">
                <?= $currentRole ?>
            </span>
            <div class="ml-auto flex gap-2">
                <a href="?switch_role=cliente" class="px-3 py-1 bg-slate-200 hover:bg-slate-300 text-slate-700 text-xs font-bold rounded">Ser Cliente</a>
                <a href="?switch_role=admin" class="px-3 py-1 bg-red-600 hover:bg-red-700 text-white text-xs font-bold rounded">Ser Admin</a>
            </div>
        </div>

        <!-- Consola de Resultados / Auditoría -->
        <?php if ($log): ?>
            <div class="mb-6 p-4 rounded-lg font-mono text-xs border <?= str_contains($log, 'DENEGADO') ? 'bg-red-50 text-red-700 border-red-200' : 'bg-emerald-50 text-emerald-700 border-emerald-200' ?>">
                <?= htmlspecialchars($log) ?>
            </div>
        <?php endif; ?>

        <!-- Acciones Protegidas -->
        <h3 class="text-sm font-bold text-slate-700 mb-3 uppercase tracking-wider">Acciones del Sistema</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="p-4 bg-slate-50 rounded-lg border border-slate-200 flex flex-col justify-between">
                <div>
                    <h4 class="font-bold text-slate-800 text-sm">Ver Dashboard</h4>
                    <p class="text-xs text-slate-500 mt-1 mb-4">Permiso: <code>view_dashboard</code></p>
                </div>
                <a href="?action=view_dashboard" class="w-full text-center bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold py-2 rounded">Ejecutar</a>
            </div>

            <div class="p-4 bg-slate-50 rounded-lg border border-slate-200 flex flex-col justify-between">
                <div>
                    <h4 class="font-bold text-slate-800 text-sm">Editar Ajustes</h4>
                    <p class="text-xs text-slate-500 mt-1 mb-4">Permiso: <code>edit_settings</code></p>
                </div>
                <a href="?action=edit_settings" class="w-full text-center bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold py-2 rounded">Ejecutar</a>
            </div>

            <div class="p-4 bg-slate-50 rounded-lg border border-slate-200 flex flex-col justify-between">
                <div>
                    <h4 class="font-bold text-slate-800 text-sm">Eliminar Usuario</h4>
                    <p class="text-xs text-slate-500 mt-1 mb-4">Permiso: <code>delete_user</code></p>
                </div>
                <a href="?action=delete_user" class="w-full text-center bg-red-600 hover:bg-red-700 text-white text-xs font-bold py-2 rounded">Ejecutar</a>
            </div>
        </div>

    </div>
</body>
</html>
