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
use App\LinkManager;

$config = new DatabaseConfig(driver: 'sqlite', database: 'qr_links.sqlite');
$manager = new LinkManager(new DatabaseHost($config));

$notification = null;

if (isset($_SESSION['notification'])) {
    $notification = $_SESSION['notification'];
    unset($_SESSION['notification']);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $title = $_POST['title'] ?? '';
        $url = $_POST['url'] ?? '';

        if ($manager->saveLink($title, $url)) {
            $_SESSION['notification'] = ['type' => 'success', 'msg' => 'Enlace guardado y Código QR generado.'];
        }
    } catch (Exception $e) {
        $_SESSION['notification'] = ['type' => 'error', 'msg' => $e->getMessage()];
    }
    
    header('Location: index.php');
    exit;
}

$links = $manager->getLinks();

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>DÍA 25 // GESTOR DE ENLACES QR // Masterclass PHP</title>
    <link rel="icon" type="image/x-icon" href="https://www.php.net/favicon.ico">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;700;900&family=JetBrains+Mono:wght@400;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <link rel="stylesheet" href="assets/css/style.css?v=<?= time() ?>">
</head>
<body>
<?php
$dayLabel = 'DÍA 25';
$dayTitle = 'Gestor de Enlac QR';
$prevUrl  = 'http://localhost:8024';
$nextUrl  = 'http://localhost:8026';
require_once __DIR__ . '/../../_nav.php';
?>
    <div class="industrial-grid"></div>

    <div class="container">
        <header class="header">
            <div>
                <span class="tech-label">Fase 3: Persistencia y APIs Externas</span>
                <h1>Gestor de Códigos QR</h1>
            </div>
            <a href="http://localhost:8000" class="tech-label hover:text-white flex items-center gap-2" style="text-decoration: none;">
                <i class="ph ph-arrow-left"></i> Volver al Portal
            </a>
        </header>

        <?php if ($notification): ?>
            <div class="alert alert-<?= $notification['type'] ?>">
                <i class="ph-bold ph-<?= $notification['type'] === 'success' ? 'check-circle' : 'warning-octagon' ?>"></i>
                <?= htmlspecialchars($notification['msg']) ?>
            </div>
        <?php endif; ?>

        <div class="panel">
            <div class="panel-header">
                <i class="ph-fill ph-link"></i>
                <h2>Registrar Nuevo Enlace</h2>
            </div>
            <form method="POST" class="qr-form">
                <div class="form-group" style="margin-bottom:0;">
                    <label>Título Identificador</label>
                    <input type="text" name="title" placeholder="Ej. Mi Portafolio" required>
                </div>
                <div class="form-group" style="margin-bottom:0;">
                    <label>URL de Destino (https://...)</label>
                    <input type="url" name="url" placeholder="https://mi-sitio.com" required>
                </div>
                <button type="submit" class="btn-submit">
                    <i class="ph-bold ph-qr-code"></i> Generar QR
                </button>
            </form>
        </div>

        <div class="qr-grid">
            <?php if (empty($links)): ?>
                <div style="grid-column: 1 / -1; text-align:center; padding: 3rem; color: var(--text-secondary);">
                    <i class="ph ph-qr-code" style="font-size: 4rem; opacity: 0.2; margin-bottom: 1rem; display:block;"></i>
                    No hay enlaces registrados en la bóveda aún.
                </div>
            <?php endif; ?>

            <?php foreach ($links as $link): ?>
                <article class="qr-card">
                    <div class="qr-image-wrapper">
                        <!-- Integración dinámica de la API -->
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=<?= urlencode($link['url']) ?>" 
                             alt="QR Code for <?= htmlspecialchars($link['title']) ?>" loading="lazy">
                    </div>
                    <h3 class="qr-title"><?= htmlspecialchars($link['title']) ?></h3>
                    <a href="<?= htmlspecialchars($link['url']) ?>" target="_blank" class="qr-url">
                        <?= htmlspecialchars($link['url']) ?>
                    </a>
                    <div class="qr-meta">
                        REGISTRADO: <?= date('d/m/Y H:i', strtotime($link['created_at_local'])) ?>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>
