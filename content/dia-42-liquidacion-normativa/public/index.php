<?php
declare(strict_types=1);

require_once __DIR__ . '/../src/Database.php';

use App\Database;

$db = Database::getConnection();

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $empleado = trim($_POST['empleado'] ?? '');
    $salario = (float)($_POST['salario'] ?? 0);

    if ($empleado !== '' && $salario > 0) {
        // AFP Descuento (12.71% estándar)
        $afp = $salario * 0.1271;
        
        // Aporte Nacional Solidario (ejemplo simplificado: 1% del excedente de 13000)
        $aporteSolidario = 0.0;
        if ($salario > 13000) {
            $aporteSolidario = ($salario - 13000) * 0.01;
        }

        $liquido = $salario - $afp - $aporteSolidario;

        // Guardar en la base de datos
        $stmt = $db->prepare("
            INSERT INTO liquidaciones (empleado, salario_basico, descuento_afp, aporte_solidario, liquido_pagable)
            VALUES (:empleado, :salario, :afp, :solidario, :liquido)
        ");
        $stmt->execute([
            ':empleado' => $empleado,
            ':salario' => $salario,
            ':afp' => $afp,
            ':solidario' => $aporteSolidario,
            ':liquido' => $liquido
        ]);

        $message = "¡Liquidación guardada para {$empleado}!";
    } else {
        $message = "Error: Por favor rellene los campos correctamente.";
    }
}

// Obtener históricos
$stmt = $db->query("SELECT * FROM liquidaciones ORDER BY id DESC LIMIT 5");
$historico = $stmt->fetchAll();

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Calculadora de Liquidación Normativa</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100 p-6 font-sans">
    <div class="max-w-4xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-6">
        
        <!-- Formulario -->
        <div class="bg-white p-6 rounded-xl shadow-md border border-slate-200">
            <h2 class="text-xl font-bold mb-4 text-slate-800">Nueva Liquidación</h2>
            
            <?php if ($message): ?>
                <div class="mb-4 p-3 rounded text-sm <?= str_contains($message, 'Error') ? 'bg-red-100 text-red-700' : 'bg-emerald-100 text-emerald-700' ?>">
                    <?= htmlspecialchars($message) ?>
                </div>
            <?php endif; ?>

            <form method="POST">
                <div class="mb-4">
                    <label class="block text-slate-700 text-sm font-bold mb-2">Nombre Empleado</label>
                    <input type="text" name="empleado" required class="shadow appearance-none border rounded w-full py-2 px-3 text-slate-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <div class="mb-4">
                    <label class="block text-slate-700 text-sm font-bold mb-2">Salario Básico (BOB)</label>
                    <input type="number" step="0.01" name="salario" required class="shadow appearance-none border rounded w-full py-2 px-3 text-slate-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline transition-colors">
                    Calcular y Registrar
                </button>
            </form>
        </div>

        <!-- Historial -->
        <div class="bg-white p-6 rounded-xl shadow-md border border-slate-200">
            <h2 class="text-xl font-bold mb-4 text-slate-800">Últimos Registros (SQLite)</h2>
            <div class="space-y-4">
                <?php if (empty($historico)): ?>
                    <p class="text-slate-500 text-sm">No hay registros guardados.</p>
                <?php else: ?>
                    <?php foreach ($historico as $liq): ?>
                        <div class="p-3 bg-slate-50 rounded-lg border border-slate-200 text-xs">
                            <div class="flex justify-between font-bold text-slate-700 mb-1">
                                <span><?= htmlspecialchars($liq['empleado']) ?></span>
                                <span class="text-emerald-600">Neto: BOB <?= number_format($liq['liquido_pagable'], 2) ?></span>
                            </div>
                            <div class="text-slate-500">
                                Salario: BOB <?= number_format($liq['salario_basico'], 2) ?> | AFP (12.71%): BOB <?= number_format($liq['descuento_afp'], 2) ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

    </div>
</body>
</html>
