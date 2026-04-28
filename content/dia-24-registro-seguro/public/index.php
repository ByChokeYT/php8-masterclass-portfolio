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
use App\AuthManager;

$config = new DatabaseConfig(driver: 'sqlite', database: 'seguridad.sqlite');
$auth = new AuthManager(new DatabaseHost($config));

$notification = null;

// Recuperamos notificaciones post-PRG
if (isset($_SESSION['notification'])) {
    $notification = $_SESSION['notification'];
    unset($_SESSION['notification']);
}

// Lógica para cerrar sesión
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    
    try {
        if ($action === 'register') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            
            if ($auth->register($email, $password)) {
                $_SESSION['notification'] = ['type' => 'success', 'msg' => 'Cuenta creada exitosamente. ¡Puedes iniciar sesión!'];
            }
        } elseif ($action === 'login') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            
            $user = $auth->login($email, $password);
            
            if ($user !== false) {
                // Almacenar en sesión al iniciar correctamente
                $_SESSION['user'] = $user;
                $_SESSION['notification'] = ['type' => 'success', 'msg' => 'Bienvenido al sistema seguro.'];
            } else {
                $_SESSION['notification'] = ['type' => 'error', 'msg' => 'Credenciales incorrectas o cuenta no existe.'];
            }
        }
    } catch (Exception $e) {
        $_SESSION['notification'] = ['type' => 'error', 'msg' => $e->getMessage()];
    }
    
    // PRG para evitar reenvíos de formulario
    header('Location: index.php');
    exit;
}

$currentUser = $_SESSION['user'] ?? null;

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>DÍA 24 // REGISTRO SEGURO // Masterclass PHP</title>
    <link rel="icon" type="image/x-icon" href="https://www.php.net/favicon.ico">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;700;900&family=JetBrains+Mono:wght@400;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <link rel="stylesheet" href="assets/css/style.css?v=<?= time() ?>">
</head>
<body>
<?php
$dayLabel = 'DÍA 24';
$dayTitle = 'Registro Seguro Bcrypt';
$prevUrl  = 'http://localhost:8023';
$nextUrl  = 'http://localhost:8025';
require_once __DIR__ . '/../../../_nav.php';
?>
    <div class="industrial-grid"></div>

    <div class="container">
        <header class="header">
            <div>
                <span class="tech-label">Fase 3: Criptografía - password_hash()</span>
                <h1>Sistema de Autenticación D24</h1>
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

        <?php if ($currentUser): ?>
            <!-- Sesión Activa -->
            <div class="panel success-panel">
                <div class="panel-header">
                    <i class="ph-fill ph-shield-check" style="color: var(--success); font-size: 3rem;"></i>
                    <div>
                        <h2 style="color: var(--success); font-size: 1.5rem;">Caja Fuerte Desbloqueada</h2>
                        <p class="tech-label">ID Usuario: #<?= $currentUser['id'] ?></p>
                    </div>
                </div>
                <div style="margin: 2rem 0; font-size: 1.25rem;">
                    Identidad confirmada: <strong style="font-family: 'JetBrains Mono'; color: var(--accent);"><?= htmlspecialchars($currentUser['email']) ?></strong>
                </div>
                <a href="?logout=1" class="btn-submit" style="display:inline-block; text-align:center; text-decoration:none; max-width: 200px; background: rgba(244, 63, 94, 0.1); color: var(--error); border: 1px solid var(--error);">
                    <i class="ph-bold ph-sign-out"></i> CERRAR SESIÓN
                </a>
            </div>

        <?php else: ?>
            <!-- Dual Portal (Login / Registro) -->
            <div class="auth-layout">
                
                <!-- Columna Login -->
                <section class="panel">
                    <div class="panel-header">
                        <i class="ph-fill ph-sign-in"></i>
                        <h2>Acceso Seguro</h2>
                    </div>
                    <form method="POST">
                        <input type="hidden" name="action" value="login">
                        <div class="form-group">
                            <label>Correo Electrónico</label>
                            <div class="input-wrapper">
                                <i class="ph-bold ph-envelope"></i>
                                <input type="email" name="email" placeholder="operador@ejemplo.com" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Contraseña</label>
                            <div class="input-wrapper">
                                <i class="ph-bold ph-lock-key"></i>
                                <input type="password" name="password" placeholder="••••••••" required>
                            </div>
                        </div>
                        <button type="submit" class="btn-submit">
                            Autorizar Acceso
                        </button>
                    </form>
                </section>

                <!-- Columna Registro -->
                <section class="panel panel-register">
                    <div class="panel-header">
                        <i class="ph-fill ph-user-plus"></i>
                        <h2>Nueva Credencial</h2>
                    </div>
                    <form method="POST">
                        <input type="hidden" name="action" value="register">
                        <div class="form-group">
                            <label>Nuevo Correo</label>
                            <div class="input-wrapper">
                                <i class="ph-bold ph-envelope"></i>
                                <input type="email" name="email" placeholder="nuevo@ejemplo.com" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Contraseña Segura</label>
                            <div class="input-wrapper">
                                <i class="ph-bold ph-lock-key"></i>
                                <input type="password" name="password" placeholder="Mín. 8 caracteres" required minlength="8">
                            </div>
                            <div style="font-size: 0.6rem; margin-top: 0.5rem; opacity: 0.5; font-family: 'JetBrains Mono';">
                                * Será protegida usando el algoritmo BCRYPT y salting automático nativo de PHP 8.
                            </div>
                        </div>
                        <button type="submit" class="btn-submit" style="background: transparent; border: 1px solid var(--accent);">
                            Registrar Bóveda
                        </button>
                    </form>
                </section>

            </div>
        <?php endif; ?>
    </div>
</body>
</html>
