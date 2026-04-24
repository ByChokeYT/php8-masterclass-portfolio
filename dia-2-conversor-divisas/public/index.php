<?php
declare(strict_types=1);

session_start();

require_once __DIR__ . '/../src/Enums/Currency.php';
require_once __DIR__ . '/../src/Services/ConverterService.php';

use App\Enums\Currency;
use App\Services\ConverterService;

// History Logic
if (!isset($_SESSION['history_v2'])) {
    $_SESSION['history_v2'] = [];
}

// Clear History
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'clear_history') {
    $_SESSION['history_v2'] = [];
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

$resultData = null;
$error = null;

// Recover Flash Data (PRG)
if (isset($_SESSION['flash_result'])) {
    $resultData = $_SESSION['flash_result'];
    unset($_SESSION['flash_result']);
    session_write_close();
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_POST['action'])) {
    try {
        $amount = filter_input(INPUT_POST, 'amount', FILTER_VALIDATE_FLOAT);
        $fromCode = $_POST['from_currency'] ?? '';
        $toCode = $_POST['to_currency'] ?? '';

        if (!$amount) {
            throw new Exception("Por favor ingrese un monto válido.");
        }

        $from = Currency::tryFrom($fromCode);
        $to = Currency::tryFrom($toCode);

        if (!$from || !$to) {
            throw new Exception("Monedas no válidas.");
        }

        $service = new ConverterService();
        $convertedAmount = $service->convert($amount, $from, $to);

        $currentCalc = [
            'from_flag' => $from->getFlag(),
            'from_code' => $from->value,
            'amount' => $amount,
            'to_flag' => $to->getFlag(),
            'to_code' => $to->value,
            'result' => $convertedAmount,
            'time' => date('H:i:s')
        ];

        // Save History
        array_unshift($_SESSION['history_v2'], $currentCalc);
        if (count($_SESSION['history_v2']) > 5) array_pop($_SESSION['history_v2']);

        // Flash & Redirect
        $_SESSION['flash_result'] = $currentCalc;
        session_write_close();
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;

    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Conversor Divisas Pro</title>
    <link rel="icon" type="image/x-icon" href="https://www.php.net/favicon.ico">
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
</head>
<body>
<?php
$dayLabel = 'DÍA 02';
$dayTitle = 'Conversor de Divisas';
$prevUrl  = '';
$nextUrl  = '';
require_once __DIR__ . '/../../_nav.php';
?>

    <div class="container glass-effect">
        
        <header>
            <div class="logo-area">
                <i class="ph-duotone ph-arrows-left-right size-lg"></i>
                <div>
                    <h1>PHP Exchange</h1>
                    <p class="subtitle">Conversor Profesional 8.5</p>
                </div>
            </div>
        </header>

        <!-- Live Calculation Display -->
        <?php if ($resultData): ?>
            <div class="live-result fade-in">
                <div class="label">Tasa de Cambio Estimada</div>
                <div class="value">
                    <?= number_format($resultData['result'], 2) ?> <small><?= $resultData['to_code'] ?></small>
                </div>
                <div class="sub">
                    1 <?= $resultData['from_code'] ?> ≈ <?= number_format($resultData['result'] / $resultData['amount'], 4) ?> <?= $resultData['to_code'] ?>
                </div>
            </div>
        <?php else: ?>
            <div class="live-result fade-in">
                <div class="label">Mercado de Divisas</div>
                <div class="value" style="color: var(--text-muted); opacity: 0.5;">0.00</div>
                <div class="sub" style="opacity: 0;">-</div>
            </div>
        <?php endif; ?>

        <form method="POST">
            <div class="trading-box">
                <!-- From Row -->
                <div class="currency-row">
                    <div class="currency-selector">
                        <label>Vender (Origen)</label>
                        <select name="from_currency">
                            <?php foreach(Currency::cases() as $curr): ?>
                                <option value="<?= $curr->value ?>" <?= ($curr === Currency::USD) ? 'selected' : '' ?>>
                                    <?= $curr->getFlag() ?> <?= $curr->value ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="amount-input">
                        <input type="number" step="0.01" name="amount" placeholder="0.00" required value="<?= $resultData ? '' : '' ?>">
                    </div>
                </div>

                <!-- Swap Connector -->
                <div class="swap-btn-container">
                    <button type="button" class="btn-swap" onclick="swapCurrencies()">
                        <i class="ph-bold ph-arrows-down-up"></i>
                    </button>
                </div>

                <!-- To Row -->
                <div class="currency-row">
                    <div class="currency-selector">
                        <label>Comprar (Destino)</label>
                        <select name="to_currency">
                            <?php foreach(Currency::cases() as $curr): ?>
                                <option value="<?= $curr->value ?>" <?= ($curr === Currency::EUR) ? 'selected' : '' ?>>
                                    <?= $curr->getFlag() ?> <?= $curr->value ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <!-- Placeholder visual for aesthetic balance -->
                    <div class="amount-input">
                         <div style="font-family: 'Outfit', monospace; font-size: 1.5rem; text-align: right; color: var(--text-muted); padding: 0.5rem; opacity: 0.5;">
                            <?= $resultData ? number_format($resultData['result'], 2) : '---' ?>
                         </div>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn-primary">
                CONVERTIR DIVISAS <i class="ph-bold ph-trend-up"></i>
            </button>
        </form>

        <!-- Compact History -->
        <div class="history-section">
            <div class="history-title" style="justify-content: space-between;">
                <span><i class="ph-bold ph-clock-counter-clockwise"></i> Últimas Operaciones</span>
                <?php if (!empty($_SESSION['history_v2'])): ?>
                    <form method="POST" style="margin:0;">
                         <input type="hidden" name="action" value="clear_history">
                         <button type="submit" style="color: #ef4444; background: none; border: none; cursor: pointer;">
                             <i class="ph-bold ph-trash"></i>
                         </button>
                    </form>
                <?php endif; ?>
            </div>
            
            <?php if (!empty($_SESSION['history_v2'])): ?>
                <div class="history-list">
                    <?php foreach (array_slice($_SESSION['history_v2'], 0, 3) as $item): ?>
                        <div class="history-item" style="padding: 0.5rem; border: none; background: rgba(255,255,255,0.02);">
                            <div style="display: flex; gap: 0.5rem; align-items: center;">
                                <span><?= $item['from_flag'] ?></span>
                                <i class="ph-bold ph-arrow-right" style="font-size: 0.7rem; color: var(--text-muted);"></i>
                                <span><?= $item['to_flag'] ?></span>
                            </div>
                            <div style="font-family: monospace; color: var(--gold);">
                                $<?= number_format($item['amount'], 2) ?> -> $<?= number_format($item['result'], 2) ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

    </div>

    <script>
        function swapCurrencies() {
            // Simple JS to swap select values
            const fromSelect = document.querySelector('select[name="from_currency"]');
            const toSelect = document.querySelector('select[name="to_currency"]');
            const temp = fromSelect.value;
            fromSelect.value = toSelect.value;
            toSelect.value = temp;
        }
    </script>
</body>
</html>
