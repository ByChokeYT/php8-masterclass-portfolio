<?php
declare(strict_types=1);

require_once __DIR__ . '/../src/Classes/Loan.php';
require_once __DIR__ . '/../src/Services/AmortizationService.php';

use App\Classes\Loan;
use App\Services\AmortizationService;

$result = null;

// Defaults
$amount = 10000;
$rate = 5.0; // Annual
$term = 12; // Months

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $amount = (float) ($_POST['amount'] ?? 10000);
    $rate = (float) ($_POST['rate'] ?? 5.0);
    $term = (int) ($_POST['term'] ?? 12);

    $loan = new Loan($amount, $rate, $term);
    $service = new AmortizationService();
    $result = $service->calculate($loan);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simulador de Préstamos</title>
    <link rel="icon" type="image/x-icon" href="https://www.php.net/favicon.ico">
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
</head>
<body>
<?php
$dayLabel = 'DÍA 04';
$dayTitle = 'Simulador de Préstamos';
$prevUrl  = '';
$nextUrl  = '';
require_once __DIR__ . '/../../_nav.php';
?>

<div class="container">
    
    <!-- Input Panel -->
    <aside class="input-panel">
        <div style="display: flex; align-items: center; gap: 0.8rem; margin-bottom: 2rem;">
            <i class="ph-duotone ph-bank" style="font-size: 2rem; color: var(--accent-primary);"></i>
            <h2 style="margin: 0;">Simulador</h2>
        </div>

        <form method="POST" id="loanForm">
            <!-- Amount -->
            <div class="form-group">
                <label>
                    Monto del Préstamo
                    <span class="input-display" id="disp-amount">$<?= number_format($amount) ?></span>
                </label>
                <input type="range" name="amount" min="1000" max="100000" step="500" value="<?= $amount ?>" oninput="updateDisp('amount', '$', this.value)">
                <div class="input-wrapper">
                    <i class="ph ph-currency-dollar input-icon"></i>
                    <input type="number" class="number-input" value="<?= $amount ?>" onchange="updateRange('amount', this.value)">
                </div>
            </div>

            <!-- Term -->
            <div class="form-group">
                <label>
                    Plazo (Meses)
                    <span class="input-display" id="disp-term"><?= $term ?> meses</span>
                </label>
                <input type="range" name="term" min="3" max="60" step="1" value="<?= $term ?>" oninput="updateDisp('term', '', this.value, ' meses')">
            </div>

            <!-- Rate -->
            <div class="form-group">
                <label>
                    Tasa Anual (%)
                    <span class="input-display" id="disp-rate"><?= $rate ?>%</span>
                </label>
                <input type="range" name="rate" min="1" max="50" step="0.1" value="<?= $rate ?>" oninput="updateDisp('rate', '', this.value, '%')">
            </div>

            <button type="submit" class="btn-calc">
                Calcular Cuotas <i class="ph-bold ph-calculator"></i>
            </button>
        </form>
    </aside>

    <!-- Result Panel -->
    <main class="result-panel">
        <?php if ($result): ?>
            <!-- Summary -->
            <div class="summary-grid">
                <div class="card">
                    <div class="card-label">Cuota Mensual</div>
                    <div class="card-value highlight">$<?= number_format($result['summary']['monthly_payment'], 2) ?></div>
                </div>
                <div class="card">
                    <div class="card-label">Interés Total</div>
                    <div class="card-value">$<?= number_format($result['summary']['total_interest'], 2) ?></div>
                </div>
                <div class="card">
                    <div class="card-label">Total a Pagar</div>
                    <div class="card-value">$<?= number_format($result['summary']['total_payment'], 2) ?></div>
                </div>
            </div>

            <!-- Table -->
            <div class="table-container">
                <div class="table-header">
                    <h3><i class="ph-bold ph-table"></i> Tabla de Amortización</h3>
                    <span style="font-size: 0.8rem; color: var(--text-secondary);">Sistema Francés</span>
                </div>
                <div class="table-scroll">
                    <table class="schedule-table">
                        <thead>
                            <tr>
                                <th>Mes</th>
                                <th>Cuota</th>
                                <th>Interés</th>
                                <th>Capital</th>
                                <th>Saldo</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($result['schedule'] as $row): ?>
                                <tr>
                                    <td><?= $row['month'] ?></td>
                                    <td>$<?= number_format($row['payment'], 2) ?></td>
                                    <td style="color: var(--accent-secondary);">$<?= number_format($row['interest'], 2) ?></td>
                                    <td style="color: var(--accent-success);">$<?= number_format($row['principal'], 2) ?></td>
                                    <td>$<?= number_format($row['balance'], 2) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php else: ?>
            <div style="flex: 1; display: flex; align-items: center; justify-content: center; flex-direction: column; color: var(--text-secondary); opacity: 0.5;">
                <i class="ph-duotone ph-chart-line-up" style="font-size: 5rem; margin-bottom: 1rem;"></i>
                <p>Ingresa los datos para ver tu plan de pagos.</p>
            </div>
        <?php endif; ?>
    </main>

</div>

<script>
    function updateDisp(id, prefix, val, suffix = '') {
        document.getElementById('disp-' + id).innerText = prefix + Number(val).toLocaleString() + suffix;
        if(id === 'amount') document.querySelector('input[type=number]').value = val;
    }
    function updateRange(id, val) {
        document.querySelector('input[name=' + id + ']').value = val;
        updateDisp(id, '$', val);
    }
</script>

</body>
</html>
