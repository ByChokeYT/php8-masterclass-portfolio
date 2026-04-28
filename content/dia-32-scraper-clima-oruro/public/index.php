<?php
declare(strict_types=1);

require_once file_exists(__DIR__ . '/../vendor/autoload.php') ? __DIR__ . '/../vendor/autoload.php' : __DIR__ . '/../../../vendor/autoload.php';

use App\Services\WeatherService;

$weatherService = new WeatherService();
$weatherData = null;
$error = null;

try {
    $weatherData = $weatherService->getOruroWeather();
    $current = $weatherData['current'];
    $weatherInfo = $weatherService->getWeatherDescription((int)$current['weather_code']);
} catch (\Exception $e) {
    $error = $e->getMessage();
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DÍA 32 // ORURO CLIMA // Masterclass PHP</title>
    <link rel="icon" type="image/x-icon" href="https://www.php.net/favicon.ico">
    <link rel="stylesheet" href="assets/css/style.css?v=<?= time() ?>">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
</head>
<body>
<?php
$dayLabel = 'DÍA 32';
$dayTitle = 'Scraper del Clima (Oruro)';
$prevUrl  = '../dia-31-generador-qr/public/index.php';
$nextUrl  = '';
require_once __DIR__ . '/../../../_nav.php';
?>

    <header class="header">
        <div class="pill"><i class="ph-bold ph-cloud-sun"></i> NODO 32 // FASE 4</div>
        <h1>Oruro Weather Scraper</h1>
        <p>Consumo de API REST mediante cURL con tipado estricto PHP 8.5.</p>
    </header>

    <main class="weather-container">
        <?php if ($error): ?>
            <div style="grid-column: 1 / -1; background: rgba(244,63,94,.1); border: 1px solid rgba(244,63,94,.2); color: #f43f5e; padding: 2rem; border-radius: 24px; text-align: center;">
                <i class="ph ph-warning-circle" style="font-size: 3rem; margin-bottom: 1rem;"></i>
                <h2>Error de Conexión</h2>
                <p><?= htmlspecialchars($error) ?></p>
            </div>
        <?php elseif ($weatherData): ?>
            <!-- CARD PRINCIPAL -->
            <section class="main-card">
                <i class="ph-bold <?= $weatherInfo['icon'] ?> weather-icon"></i>
                <div class="temp-big"><?= round($current['temperature_2m']) ?><span>°C</span></div>
                <div class="weather-desc"><?= $weatherInfo['label'] ?></div>
                <div class="location">
                    <i class="ph ph-map-pin"></i>
                    Oruro, Bolivia
                </div>
                <div style="margin-top: 2rem; font-size: 0.7rem; color: var(--muted); background: rgba(255,255,255,0.05); padding: 0.5rem 1rem; border-radius: 99px;">
                    SENSACIÓN: <?= round($current['apparent_temperature']) ?>°C
                </div>
            </section>

            <!-- GRILLA DE DETALLES -->
            <section class="details-grid">
                <div class="detail-item">
                    <i class="ph ph-drop"></i>
                    <span class="detail-label">Humedad</span>
                    <span class="detail-value"><?= $current['relative_humidity_2m'] ?>%</span>
                </div>
                <div class="detail-item">
                    <i class="ph ph-wind"></i>
                    <span class="detail-label">Viento</span>
                    <span class="detail-value"><?= $current['wind_speed_10m'] ?> km/h</span>
                </div>
                <div class="detail-item">
                    <i class="ph ph-cloud"></i>
                    <span class="detail-label">Nubes</span>
                    <span class="detail-value"><?= $current['cloud_cover'] ?>%</span>
                </div>
                <div class="detail-item">
                    <i class="ph ph-gauge"></i>
                    <span class="detail-label">Presión</span>
                    <span class="detail-value"><?= round($current['surface_pressure']) ?> hPa</span>
                </div>
                
                <div style="grid-column: 1 / -1; margin-top: 1rem; padding: 1.5rem; background: rgba(59, 130, 246, 0.05); border: 1px dashed rgba(59, 130, 246, 0.2); border-radius: 20px; display: flex; align-items: center; gap: 1rem;">
                    <i class="ph ph-terminal-window" style="font-size: 1.5rem; color: var(--accent);"></i>
                    <div style="font-size: 0.8rem; line-height: 1.4;">
                        <strong style="color: var(--accent); display: block; margin-bottom: 0.2rem;">Técnica Aplicada:</strong>
                        Implementación de cURL multi-petición con manejo de cabeceras User-Agent y decodificación JSON segura.
                    </div>
                </div>
            </section>
        <?php endif; ?>
    </main>

    <div class="footer-label">MASTERCLASS PHP 8.5 // DESIGNED BY BYCHOKE</div>

</body>
</html>
