<?php
declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use App\Services\UrlService;

// Lógica de Enrutamiento para Servidor Interno de PHP
if (php_sapi_name() === 'cli-server') {
    $filePath = __DIR__ . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    if (is_file($filePath)) {
        return false; // Servir el archivo estático tal cual
    }
}

$urlService = new UrlService();

// Lógica de Enrutamiento (Router Simple)
$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uriParts = explode('/', trim($requestUri, '/'));

// Si la URI es un código de 6 caracteres, redirigir
if (count($uriParts) === 1 && strlen($uriParts[0]) === 6 && !str_ends_with($uriParts[0], '.php')) {
    $code = $uriParts[0];
    $longUrl = $urlService->getLongUrl($code);
    if ($longUrl) {
        header("Location: $longUrl", true, 302);
        exit;
    } else {
        header("HTTP/1.0 404 Not Found");
        die("Error 404: El enlace acortado no existe.");
    }
}

$shortCode = null;
$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $longUrl = $_POST['long_url'] ?? '';
    
    if (filter_var($longUrl, FILTER_VALIDATE_URL)) {
        try {
            $shortCode = $urlService->shorten($longUrl);
        } catch (\Exception $e) {
            $error = "Error al procesar la URL.";
        }
    } else {
        $error = "Por favor, introduce una URL válida (ej: https://google.com).";
    }
}

$stats = $urlService->getStats();
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
$baseUrl = $protocol . "://" . $_SERVER['HTTP_HOST'] . "/";

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DÍA 37 // URL SHORTENER // Masterclass PHP</title>
    <link rel="icon" type="image/x-icon" href="https://www.php.net/favicon.ico">
    <link rel="stylesheet" href="assets/css/style.css?v=<?= time() ?>">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;700;900&display=swap" rel="stylesheet">
</head>
<body>
<?php
$dayLabel = 'DÍA 37';
$dayTitle = 'Acortador de URLs';
$prevUrl  = '../dia-35-exportador-datos/public/index.php'; // Saltamos el 36
$nextUrl  = '';
require_once __DIR__ . '/../../_nav.php';
?>

    <div class="dashboard">
        <header class="header">
            <div class="pill">NODO 37 // FASE 4</div>
            <h1>Shorty URL Studio</h1>
            <p>Acortador de enlaces con persistencia en SQLite y redirecciones mediante cabeceras HTTP.</p>
        </header>

        <form class="shorten-form" method="POST">
            <div class="input-group">
                <label>Pega tu URL larga aquí</label>
                <div class="input-wrapper">
                    <i class="ph-bold ph-link"></i>
                    <input type="url" name="long_url" placeholder="https://tu-enlace-largo.com/..." required>
                </div>
            </div>
            
            <?php if ($error): ?>
                <div style="font-size: 0.75rem; color: #ef4444; text-align: center; background: rgba(239, 68, 68, 0.1); padding: 0.75rem; border-radius: 8px;">
                    <?= $error ?>
                </div>
            <?php endif; ?>

            <button type="submit" class="btn-shorten">
                <i class="ph-bold ph-scissors"></i> Acortar Enlace
            </button>
        </form>

        <?php if ($shortCode): ?>
            <div class="result-card">
                <div style="font-size: 0.6rem; font-weight: 800; text-transform: uppercase; color: var(--indigo);">¡URL Acortada con éxito!</div>
                <div class="short-url" id="result_url"><?= $baseUrl . $shortCode ?></div>
                <button onclick="copyUrl()" style="background: var(--white); color: var(--bg-deep); border: none; padding: 0.4rem 1rem; border-radius: 6px; font-size: 0.7rem; font-weight: 800; cursor: pointer; margin-top: 0.5rem;">
                    COPIAR ENLACE
                </button>
            </div>
            <script>
                function copyUrl() {
                    const text = document.getElementById('result_url').innerText;
                    navigator.clipboard.writeText(text);
                    alert('¡Enlace copiado al portapapeles!');
                }
            </script>
        <?php endif; ?>
    </div>

    <div class="stats-section">
        <div class="stats-title"><i class="ph-bold ph-chart-line"></i> Últimos Enlaces Generados</div>
        <?php if (empty($stats)): ?>
            <div style="text-align: center; font-size: 0.8rem; opacity: 0.3; padding: 2rem;">Aún no hay enlaces generados.</div>
        <?php else: ?>
            <?php foreach ($stats as $row): ?>
                <div class="stats-row">
                    <div class="stats-info">
                        <div style="font-weight: 700; color: var(--white);"><?= $baseUrl . $row['short_code'] ?></div>
                        <div class="stats-long-url"><?= $row['long_url'] ?></div>
                    </div>
                    <div class="click-badge"><?= $row['clicks'] ?> CLICKS</div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <footer style="margin-top: 3rem; text-align: center; font-size: 0.6rem; opacity: 0.3; text-transform: uppercase; letter-spacing: 2px;">
        MASTERCLASS PHP 8.5 // SYSTEM REDIRECT v1.0
    </footer>

</body>
</html>
