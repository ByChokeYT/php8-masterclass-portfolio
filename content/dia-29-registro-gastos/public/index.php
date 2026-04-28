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
use App\Models\ExpenseRepository;

$config     = new DatabaseConfig(driver: 'sqlite', database: 'gastos.sqlite');
$repository = new ExpenseRepository(new DatabaseHost($config));

// ── POST: Insertar gasto ──────────────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {

    if ($_POST['action'] === 'add') {
        try {
            $repository->insert(
                desc:     trim($_POST['description'] ?? ''),
                amount:   (float)($_POST['amount']   ?? 0),
                category: $_POST['category'] ?? '',
                date:     $_POST['expense_date'] ?? ''
            );
            $_SESSION['msg'] = ['type' => 'success', 'text' => '¡Gasto registrado correctamente!'];
        } catch (Exception $e) {
            $_SESSION['msg'] = ['type' => 'error', 'text' => $e->getMessage()];
        }
    }

    if ($_POST['action'] === 'delete') {
        $repository->delete((int)($_POST['id'] ?? 0));
        $_SESSION['msg'] = ['type' => 'success', 'text' => 'Gasto eliminado.'];
    }

    header('Location: index.php');
    exit;
}

// ── GET Data ──────────────────────────────────────────────────────
$expenses = $repository->getAll();
$summary  = $repository->getSummary();

$msg = $_SESSION['msg'] ?? null;
unset($_SESSION['msg']);

$catIcons = [
    'Tecnología'   => 'ph-cpu',
    'Alimentación' => 'ph-fork-knife',
    'Transporte'   => 'ph-car',
    'Educación'    => 'ph-book-open',
    'Salud'        => 'ph-heartbeat',
    'Oficina'      => 'ph-briefcase',
];

$categories = ['Tecnología','Alimentación','Transporte','Educación','Salud','Oficina'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DÍA 29 // REGISTRO DE GASTOS // Masterclass PHP</title>
    <link rel="icon" type="image/x-icon" href="https://www.php.net/favicon.ico">
    <link rel="stylesheet" href="assets/css/style.css?v=<?= time() ?>">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
</head>
<body>
<?php
$dayLabel = 'DÍA 29';
$dayTitle = 'Registro de Gastos Diarios';
$prevUrl  = 'http://localhost:8028';
$nextUrl  = 'http://localhost:8030';
require_once __DIR__ . '/../../../_nav.php';
?>

<!-- ── NAV ── -->
<nav class="topnav">
    <div class="nav-brand">
        <div class="icon"><i class="ph-bold ph-wallet"></i></div>
        Expense Tracker
    </div>
    <span class="nav-meta">DÍA 29 // MASTERCLASS PHP 8.5 // BYCHOKE</span>
</nav>

<!-- ── WRAPPER ── -->
<div class="wrapper">

    <!-- ════ LEFT COLUMN ════ -->
    <aside class="left-col">

        <!-- FORM -->
        <div class="panel">
            <div class="panel-title"><i class="ph-bold ph-plus-circle"></i> Nuevo Gasto</div>

            <?php if ($msg): ?>
                <div class="alert alert-<?= $msg['type'] ?>">
                    <?= htmlspecialchars($msg['text']) ?>
                </div>
            <?php endif; ?>

            <form class="form-stack" method="POST" action="index.php">
                <input type="hidden" name="action" value="add">

                <div>
                    <label>Descripción</label>
                    <input type="text" name="description" placeholder="Ej. Internet Fibra Óptica" required>
                </div>

                <div>
                    <label>Monto (Bs.)</label>
                    <input type="number" name="amount" step="0.01" min="0.01" placeholder="0.00" required>
                </div>

                <div>
                    <label>Categoría</label>
                    <select name="category" required>
                        <option value="">— Seleccionar —</option>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?= $cat ?>">
                                <?= $cat ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div>
                    <label>Fecha</label>
                    <input type="date" name="expense_date" value="<?= date('Y-m-d') ?>" required>
                </div>

                <button type="submit" class="btn-add">
                    <i class="ph-bold ph-plus"></i> Registrar Gasto
                </button>
            </form>
        </div>

        <!-- STATS -->
        <div class="panel">
            <div class="panel-title"><i class="ph-bold ph-chart-bar"></i> Resumen General</div>
            <div class="stats-grid">
                <div class="stat-card">
                    <span class="val">Bs. <?= number_format($summary['total'], 0) ?></span>
                    <span class="lbl">Total Gastos</span>
                </div>
                <div class="stat-card">
                    <span class="val"><?= count($expenses) ?></span>
                    <span class="lbl">Registros</span>
                </div>
                <div class="stat-card">
                    <span class="val"><?= count($summary['byCategory']) ?></span>
                    <span class="lbl">Categorías</span>
                </div>
                <div class="stat-card">
                    <span class="val">Bs. <?= $summary['total'] > 0 ? number_format($summary['total'] / max(count($expenses), 1), 0) : 0 ?></span>
                    <span class="lbl">Promedio</span>
                </div>
            </div>
        </div>

        <!-- CATEGORY BREAKDOWN -->
        <div class="panel">
            <div class="panel-title"><i class="ph-bold ph-chart-pie-slice"></i> Por Categoría</div>
            <div class="cat-list">
                <?php foreach ($summary['byCategory'] as $cat): ?>
                    <?php $pct = $summary['total'] > 0 ? ($cat['total'] / $summary['total']) * 100 : 0; ?>
                    <div class="cat-item">
                        <div class="cat-header">
                            <span class="cat-name">
                                <i class="ph <?= $catIcons[$cat['category']] ?? 'ph-tag' ?>" style="margin-right: 0.3rem;"></i>
                                <?= htmlspecialchars($cat['category']) ?>
                            </span>
                            <span class="cat-amount">Bs. <?= number_format($cat['total'], 2) ?></span>
                        </div>
                        <div class="cat-bar">
                            <div class="cat-bar-fill" style="width: <?= round($pct) ?>%"></div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

    </aside>

    <!-- ════ RIGHT COLUMN ════ -->
    <main class="right-col">

        <div class="table-header">
            <h1 class="table-title">Historial de Gastos</h1>
            <span class="count-badge"><?= count($expenses) ?> registros</span>
        </div>

        <div class="expense-list">
            <?php if (empty($expenses)): ?>
                <div style="text-align:center; padding: 5rem; color: var(--muted);">
                    <i class="ph ph-receipt" style="font-size: 3rem; display:block; margin-bottom:1rem;"></i>
                    No hay gastos registrados aún.
                </div>
            <?php else: ?>
                <?php foreach ($expenses as $exp): ?>
                    <?php $colorClass = 'cat-color-' . str_replace(' ', '', $exp->category); ?>
                    <div class="expense-row">
                        <div class="cat-dot <?= $colorClass ?>">
                            <i class="ph <?= $catIcons[$exp->category] ?? 'ph-receipt' ?>"></i>
                        </div>

                        <div>
                            <div class="exp-desc"><?= htmlspecialchars($exp->description) ?></div>
                            <div class="exp-date"><?= $exp->formattedDate() ?></div>
                        </div>

                        <span class="exp-cat-tag"><?= htmlspecialchars($exp->category) ?></span>

                        <span class="exp-amount"><?= $exp->formattedAmount() ?></span>

                        <form method="POST" onsubmit="return confirm('¿Eliminar este gasto?')">
                            <input type="hidden" name="action" value="delete">
                            <input type="hidden" name="id" value="<?= $exp->id ?>">
                            <button type="submit" class="btn-del"><i class="ph ph-trash"></i></button>
                        </form>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <footer style="margin-top:4rem; text-align:center; opacity:.4; font-family:'JetBrains Mono',monospace; font-size:.75rem;">
            &copy; 2026 TITANIUM MASTERCLASS // PHP 8.5.5 // DESIGNED BY BYCHOKE
        </footer>
    </main>

</div>
</body>
</html>
