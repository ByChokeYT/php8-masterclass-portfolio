<?php

declare(strict_types=1);

session_start();

spl_autoload_register(function ($class) {
    if (str_starts_with($class, 'App\\')) {
        $file = __DIR__ . '/../src/' . str_replace(['App\\', '\\'], ['', '/'], $class) . '.php';
        if (file_exists($file)) require $file;
    }
});

use App\Services\StatsService;

$service = new StatsService();
$stats = $service->getGlobalStats();

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DÍA 30 // ADMIN DASHBOARD // Masterclass PHP</title>
    <link rel="icon" type="image/x-icon" href="https://www.php.net/favicon.ico">
    <link rel="stylesheet" href="assets/css/style.css?v=<?= time() ?>">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
</head>
<body>
    <div class="grid-bg"></div>

    <div class="container">
        <header>
            <div>
                <h1>Admin Hub</h1>
                <p style="color: var(--text-secondary); margin-top: 0.5rem;">Consolidación de métricas globales de la Fase 3.</p>
            </div>
            <div class="tech-info">
                <i class="ph ph-cpu"></i> PHP 8.5.5 // SQLITE_ENGINE // MULTI_DB_SYNC
            </div>
        </header>

        <main class="dashboard-grid">
            <a href="../../dia-22-crud-invitados/public/index.php" class="metric-card" style="text-decoration: none;">
                <div class="metric-header">
                    <span>Invitados</span>
                    <i class="ph ph-users-three"></i>
                </div>
                <div class="metric-value"><?= str_pad((string)$stats['guests'], 2, '0', STR_PAD_LEFT) ?></div>
                <div class="metric-label">Gestionar Lista de Asistentes <i class="ph ph-arrow-right"></i></div>
            </a>

            <a href="../../dia-24-registro-seguro/public/index.php" class="metric-card" style="--accent: #10b981; text-decoration: none;">
                <div class="metric-header">
                    <span>Usuarios</span>
                    <i class="ph ph-shield-check"></i>
                </div>
                <div class="metric-value"><?= str_pad((string)$stats['users'], 2, '0', STR_PAD_LEFT) ?></div>
                <div class="metric-label">Control de Acceso y Seguridad <i class="ph ph-arrow-right"></i></div>
            </a>

            <a href="../../dia-29-registro-gastos/public/index.php" class="metric-card" style="--accent: #f59e0b; text-decoration: none;">
                <div class="metric-header">
                    <span>Gastos</span>
                    <i class="ph ph-currency-dollar"></i>
                </div>
                <div class="metric-value"><?= number_format($stats['expenses'] / 1000, 1) ?>k</div>
                <div class="metric-label">Registro de Finanzas Personales <i class="ph ph-arrow-right"></i></div>
            </a>

            <a href="../../dia-26-muro-comentarios/public/index.php" class="metric-card" style="--accent: #ec4899; text-decoration: none;">
                <div class="metric-header">
                    <span>Comentarios</span>
                    <i class="ph ph-chat-centered-text"></i>
                </div>
                <div class="metric-value"><?= str_pad((string)$stats['comments'], 2, '0', STR_PAD_LEFT) ?></div>
                <div class="metric-label">Ver Muro de Deseos Público <i class="ph ph-arrow-right"></i></div>
            </a>

            <a href="../../dia-25-gestor-qr/public/index.php" class="metric-card" style="--accent: #06b6d4; text-decoration: none;">
                <div class="metric-header">
                    <span>Gestor QR</span>
                    <i class="ph ph-qr-code"></i>
                </div>
                <div class="metric-value"><?= str_pad((string)$stats['links'], 2, '0', STR_PAD_LEFT) ?></div>
                <div class="metric-label">Administrar Enlaces Dinámicos <i class="ph ph-arrow-right"></i></div>
            </a>

            <a href="../../dia-23-inventario-minerales/public/index.php" class="metric-card" style="--accent: #8b5cf6; text-decoration: none;">
                <div class="metric-header">
                    <span>Inventario</span>
                    <i class="ph ph-cube"></i>
                </div>
                <div class="metric-value"><?= str_pad((string)$stats['minerals'], 2, '0', STR_PAD_LEFT) ?></div>
                <div class="metric-label">Control de Stock de Minerales <i class="ph ph-arrow-right"></i></div>
            </a>

            <a href="../../dia-28-buscador-contactos/public/index.php" class="metric-card" style="--accent: #fb7185; text-decoration: none;">
                <div class="metric-header">
                    <span>Contactos</span>
                    <i class="ph ph-address-book"></i>
                </div>
                <div class="metric-value"><?= str_pad((string)$stats['total_registros'], 2, '0', STR_PAD_LEFT) ?></div>
                <div class="metric-label">Buscador con Filtros SQL <i class="ph ph-arrow-right"></i></div>
            </a>

            <a href="../../dia-27-catalogo-servicios/public/index.php" class="metric-card" style="--accent: #22d3ee; text-decoration: none;">
                <div class="metric-header">
                    <span>Catálogo</span>
                    <i class="ph ph-image"></i>
                </div>
                <div class="metric-value">08</div>
                <div class="metric-label">Galería Visual de Servicios <i class="ph ph-arrow-right"></i></div>
            </a>
        </main>

        <section class="system-health">
            <div class="health-header">
                <h2 style="font-size: 1.5rem; font-weight: 800;">Estado de Conexiones</h2>
                <div class="health-status">
                    <span class="status-dot"></span>
                    Sistemas Operativos
                </div>
            </div>

            <div class="log-list">
                <div class="log-item">
                    <span class="log-path">/dia-22-crud-invitados/data/eventos_academia.sqlite</span>
                    <span class="log-status">CONNECTED</span>
                </div>
                <div class="log-item">
                    <span class="log-path">/dia-24-registro-seguro/data/seguridad.sqlite</span>
                    <span class="log-status">CONNECTED</span>
                </div>
                <div class="log-item">
                    <span class="log-path">/dia-29-registro-gastos/data/gastos.sqlite</span>
                    <span class="log-status">CONNECTED</span>
                </div>
                <div class="log-item">
                    <span class="log-path">/dia-23-inventario-minerales/data/mineria_transaccional.sqlite</span>
                    <span class="log-status">CONNECTED</span>
                </div>
            </div>
        </section>

        <footer style="margin-top: 6rem; text-align: center; opacity: 0.5; font-family: 'JetBrains Mono', monospace; font-size: 0.8rem;">
            &copy; 2026 TITANIUM MASTERCLASS // PHP 8.5.5 // DESIGNED BY BYCHOKE
        </footer>
    </div>
</body>
</html>
