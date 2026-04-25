<?php
declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use App\Services\AuthService;

$auth = new AuthService();
$auth->checkAuth();

$username = $_SESSION['username'];
$fullName = $_SESSION['full_name'];
$lastLogin = $_SESSION['last_login'];

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DÍA 38 // DASHBOARD // Masterclass PHP</title>
    <link rel="stylesheet" href="assets/css/style.css?v=<?= time() ?>">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;700;900&display=swap" rel="stylesheet">
</head>
<body>
<?php
$dayLabel = 'DÍA 38';
$dayTitle = 'Panel Seguro';
$prevUrl  = '../dia-37-acortador-url/public/index.php';
$nextUrl  = '';
require_once __DIR__ . '/../../_nav.php';
?>

    <div class="dashboard-container">
        <div class="welcome-info">
            <div style="font-size: 0.7rem; color: var(--accent); font-weight: 800; letter-spacing: 2px; text-transform: uppercase; margin-bottom: 0.5rem;">Sessión Activa ✅</div>
            <h2>Bienvenido, <?= htmlspecialchars($fullName) ?></h2>
            <p>Has accedido correctamente al área protegida de la Masterclass.</p>
        </div>

        <div class="stats-grid">
            <div class="stat-item">
                <span class="stat-val"><?= htmlspecialchars($username) ?></span>
                <span class="stat-label">Usuario Conectado</span>
            </div>
            <div class="stat-item">
                <span class="stat-val"><?= $lastLogin ?></span>
                <span class="stat-label">Hora de Acceso</span>
            </div>
        </div>

        <div style="background: rgba(79, 91, 147, 0.05); border: 1px solid var(--border); border-radius: 16px; padding: 1.5rem; margin-bottom: 2rem; text-align: left;">
            <div style="font-size: 0.65rem; color: var(--php-color); font-weight: 800; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 1rem; display: flex; justify-content: space-between; align-items: center;">
                <span><i class="ph ph-users"></i> Directorio de Usuarios (vía API REST)</span>
                <span id="api-status" style="color: var(--accent);">Cargando...</span>
            </div>
            
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse; font-size: 0.75rem;">
                    <thead>
                        <tr style="border-bottom: 1px solid var(--border); color: var(--white); opacity: 0.6;">
                            <th style="padding: 0.75rem; text-align: left;">ID</th>
                            <th style="padding: 0.75rem; text-align: left;">Usuario</th>
                            <th style="padding: 0.75rem; text-align: left;">Nombre Completo</th>
                        </tr>
                    </thead>
                    <tbody id="users-table-body">
                        <!-- Cargado vía API -->
                    </tbody>
                </table>
            </div>
        </div>

        <script>
            async function loadUsers() {
                try {
                    const response = await fetch('api/users.php');
                    const result = await response.json();
                    
                    if (result.status === 'success') {
                        const tbody = document.getElementById('users-table-body');
                        tbody.innerHTML = result.data.map(user => `
                            <tr style="border-bottom: 1px solid rgba(255,255,255,0.02);">
                                <td style="padding: 0.75rem; color: var(--accent); font-weight: 800;">#${user.id}</td>
                                <td style="padding: 0.75rem; color: var(--white); font-weight: 600;">${user.username}</td>
                                <td style="padding: 0.75rem; opacity: 0.7;">${user.full_name}</td>
                            </tr>
                        `).join('');
                        document.getElementById('api-status').innerText = 'API ONLINE';
                    }
                } catch (error) {
                    document.getElementById('api-status').innerText = 'API ERROR';
                    document.getElementById('api-status').style.color = 'var(--error)';
                }
            }
            loadUsers();
        </script>

        <a href="logout.php" class="btn-logout">
            <i class="ph ph-sign-out"></i> Cerrar Sesión
        </a>
    </div>

</body>
</html>
