<?php
declare(strict_types=1);

require_once file_exists(__DIR__ . '/../vendor/autoload.php') ? __DIR__ . '/../vendor/autoload.php' : __DIR__ . '/../../vendor/autoload.php';

use App\Services\MetalService;

$metalService = new MetalService();
$marketData = $metalService->getLatestPrices();

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DÍA 33 // METAL MARKET // Masterclass PHP</title>
    <link rel="icon" type="image/x-icon" href="https://www.php.net/favicon.ico">
    <link rel="stylesheet" href="assets/css/style.css?v=<?= time() ?>">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;700;800&display=swap" rel="stylesheet">
</head>
<body>
<?php
$dayLabel = 'DÍA 33';
$dayTitle = 'Consumo API de Metales';
$prevUrl  = '../dia-32-scraper-clima-oruro/public/index.php';
$nextUrl  = '';
require_once __DIR__ . '/../../_nav.php';
?>

    <header class="terminal-header">
        <div class="title-box">
            <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 0.5rem;">
                <div style="width: 12px; height: 12px; background: #f43f5e; border-radius: 2px;"></div>
                <div style="font-size: 0.6rem; color: #f43f5e; font-weight: 800; letter-spacing: 2px;">COMMODITIES // LIVE</div>
            </div>
            <h1>Metal Market Terminal</h1>
            <p>Monitoreo de cotizaciones industriales y precios base de exportación.</p>
        </div>
        <div class="status-box">
            <div class="live-indicator">
                <div class="dot"></div>
                MARKET OPEN
            </div>
            <div style="color: var(--muted);"><?= strtoupper($marketData['timestamp']) ?></div>
        </div>
    </header>

    <main class="market-grid">
        <?php foreach ($marketData['data'] as $metal): ?>
            <div class="metal-card">
                <div class="card-header">
                    <i class="ph-bold <?= $metalService->getMetalIcon($metal['symbol']) ?>"></i>
                    <span class="symbol"><?= $metal['symbol'] ?></span>
                </div>
                
                <div class="metal-info">
                    <h3 style="font-size: 0.8rem; color: var(--muted); margin-bottom: 0.5rem;"><?= $metal['name'] ?></h3>
                    <div class="price-main">$<?= number_format($metal['price'], 2) ?></div>
                    <div class="unit"><?= $metal['unit'] ?></div>
                </div>

                <div class="card-footer">
                    <span class="<?= $metal['trend'] === 'up' ? 'trend-up' : 'trend-down' ?>">
                        <i class="ph-bold <?= $metal['trend'] === 'up' ? 'ph-trend-up' : 'ph-trend-down' ?>"></i>
                        <?= $metal['change'] ?>
                    </span>
                    <span style="font-size: 0.6rem; color: var(--muted);">LME SPOT</span>
                </div>

                <div class="bg-label"><?= $metal['symbol'] ?></div>
            </div>
        <?php endforeach; ?>
    </main>

    <div style="width: 100%; max-width: 1100px; margin-top: 2rem; padding: 1.5rem; background: rgba(59, 130, 246, 0.05); border-radius: 12px; border: 1px solid rgba(59, 130, 246, 0.1); display: flex; gap: 1rem; align-items: flex-start;">
        <i class="ph ph-info" style="color: #38bdf8; font-size: 1.25rem;"></i>
        <div style="font-size: 0.75rem; color: #94a3b8; line-height: 1.6;">
            <strong style="color: #38bdf8;">Nota Académica:</strong> Este módulo simula la integración con un API Gateway financiero. Se utiliza el patrón de diseño **Service Provider** para abstraer la lógica de obtención de datos, permitiendo cambiar entre fuentes de datos reales (REST) o simuladas (Sandbox) sin afectar la UI.
        </div>
    </div>

    <footer class="tech-footer">
        <div>BYCHOKE MASTERCLASS // NODE_33</div>
        <div>PROTOCOLO: HTTPS/JSON_REST</div>
    </footer>

</body>
</html>
