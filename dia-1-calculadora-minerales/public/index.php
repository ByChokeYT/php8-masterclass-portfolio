<?php
declare(strict_types=1);

session_start();

require_once __DIR__ . '/../src/Enums/MineralType.php';
require_once __DIR__ . '/../src/DTO/Liquidacion.php';
require_once __DIR__ . '/../src/Services/CalculatorService.php';

use App\Enums\MineralType;
use App\DTO\Liquidacion;
use App\Services\CalculatorService;

$resultado = null;
$error     = null;

if (isset($_SESSION['flash_result'])) {
    $resultado = $_SESSION['flash_result'];
    unset($_SESSION['flash_result']);
}

if (isset($_SESSION['flash_error'])) {
    $error = $_SESSION['flash_error'];
    unset($_SESSION['flash_error']);
}

// ── POST: procesar formulario ──────────────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $mineralSymbol = $_POST['mineral'] ?? '';
        $peso          = filter_input(INPUT_POST, 'peso',       FILTER_VALIDATE_FLOAT);
        $cotizacion    = filter_input(INPUT_POST, 'cotizacion', FILTER_VALIDATE_FLOAT);
        $pureza        = filter_input(INPUT_POST, 'pureza',     FILTER_VALIDATE_FLOAT);

        if ($peso === false || $cotizacion === false || $pureza === false) {
            throw new \InvalidArgumentException('Los valores ingresados no son numéricos válidos.');
        }

        $mineralEnum = MineralType::tryFrom($mineralSymbol);
        if (!$mineralEnum) {
            throw new \InvalidArgumentException('Tipo de mineral no válido.');
        }

        // ── ValueError se lanza desde el DTO si pureza < 0 o > 100 ──
        $liquidacion = new Liquidacion($mineralEnum, (float)$peso, (float)$cotizacion, (float)$pureza);

        $servicio = new CalculatorService();
        $calc     = $servicio->calculate($liquidacion);
        $grado    = $liquidacion->getGradoCalidad();

        $_SESSION['flash_result'] = [
            'mineral'      => $mineralEnum->value,
            'simbolo'      => $mineralEnum->getSymbol(),
            'pesoKg'       => $liquidacion->getPesoKg(),
            'pesoFinoKg'   => $liquidacion->getPesoFinoKg(),
            'pesoGramos'   => $liquidacion->pesoGramos,
            'pesoFinoGr'   => $liquidacion->getPesoFinoGramos(),
            'pureza'       => $liquidacion->purezaPorcentaje,
            'cotizacion'   => $liquidacion->getCotizacionUsd(),
            'totalUsd'     => $calc['totalUsd'],
            'totalCentavos'=> $calc['totalCentavos'],
            'ajusteLabel'  => $calc['ajusteLabel'],
            'grado'        => $grado,
            'fecha'        => date('d/m/Y H:i:s'),
        ];

        header('Location: index.php');
        exit;

    } catch (\ValueError | \InvalidArgumentException $e) {
        $_SESSION['flash_error'] = $e->getMessage();
        header('Location: index.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DÍA 01 // CALCULADORA DE PUREZA // Masterclass PHP</title>
    <meta name="description" content="Calculadora de liquidación de minerales con aritmética entera, ValueError y match — PHP 8.5">
    <link rel="icon" type="image/x-icon" href="https://www.php.net/favicon.ico">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <link rel="stylesheet" href="css/style.css?v=<?= time() ?>">
</head>
<body>
<?php
$dayLabel = 'DÍA 01';
$dayTitle = 'Calculadora de Pureza de Minerales';
$prevUrl  = '';
$nextUrl  = 'http://localhost:8000';
require_once __DIR__ . '/../../_nav.php';
?>

<div class="page-wrap">

    <!-- ── HEADER ── -->
    <header class="top-header">
        <div class="brand">
            <i class="ph-bold ph-diamond"></i>
            <div>
                <span class="brand-title">Pureza Mineral</span>
                <span class="brand-sub">Liquidación v3.0 — PHP 8.5</span>
            </div>
        </div>
        <div class="header-badges">
            <span class="hbadge"><i class="ph ph-check-circle"></i> ValueError</span>
            <span class="hbadge"><i class="ph ph-hash"></i> int-precision</span>
            <span class="hbadge"><i class="ph ph-arrows-split"></i> match</span>
        </div>
    </header>

    <!-- ── MAIN GRID ── -->
    <main class="main-grid">

        <!-- FORM PANEL -->
        <section class="panel form-panel">
            <div class="panel-label">Datos de Entrada</div>

            <?php if ($error): ?>
                <div class="alert-error">
                    <i class="ph-bold ph-warning-octagon"></i>
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="index.php" class="calc-form">

                <div class="field">
                    <label><i class="ph ph-cube"></i> Mineral</label>
                    <select name="mineral" required>
                        <option value="" disabled selected>Seleccionar mineral...</option>
                        <?php foreach (MineralType::cases() as $m): ?>
                            <option value="<?= $m->value ?>"><?= $m->getSymbol() ?> — <?= $m->value ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="field-row">
                    <div class="field">
                        <label><i class="ph ph-scales"></i> Peso Bruto (kg)</label>
                        <input type="number" step="0.001" min="0.001" name="peso" placeholder="Ej. 1000.00" required>
                    </div>
                    <div class="field">
                        <label><i class="ph ph-percent"></i> Pureza % <span class="range-hint">[0–100]</span></label>
                        <input type="number" step="0.01" min="0" max="100" name="pureza" placeholder="Ej. 65.50" required>
                    </div>
                </div>

                <div class="field">
                    <label><i class="ph ph-currency-dollar"></i> Cotización (USD/kg)</label>
                    <input type="number" step="0.01" min="0.01" name="cotizacion" placeholder="Ej. 14.80" required>
                </div>

                <button type="submit" class="btn-calc">
                    <i class="ph-bold ph-calculator"></i> Calcular Liquidación
                </button>

            </form>

            <!-- Tech notes -->
            <div class="tech-notes">
                <div class="tech-row"><i class="ph ph-warning-circle" style="color:#f59e0b;"></i> <code>ValueError</code> si pureza &lt; 0 o &gt; 100</div>
                <div class="tech-row"><i class="ph ph-hash" style="color:#3b82f6;"></i> Cálculo en centavos <code>int</code> — sin error float IEEE 754</div>
                <div class="tech-row"><i class="ph ph-arrows-split" style="color:#10b981;"></i> Grado de calidad via <code>match(true)</code></div>
                <div class="tech-row"><i class="ph ph-lock" style="color:#8b5cf6;"></i> DTO <code>readonly class</code> — inmutable por diseño</div>
            </div>
        </section>

        <!-- RESULT PANEL -->
        <section class="panel result-panel">
            <div class="panel-label">Ticket de Liquidación</div>

            <?php if ($resultado): ?>
                <?php $grado = $resultado['grado']; ?>
                <div class="ticket">

                    <div class="ticket-mineral">
                        <span class="mineral-sym"><?= htmlspecialchars($resultado['simbolo']) ?></span>
                        <div>
                            <div class="mineral-name"><?= htmlspecialchars($resultado['mineral']) ?></div>
                            <div class="mineral-fecha"><?= $resultado['fecha'] ?></div>
                        </div>
                        <div class="grado-badge" style="background: <?= $grado['color'] ?>22; border-color: <?= $grado['color'] ?>55; color: <?= $grado['color'] ?>;">
                            <?= $grado['label'] ?>
                        </div>
                    </div>

                    <div class="grado-desc"><?= htmlspecialchars($grado['desc']) ?></div>

                    <div class="ticket-rows">
                        <div class="t-row">
                            <span>Peso bruto</span>
                            <span><?= number_format($resultado['pesoKg'], 3) ?> kg
                                <em>(<?= number_format($resultado['pesoGramos']) ?> g)</em></span>
                        </div>
                        <div class="t-row highlight">
                            <span>Pureza (Ley)</span>
                            <span><?= number_format($resultado['pureza'], 2) ?> %</span>
                        </div>
                        <div class="t-row">
                            <span>Peso fino</span>
                            <span><?= number_format($resultado['pesoFinoKg'], 3) ?> kg
                                <em>(<?= number_format($resultado['pesoFinoGr']) ?> g)</em></span>
                        </div>
                        <div class="t-row">
                            <span>Cotización</span>
                            <span>$ <?= number_format($resultado['cotizacion'], 2) ?> /kg</span>
                        </div>
                        <div class="t-row adjust">
                            <span>Ajuste mercado</span>
                            <span><?= htmlspecialchars($resultado['ajusteLabel']) ?></span>
                        </div>
                        <div class="t-row precision-row">
                            <span><i class="ph ph-hash"></i> Valor en centavos</span>
                            <span><?= number_format($resultado['totalCentavos']) ?> ¢ USD</span>
                        </div>
                    </div>

                    <div class="ticket-total">
                        <span>TOTAL A PAGAR</span>
                        <span class="total-usd">$ <?= number_format($resultado['totalUsd'], 2) ?> USD</span>
                    </div>

                </div>
            <?php else: ?>
                <div class="empty-result">
                    <i class="ph ph-receipt"></i>
                    <p>El ticket de liquidación aparecerá aquí después de calcular.</p>
                </div>
            <?php endif; ?>
        </section>

    </main>

    <footer class="bottom-footer">
        &copy; 2026 TITANIUM MASTERCLASS // PHP 8.5.5 // DESIGNED BY BYCHOKE
    </footer>

</div>

</body>
</html>
