<?php
declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use App\Services\AuthService;

if (session_status() === PHP_SESSION_NONE) session_start();
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit;
}

$auth = new AuthService();
$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = $_POST['username'] ?? '';
    $pass = $_POST['password'] ?? '';
    
    if ($auth->login($user, $pass)) {
        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Credenciales inválidas. Intenta con admin / php85";
    }
}

$lastUser = $_COOKIE['last_user'] ?? '';

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DÍA 38 // LOGIN SYSTEM // Masterclass PHP</title>
    <link rel="icon" type="image/x-icon" href="https://www.php.net/favicon.ico">
    <link rel="stylesheet" href="assets/css/style.css?v=<?= time() ?>">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;700;900&display=swap" rel="stylesheet">
</head>
<body>

    <div class="login-card">
        <div class="logo-icon">
            <i class="ph-fill ph-lock-key"></i>
        </div>
        <header class="header">
            <h1>Masterclass Auth</h1>
            <p>Acceso seguro al panel administrativo mediante sesiones y cookies.</p>
        </header>

        <?php if ($error): ?>
            <div class="error-msg">
                <i class="ph ph-warning-circle"></i> <?= $error ?>
            </div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label>Usuario</label>
                <div class="input-wrapper">
                    <i class="ph ph-user"></i>
                    <input type="text" name="username" placeholder="Ej: admin" value="<?= htmlspecialchars($lastUser) ?>" required autofocus>
                </div>
            </div>

            <div class="form-group">
                <label>Contraseña</label>
                <div class="input-wrapper">
                    <i class="ph ph-password"></i>
                    <input type="password" name="password" placeholder="••••••••" required>
                </div>
            </div>

            <button type="submit" class="btn-login">
                Entrar al Sistema
            </button>
        </form>

        <div style="margin-top: 2rem; font-size: 0.65rem; opacity: 0.4; line-height: 1.5;">
            <i class="ph ph-info"></i> Tip: Las credenciales están encriptadas en una base de datos SQLite usando BCRYPT.
        </div>
    </div>

    <footer style="position: absolute; bottom: 2rem; font-size: 0.6rem; opacity: 0.3; letter-spacing: 2px; text-transform: uppercase;">
        PHP 8.5 Security Framework // ByChoke
    </footer>

</body>
</html>
