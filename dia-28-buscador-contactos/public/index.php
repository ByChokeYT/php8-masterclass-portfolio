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
use App\Models\ContactRepository;

$config = new DatabaseConfig(driver: 'sqlite', database: 'contactos.sqlite');
$repository = new ContactRepository(new DatabaseHost($config));

$query  = $_GET['q']      ?? '';
$filter = $_GET['filter'] ?? 'name';

try {
    $contacts = $repository->search($query, $filter);
} catch (Exception $e) {
    $error = $e->getMessage();
}

$total = count($contacts ?? []);

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DÍA 28 // CONTACT DIRECTORY // Masterclass PHP</title>
    <link rel="icon" type="image/x-icon" href="https://www.php.net/favicon.ico">
    <link rel="stylesheet" href="assets/css/style.css?v=<?= time() ?>">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
</head>
<body>

    <!-- ── Topbar ── -->
    <nav class="topbar">
        <div class="topbar-logo">
            <span class="dot"></span>
            Contact Directory
        </div>
        <span class="topbar-meta">DÍA 28 // Masterclass PHP 8.5 // ByChoke</span>
    </nav>

    <div class="layout">

        <!-- ── Sidebar ── -->
        <aside class="sidebar">
            <div>
                <h2>Filtros de Búsqueda</h2>
                <form class="filter-form" method="GET" action="index.php">
                    <div>
                        <div class="field-label">Búsqueda</div>
                        <div class="search-wrap">
                            <i class="ph ph-magnifying-glass"></i>
                            <input
                                type="text"
                                name="q"
                                value="<?= htmlspecialchars($query) ?>"
                                placeholder="Buscar..."
                                autocomplete="off"
                            >
                        </div>
                    </div>

                    <div>
                        <div class="field-label">Campo</div>
                        <select name="filter">
                            <option value="name"    <?= $filter==='name'    ? 'selected' : '' ?>>Nombre</option>
                            <option value="email"   <?= $filter==='email'   ? 'selected' : '' ?>>Email</option>
                            <option value="company" <?= $filter==='company' ? 'selected' : '' ?>>Empresa</option>
                            <option value="role"    <?= $filter==='role'    ? 'selected' : '' ?>>Cargo</option>
                        </select>
                    </div>

                    <button type="submit" class="btn-filter">
                        <i class="ph-bold ph-funnel" style="margin-right: 0.5rem;"></i> Aplicar Filtro
                    </button>
                </form>
            </div>

            <div class="sidebar-stats">
                <h2>Estadísticas</h2>
                <div class="stat-row">
                    <span class="stat-label">Resultados</span>
                    <span class="stat-val"><?= $total ?></span>
                </div>
                <div class="stat-row">
                    <span class="stat-label">Filtro activo</span>
                    <span class="stat-val" style="color: var(--accent);"><?= ucfirst($filter) ?></span>
                </div>
                <div class="stat-row">
                    <span class="stat-label">Query</span>
                    <span class="stat-val"><?= empty($query) ? '—' : '"'.htmlspecialchars($query).'"' ?></span>
                </div>
                <div class="stat-row">
                    <span class="stat-label">Motor BD</span>
                    <span class="stat-val">SQLite</span>
                </div>
            </div>
        </aside>

        <!-- ── Main ── -->
        <main class="main">

            <?php if (isset($error)): ?>
                <div style="background: rgba(239,68,68,.1); border:1px solid rgba(239,68,68,.2); color:#ef4444; padding:1.25rem 1.5rem; border-radius:14px; margin-bottom:2rem;">
                    <i class="ph ph-warning-octagon" style="margin-right:.5rem;"></i>
                    <strong>Error:</strong> <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

            <div class="page-header">
                <h1 class="page-title">Directorio de Contactos</h1>
                <span class="page-count"><?= $total ?> resultado<?= $total !== 1 ? 's' : '' ?></span>
            </div>

            <div class="contact-list">
                <?php if (empty($contacts)): ?>
                    <div class="empty">
                        <i class="ph ph-user-minus"></i>
                        No se encontraron contactos para <strong>&ldquo;<?= htmlspecialchars($query) ?>&rdquo;</strong>
                    </div>
                <?php else: ?>
                    <?php foreach ($contacts as $c): ?>
                        <div class="contact-row">
                            <div class="avatar"><?= strtoupper(substr($c->name, 0, 1)) ?></div>

                            <div class="contact-info">
                                <div class="name"><?= htmlspecialchars($c->name) ?></div>
                                <div class="role"><?= htmlspecialchars($c->role ?? 'SIN CARGO') ?></div>
                            </div>

                            <div class="contact-email">
                                <i class="ph ph-envelope-simple" style="margin-right:.4rem; color:var(--accent);"></i>
                                <?= htmlspecialchars($c->email) ?>
                            </div>

                            <div class="company-tag">
                                <i class="ph ph-buildings" style="color:var(--accent);"></i>
                                <?= htmlspecialchars($c->company ?? 'Independiente') ?>
                            </div>

                            <button class="row-action" title="Ver detalle">
                                <i class="ph ph-arrow-square-out"></i>
                            </button>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </main>
    </div>

</body>
</html>
