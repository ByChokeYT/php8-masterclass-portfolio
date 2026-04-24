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
use App\Models\ServiceRepository;

$config = new DatabaseConfig(driver: 'sqlite', database: 'catalogo.sqlite');
$repository = new ServiceRepository(new DatabaseHost($config));

try {
    $services = $repository->getAll();
} catch (Exception $e) {
    $error = $e->getMessage();
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DÍA 27 // TITANIUM CATALOGUE // Masterclass PHP</title>
    <link rel="icon" type="image/x-icon" href="https://www.php.net/favicon.ico">
    <link rel="stylesheet" href="assets/css/style.css?v=<?= time() ?>">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
</head>
<body>
<?php
$dayLabel = 'DÍA 27';
$dayTitle = 'Catálogo de Servicios Titanium';
$prevUrl  = 'http://localhost:8026';
$nextUrl  = 'http://localhost:8028';
require_once __DIR__ . '/../../_nav.php';
?>
    <div class="background-layer"></div>
    <div class="grid-overlay"></div>

    <div class="container">
        <header>
            <div class="tech-badge">Industrial Data Persistence // Day 27</div>
            <h1>Premium<br>Services</h1>
            <p class="subtitle">Arquitectura de alto rendimiento con PHP 8.5, tipado estricto y persistencia de datos en tiempo real mediante SQLite.</p>
        </header>

        <?php if (isset($error)): ?>
            <div style="background: rgba(244, 63, 94, 0.1); border: 1px solid rgba(244, 63, 94, 0.2); color: #f43f5e; padding: 2rem; border-radius: 24px; margin-bottom: 4rem; backdrop-filter: blur(20px);">
                <i class="ph ph-warning-octagon" style="font-size: 2rem; vertical-align: middle; margin-right: 1rem;"></i>
                <strong>Critical Error:</strong> <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <main class="services-grid">
            <?php foreach ($services as $service): ?>
                <article class="service-card">
                    <div class="image-container">
                        <img src="<?= htmlspecialchars($service->imagePath) ?>" alt="<?= htmlspecialchars($service->title) ?>">
                    </div>
                    
                    <div class="service-info">
                        <h3><?= htmlspecialchars($service->title) ?></h3>
                        <p><?= htmlspecialchars($service->description) ?></p>
                    </div>

                    <div class="card-footer">
                        <div class="price-tag">
                            <span>Desde</span>
                            <?= $service->getFormattedPrice() ?>
                        </div>
                        <a href="#" class="action-btn">
                            <i class="ph ph-arrow-up-right"></i>
                        </a>
                    </div>
                </article>
            <?php endforeach; ?>
        </main>
    </div>

    <footer style="margin-top: 8rem; padding: 4rem 0; border-top: 1px solid var(--border-color); text-align: center; opacity: 0.5; font-family: 'JetBrains Mono', monospace; font-size: 0.8rem;">
        &copy; 2026 TITANIUM MASTERCLASS // PHP 8.5.5 // DESIGNED BY BYCHOKE
    </footer>
</body>
</html>
