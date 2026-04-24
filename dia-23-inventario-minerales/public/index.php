<?php

declare(strict_types=1);

session_start();

spl_autoload_register(function ($class) {
    if (str_starts_with($class, 'App\\')) {
        $file = __DIR__ . '/../src/' . str_replace(['App\\', '\\'], ['', '/'], $class) . '.php';
        if (file_exists($file)) require $file;
    }
});

use App\Config\DatabaseConfig;
use App\DatabaseHost;
use App\InventoryManager;

$config = new DatabaseConfig(driver: 'sqlite', database: 'mineria_transaccional.sqlite');
$manager = new InventoryManager(new DatabaseHost($config));

$notification = null;

if (isset($_SESSION['notification'])) {
    $notification = $_SESSION['notification'];
    unset($_SESSION['notification']);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $mineralId = (int)$_POST['mineral_id'];
        $type = $_POST['type']; // 'IN' or 'OUT'
        $quantity = (float)$_POST['quantity'];
        $reason = trim($_POST['reason'] ?? 'Sin motivo especificado');

        if ($manager->recordMovement($mineralId, $type, $quantity, $reason)) {
            $_SESSION['notification'] = ['type' => 'success', 'msg' => 'Movimiento registrado con éxito.'];
        }
    } catch (Exception $e) {
        $_SESSION['notification'] = ['type' => 'error', 'msg' => $e->getMessage()];
    }
    
    // PATRÓN PRG (Post/Redirect/Get) para evitar reenvío de formulario al recargar
    header('Location: index.php');
    exit;
}

$stock = $manager->getStock();
$logs = $manager->getLogs(15);

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>DÍA 23 // INVENTARIO TRANSACCIONAL // Masterclass PHP</title>
    <link rel="icon" type="image/x-icon" href="https://www.php.net/favicon.ico">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;700;900&family=JetBrains+Mono:wght@400;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <link rel="stylesheet" href="assets/css/style.css?v=<?= time() ?>">
</head>
<body>
<?php
$dayLabel = 'DÍA 23';
$dayTitle = 'Inventario de Minerales';
$prevUrl  = 'http://localhost:8022';
$nextUrl  = 'http://localhost:8024';
require_once __DIR__ . '/../../_nav.php';
?>
    <div class="industrial-grid"></div>

    <div class="container">
        <header class="header">
            <h1>Logística de Minerales</h1>
            <a href="http://localhost:8000" class="tech-label hover:text-white flex items-center gap-2" style="text-decoration: none; font-size: 0.65rem;">
                <i class="ph ph-arrow-left"></i> Volver al Portal
            </a>
        </header>

        <?php if ($notification): ?>
            <div class="alert alert-<?= $notification['type'] ?>">
                <i class="ph-bold ph-<?= $notification['type'] === 'success' ? 'check-circle' : 'warning-octagon' ?>"></i>
                <?= $notification['msg'] ?>
            </div>
        <?php endif; ?>

        <div class="dashboard-layout">
            <!-- PANEL 1: INVENTARIO -->
            <section class="panel">
                <div class="panel-header">
                    <i class="ph-fill ph-cube"></i>
                    <h2>Resumen de Stock</h2>
                </div>
                <div class="stock-list">
                    <?php foreach ($stock as $item): ?>
                        <div class="mineral-card">
                            <div class="card-info">
                                <span class="card-unit"><?= $item['symbol'] ?> • Kilogramos</span>
                                <span class="card-name"><?= $item['name'] ?></span>
                            </div>
                            <div class="card-value">
                                <?= number_format($item['stock'], 1) ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </section>

            <!-- PANEL 2: PROCESAMIENTO -->
            <section class="panel">
                <div class="panel-header">
                    <i class="ph-fill ph-arrows-left-right"></i>
                    <h2>Nueva Transacción</h2>
                </div>
                <form method="POST">
                    <div class="form-group">
                        <label>Recurso Mineral</label>
                        <select name="mineral_id" required>
                            <?php foreach ($stock as $item): ?>
                                <option value="<?= $item['id'] ?>"><?= $item['name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Tipo de Movimiento</label>
                        <select name="type" required>
                            <option value="IN">Entrada (Reposición)</option>
                            <option value="OUT">Salida (Despacho)</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Cantidad (Kg)</label>
                        <input type="number" name="quantity" step="0.1" min="0.1" placeholder="0.0" required>
                    </div>
                    <div class="form-group">
                        <label>Referencia / Lote</label>
                        <input type="text" name="reason" placeholder="Ej. Lote-XP-2024" required>
                    </div>
                    <button type="submit" class="btn-submit">Sincronizar Stock</button>
                </form>
            </section>

            <!-- PANEL 3: AUDITORÍA -->
            <section class="panel">
                <div class="panel-header">
                    <i class="ph-fill ph-shield-check"></i>
                    <h2>Registro de Auditoría</h2>
                </div>
                <div class="log-panel">
                    <table class="audit-table">
                        <thead>
                            <tr>
                                <th>Timestamp</th>
                                <th>Mineral</th>
                                <th>Operación</th>
                                <th>Cantidad</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($logs)): ?>
                                <tr><td colspan="4" align="center" style="opacity: 0.3; padding: 4rem;">Sin transacciones.</td></tr>
                            <?php endif; ?>
                            <?php foreach ($logs as $l): ?>
                                <tr>
                                    <td>
                                        <div style="font-weight: 700; color: var(--white);"><?= date('H:i', strtotime($l['created_at'])) ?></div>
                                        <div style="font-size: 0.65rem; color: var(--text-dim);"><?= date('d/m/y', strtotime($l['created_at'])) ?></div>
                                    </td>
                                    <td>
                                        <div style="font-weight: 800;"><?= $l['mineral_name'] ?></div>
                                        <div style="font-size: 0.65rem; color: var(--accent);"><?= $l['symbol'] ?></div>
                                    </td>
                                    <td>
                                        <span class="badge badge-<?= strtolower($l['type']) ?>">
                                            <?= $l['type'] === 'IN' ? 'Entrada' : 'Salida' ?>
                                        </span>
                                    </td>
                                    <td style="font-family: 'JetBrains Mono'; font-weight: 800; <?= $l['type'] === 'IN' ? 'color: var(--success);' : 'color: var(--error);' ?>">
                                        <?= $l['type'] === 'IN' ? '+' : '-' ?><?= number_format($l['quantity'], 1) ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </div>
</body>
</html>
