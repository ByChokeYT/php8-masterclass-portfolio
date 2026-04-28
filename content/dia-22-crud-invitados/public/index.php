<?php

declare(strict_types=1);

// Autoloading manual
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
use App\GuestManager;

// Inicialización
$config = new DatabaseConfig(driver: 'sqlite', database: 'eventos_academia.sqlite');
$manager = new GuestManager(new DatabaseHost($config));

$notification = null;

// Manejo de Acciones
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    try {
        if ($action === 'create') {
            $name = trim($_POST['name'] ?? '');
            $email = trim($_POST['email'] ?? '');
            if ($name && $email) {
                try {
                    $manager->add($name, $email);
                    $notification = ['type' => 'success', 'msg' => 'Invitado añadido con éxito.'];
                } catch (\PDOException $e) {
                    if ($e->getCode() === '23000') {
                        $notification = ['type' => 'error', 'msg' => 'El correo electrónico ya está registrado.'];
                    } else {
                        throw $e;
                    }
                }
            }
        } elseif ($action === 'update') {
            $id = (int)($_POST['id'] ?? 0);
            $name = trim($_POST['name'] ?? '');
            $email = trim($_POST['email'] ?? '');
            if ($id && $name && $email) {
                $manager->update($id, $name, $email);
                $notification = ['type' => 'success', 'msg' => 'Datos actualizados con éxito.'];
            }
        } elseif ($action === 'update_status') {
            $id = (int)($_POST['id'] ?? 0);
            $status = $_POST['status'] ?? 'pending';
            $manager->updateStatus($id, $status);
            $notification = ['type' => 'success', 'msg' => 'Estado actualizado.'];
        } elseif ($action === 'delete') {
            $id = (int)($_POST['id'] ?? 0);
            $manager->delete($id);
            $notification = ['type' => 'success', 'msg' => 'Registro eliminado.'];
        }
    } catch (\Exception $e) {
        $notification = ['type' => 'error', 'msg' => 'Error: ' . $e->getMessage()];
    }
}

// Obtener datos para edición si aplica
$editingGuest = null;
if (isset($_GET['edit'])) {
    $editingGuest = $manager->getById((int)$_GET['edit']);
}

$guests = $manager->getAll();

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DÍA 22 // GESTOR DE INVITADOS // Masterclass PHP</title>
    <link rel="icon" type="image/x-icon" href="https://www.php.net/favicon.ico">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;700;900&family=JetBrains+Mono:wght@400;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<?php
$dayLabel = 'DÍA 22';
$dayTitle = 'CRUD de Invitados';
$prevUrl  = 'http://localhost:8021';
$nextUrl  = 'http://localhost:8023';
require_once __DIR__ . '/../../../_nav.php';
?>
    <div class="industrial-grid"></div>

    <div class="container">
        <header class="main-header">
            <div>
                <span class="tech-label">Fase 3: Operaciones CRUD</span>
                <h1>Gestor de Invitados</h1>
            </div>
            <a href="http://localhost:8000" class="tech-label hover:text-white transition-colors flex items-center gap-2" style="opacity: 0.6;">
                <i class="ph ph-arrow-left"></i> Volver al Portal
            </a>
        </header>

        <?php if ($notification): ?>
            <div class="alert alert-<?= $notification['type'] ?>">
                <i class="ph-bold ph-<?= $notification['type'] === 'success' ? 'check-circle' : 'warning-octagon' ?>"></i>
                <?= $notification['msg'] ?>
            </div>
        <?php endif; ?>

        <div class="dashboard-card">
            <!-- Formulario de Creación / Edición -->
            <section class="form-section <?= $editingGuest ? 'edit-mode-active' : '' ?>">
                <div class="form-header">
                    <div class="form-title">
                        <i class="ph-bold ph-<?= $editingGuest ? 'pencil-line' : 'user-plus' ?>"></i>
                        <span class="tech-label" style="margin: 0;"><?= $editingGuest ? 'Editar Asistente' : 'Añadir Nuevo Asistente' ?></span>
                    </div>
                    <?php if ($editingGuest): ?>
                        <a href="index.php" class="btn-cancel">
                            <i class="ph-bold ph-x"></i> CANCELAR EDICIÓN
                        </a>
                    <?php endif; ?>
                </div>

                <form method="POST" class="inline-form">
                    <input type="hidden" name="action" value="<?= $editingGuest ? 'update' : 'create' ?>">
                    <?php if ($editingGuest): ?>
                        <input type="hidden" name="id" value="<?= $editingGuest['id'] ?>">
                    <?php endif; ?>
                    
                    <div class="input-group">
                        <label class="tech-label">Nombre Completo</label>
                        <div class="input-container">
                            <input type="text" name="name" 
                                   value="<?= $editingGuest ? htmlspecialchars($editingGuest['name']) : '' ?>" 
                                   placeholder="Ej. Juan Perez" required>
                            <i class="ph ph-user"></i>
                        </div>
                    </div>
                    <div class="input-group">
                        <label class="tech-label">Correo Electrónico</label>
                        <div class="input-container">
                            <input type="email" name="email" 
                                   value="<?= $editingGuest ? htmlspecialchars($editingGuest['email']) : '' ?>" 
                                   placeholder="juan@ejemplo.com" required>
                            <i class="ph ph-envelope"></i>
                        </div>
                    </div>
                    <button type="submit" class="btn-primary" <?= $editingGuest ? 'style="background: var(--warning);"' : '' ?>>
                        <i class="ph-bold ph-<?= $editingGuest ? 'floppy-disk' : 'plus' ?>"></i> 
                        <?= $editingGuest ? 'GUARDAR' : 'REGISTRAR' ?>
                    </button>
                </form>
            </section>

            <!-- Tabla de Invitados -->
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>Invitado</th>
                            <th>Estado</th>
                            <th>Registro</th>
                            <th style="text-align: right;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($guests)): ?>
                            <tr>
                                <td colspan="4" style="text-align: center; opacity: 0.5; padding: 3rem;">
                                    No hay invitados registrados en el sistema.
                                </td>
                            </tr>
                        <?php endif; ?>

                        <?php foreach ($guests as $guest): ?>
                            <tr class="guest-row">
                                <td>
                                    <div class="guest-name"><?= htmlspecialchars($guest['name']) ?></div>
                                    <div class="guest-email"><?= htmlspecialchars($guest['email']) ?></div>
                                </td>
                                <td>
                                    <span class="badge badge-<?= $guest['status'] ?>">
                                        <?= strtoupper($guest['status']) ?>
                                    </span>
                                </td>
                                <td>
                                    <div style="font-size: 0.7rem; opacity: 0.5;">
                                        <?= date('d/m/Y H:i', strtotime($guest['created_at'])) ?>
                                    </div>
                                </td>
                                <td align="right">
                                    <div class="actions">
                                        <a href="?edit=<?= $guest['id'] ?>" class="action-btn" title="Editar">
                                            <i class="ph-bold ph-pencil"></i>
                                        </a>

                                        <?php if ($guest['status'] !== 'confirmed'): ?>
                                            <form method="POST" style="display:inline;">
                                                <input type="hidden" name="action" value="update_status">
                                                <input type="hidden" name="id" value="<?= $guest['id'] ?>">
                                                <input type="hidden" name="status" value="confirmed">
                                                <button type="submit" class="action-btn btn-confirm" title="Confirmar">
                                                    <i class="ph-bold ph-check"></i>
                                                </button>
                                            </form>
                                        <?php endif; ?>

                                        <form method="POST" style="display:inline;" onsubmit="return confirm('¿Seguro que deseas eliminar este registro?')">
                                            <input type="hidden" name="action" value="delete">
                                            <input type="hidden" name="id" value="<?= $guest['id'] ?>">
                                            <button type="submit" class="action-btn btn-delete" title="Eliminar">
                                                <i class="ph-bold ph-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
