<?php

declare(strict_types=1);

// Autoloading manual para evitar dependencias externas como Composer en este ejercicio simple
spl_autoload_register(function ($class) {
    $prefix = 'App\\';
    $base_dir = __DIR__ . '/../src/';
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) return;
    $relative_class = substr($class, $len);
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';
    if (file_exists($file)) require $file;
});

use App\Config\DatabaseConfig;
use App\DatabaseHost;

// Inicialización de la configuración (Solo lectura)
$config = new DatabaseConfig(
    driver: 'sqlite',
    database: 'demo_academia.sqlite'
);

$dbHost = new DatabaseHost($config);
$connectionSuccess = false;
$errorMessage = null;

try {
    $connectionSuccess = $dbHost->testConnection();
} catch (\Exception $e) {
    $connectionSuccess = false;
    $errorMessage = $e->getMessage();
}

$dbConfig = $dbHost->getConfig();

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DIA 21 // CONEXIÓN PDO // PHP 8.5</title>
    <link rel="icon" type="image/x-icon" href="https://www.php.net/favicon.ico">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;700;900&family=JetBrains+Mono:wght@400;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<?php
$dayLabel = 'DÍA 21';
$dayTitle = 'Conexión PDO Inmutable';
$prevUrl  = 'http://localhost:8000';
$nextUrl  = 'http://localhost:8022';
require_once __DIR__ . '/../../_nav.php';
?>
    <div class="industrial-grid"></div>
    <div class="glow-sphere"></div>

    <div class="container">
        <a href="http://localhost:8000" class="tech-label hover:text-white transition-colors flex items-center gap-2 mb-8" style="opacity: 0.6;">
            <i class="ph ph-arrow-left"></i> Volver al Portal
        </a>

        <div class="connection-card">
            <header class="header">
                <span class="tech-label">Fase 3: Persistencia de Datos</span>
                <h1>PDO_CORE</h1>
                <p class="subtitle">Motor de Conexión Inmutable v1.0</p>
            </header>

            <div class="status-widget">
                <div class="status-indicator <?= $connectionSuccess ? 'success' : 'error' ?>">
                    <i class="ph-fill <?= $connectionSuccess ? 'ph-database' : 'ph-warning-octagon' ?> <?= $connectionSuccess ? 'pulse' : '' ?>"></i>
                </div>
                <div class="status-text">
                    <p class="status-title"><?= $connectionSuccess ? 'CONEXIÓN ACTIVA' : 'ERROR DE ENLACE' ?></p>
                    <p class="status-desc">
                        <?= $connectionSuccess 
                            ? 'El túnel de datos se ha establecido correctamente.' 
                            : ($errorMessage ?? 'No se pudo contactar con el host de datos.') 
                        ?>
                    </p>
                </div>
            </div>

            <div class="info-grid">
                <div class="info-item">
                    <p class="info-key">Motor_DB</p>
                    <p class="info-value"><?= strtoupper($dbConfig->driver) ?></p>
                </div>
                <div class="info-item">
                    <p class="info-key">Archivo_DB</p>
                    <p class="info-value"><?= $dbConfig->database ?></p>
                </div>
                <div class="info-item">
                    <p class="info-key">Protocolo</p>
                    <p class="info-value">PDO_V85</p>
                </div>
                <div class="info-item">
                    <p class="info-key">Estado</p>
                    <p class="info-value"><?= $connectionSuccess ? 'OPERATIONAL' : 'OFFLINE' ?></p>
                </div>
            </div>

            <footer class="footer">
                <p class="footer-text">PROPIEDADES READONLY // TIPADO ESTRICTO // PHP 8.5.2</p>
            </footer>
        </div>
    </div>
</body>
</html>
