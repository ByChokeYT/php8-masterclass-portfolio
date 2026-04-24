<?php
declare(strict_types=1);

require_once __DIR__ . '/../src/Classes/Transaction.php';
require_once __DIR__ . '/../src/Services/BudgetManager.php';

use App\Services\BudgetManager;

$manager = new BudgetManager();
$error = null;

// Handle Form Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        if (isset($_POST['action']) && $_POST['action'] === 'add') {
            $desc = $_POST['description'] ?? '';
            $amount = filter_input(INPUT_POST, 'amount', FILTER_VALIDATE_FLOAT);
            $cat = $_POST['category'] ?? 'General';
            $type = $_POST['type'] ?? 'expense';

            if (!$desc || !$amount || $amount <= 0) {
                throw new Exception("Datos inválidos.");
            }

            $manager->addTransaction($desc, $amount, $cat, $type);
        }
        
        if (isset($_POST['action']) && $_POST['action'] === 'delete') {
            $id = $_POST['id'] ?? '';
            if ($id) $manager->deleteTransaction($id);
        }

        // PRG
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;

    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}

$transactions = $manager->getTransactions();
$balance = $manager->getBalance();
$income = 0;
$expense = 0;

foreach ($transactions as $t) {
    if ($t->type === 'income') $income += $t->amount;
    else $expense += $t->amount;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestor de Gastos</title>
    <link rel="icon" type="image/x-icon" href="https://www.php.net/favicon.ico">
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
</head>
<body>
<?php
$dayLabel = 'DÍA 03';
$dayTitle = 'Gestor de Gastos CLI';
$prevUrl  = '';
$nextUrl  = '';
require_once __DIR__ . '/../../_nav.php';
?>

<div class="dashboard-container">
    
    <!-- Top Summary -->
    <div class="top-bar">
        <div class="card">
            <div class="card-title">Balance Total</div>
            <div class="card-value val-balance">$<?= number_format($balance, 2) ?></div>
        </div>
        <div class="card">
            <div class="card-title">Ingresos</div>
            <div class="card-value val-income">+$<?= number_format($income, 2) ?></div>
        </div>
        <div class="card">
            <div class="card-title">Gastos</div>
            <div class="card-value val-expense">-$<?= number_format($expense, 2) ?></div>
        </div>
    </div>

    <!-- Main Content: Transactions -->
    <div class="main-section">
        <h3 style="margin: 0; display: flex; align-items: center; gap: 0.5rem;">
            <i class="ph-bold ph-list-dashes"></i> Movimientos Recientes
        </h3>
        
        <?php 
        function getCategoryIcon(string $cat): string {
            return match($cat) {
                'Comida' => 'ph-hamburger',
                'Transporte' => 'ph-car',
                'Servicios' => 'ph-lightning',
                'Ocio' => 'ph-popcorn',
                'Salud' => 'ph-heartbeat',
                default => 'ph-wallet'
            };
        }
        ?>

        <?php if (empty($transactions)): ?>
            <div style="text-align: center; color: var(--text-secondary); padding: 2rem;">
                <i class="ph-duotone ph-receipt" style="font-size: 3rem; margin-bottom: 1rem; opacity: 0.5;"></i>
                <p>No hay movimientos registrados.</p>
            </div>
        <?php else: ?>
            <div class="trans-list">
                <?php foreach ($transactions as $t): ?>
                    <div class="trans-item <?= $t->type ?>">
                        <div style="display: flex; gap: 1rem; align-items: center;">
                            <div class="icon-box">
                                <i class="ph-fill <?= getCategoryIcon($t->category) ?>"></i>
                            </div>
                            <div class="t-info">
                                <h4><?= htmlspecialchars($t->description) ?></h4>
                                <span class="t-cat"><?= htmlspecialchars($t->category) ?></span>
                            </div>
                        </div>
                        <div style="display: flex; align-items: center; gap: 1rem;">
                            <span class="t-amount" style="color: var(--accent-<?= $t->type ?>)">
                                <?= $t->type === 'income' ? '+' : '-' ?>$<?= number_format($t->amount, 2) ?>
                            </span>
                            <form method="POST" style="margin:0;">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="id" value="<?= $t->id ?>">
                                <button type="submit" class="t-delete"><i class="ph-bold ph-trash"></i></button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- Sidebar: Add Form -->
    <aside class="form-card">
        <h3 style="margin-top: 0; margin-bottom: 1.5rem;">Nuevo Movimiento</h3>
        
        <form method="POST" id="transForm">
            <input type="hidden" name="action" value="add">
            
            <div class="type-toggle">
                <div class="type-option active inc" onclick="setType('income')" id="opt-inc">
                    <i class="ph-bold ph-arrow-up-right"></i> Ingreso
                </div>
                <div class="type-option" onclick="setType('expense')" id="opt-exp">
                    <i class="ph-bold ph-arrow-down-right"></i> Gasto
                </div>
            </div>
            <input type="hidden" name="type" id="type-input" value="income">

            <div class="form-group">
                <label>Descripción</label>
                <div class="input-wrapper">
                    <i class="ph-bold ph-text-t input-icon"></i>
                    <input type="text" name="description" placeholder="Ej: Sueldo, Supermercado..." required>
                </div>
            </div>

            <div class="form-group">
                <label>Monto</label>
                <div class="input-wrapper">
                    <i class="ph-bold ph-currency-dollar input-icon"></i>
                    <input type="number" step="0.01" name="amount" placeholder="0.00" required>
                </div>
            </div>

            <div class="form-group">
                <label>Categoría</label>
                <div class="input-wrapper">
                    <i class="ph-bold ph-tag input-icon"></i>
                    <select name="category">
                        <option value="General">General</option>
                        <option value="Comida">Comida</option>
                        <option value="Transporte">Transporte</option>
                        <option value="Servicios">Servicios</option>
                        <option value="Ocio">Ocio</option>
                        <option value="Salud">Salud</option>
                    </select>
                </div>
            </div>

            <button type="submit" class="btn-submit btn-income" id="submit-btn">
                <span>Añadir Ingreso</span>
                <i class="ph-bold ph-plus-circle"></i>
            </button>
        </form>
    </aside>

</div>

<script>
    function setType(type) {
        document.getElementById('type-input').value = type;
        const btn = document.getElementById('submit-btn');
        const optInc = document.getElementById('opt-inc');
        const optExp = document.getElementById('opt-exp');

        if (type === 'income') {
            optInc.classList.add('active', 'inc');
            optExp.className = 'type-option';
            btn.className = 'btn-submit btn-income';
            btn.innerHTML = '<i class="ph-bold ph-plus"></i> Añadir Ingreso';
        } else {
            optExp.classList.add('active', 'exp');
            optInc.className = 'type-option';
            btn.className = 'btn-submit btn-expense';
            btn.innerHTML = '<i class="ph-bold ph-minus"></i> Añadir Gasto';
        }
    }
</script>

</body>
</html>
