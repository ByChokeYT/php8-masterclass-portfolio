<?php
declare(strict_types=1);

session_start(); // Iniciar sesión para el historial

require_once __DIR__ . '/../src/Enums/MineralType.php';   
require_once __DIR__ . '/../src/Services/CalculatorService.php';

use App\Enums\MineralType;
use App\Services\CalculatorService;

$resultado = null;
$error = null;

// Inicializar historial si no existe
if (!isset($_SESSION['history'])) {
    $_SESSION['history'] = [];
}

// Recuperar resultado flash si existe (PRG Pattern)
if (isset($_SESSION['flash_result'])) {
    $resultado = $_SESSION['flash_result'];
    unset($_SESSION['flash_result']);
    session_write_close(); // Forzar guardado de la limpieza
    session_start(); // Reiniciar sesión para seguir usandola si es necesario (aunque solo leemos)
}

// Recuperar error flash si existe
if (isset($_SESSION['flash_error'])) {
    $error = $_SESSION['flash_error'];
    unset($_SESSION['flash_error']);
    session_write_close();
    session_start();
}

// Limpiar historial
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'clear_history') {
    $_SESSION['history'] = [];
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $mineralSymbol = $_POST['mineral'] ?? '';
        $peso = filter_input(INPUT_POST, 'peso', FILTER_VALIDATE_FLOAT);
        $cotizacion = filter_input(INPUT_POST, 'cotizacion', FILTER_VALIDATE_FLOAT);

        if (!$peso || !$cotizacion) {
            throw new Exception("Por favor ingrese valores numéricos válidos.");
        }

        $mineralEnum = MineralType::tryFrom($mineralSymbol);
        
        if (!$mineralEnum) {
            throw new Exception("Tipo de mineral no válido.");
        }

        $servicio = new CalculatorService();
        $total = $servicio->calculate($mineralEnum, $peso, $cotizacion);
        
        $currentResult = [
            'mineral' => $mineralEnum->value,
            'simbolo' => $mineralEnum->getSymbol(),
            'peso' => $peso,
            'cotizacion' => $cotizacion,
            'total' => $total,
            'fecha' => date('H:i:s')
        ];

        // Guardar en historial
        array_unshift($_SESSION['history'], $currentResult);
        if (count($_SESSION['history']) > 5) {
            array_pop($_SESSION['history']);
        }

        // PRG: Guardar resultado en flash y redirigir
        $_SESSION['flash_result'] = $currentResult;
        session_write_close(); // Forzar guardado antes de redirigir
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;

    } catch (Exception $e) {
        $_SESSION['flash_error'] = $e->getMessage();
        session_write_close(); // Forzar guardado antes de redirigir
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liquidación Pro</title>
    <link rel="icon" type="image/x-icon" href="https://www.php.net/favicon.ico">
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
</head>
<body>

    <div class="container glass-effect">
        
        <!-- Columna Izquierda: Formulario -->
        <div class="form-section">
            <header>
                <div class="logo-area">
                    <i class="ph-duotone ph-receipt size-lg"></i>
                    <div>
                        <h1>Liquidación V1.0</h1>
                        <p class="subtitle">Sistema Profesional de Cálculo (PHP 8.5)</p>
                    </div>
                </div>
            </header>

            <?php if ($error): ?>
                <div class="error-message">
                    <i class="ph-bold ph-warning-circle"></i> <?= $error ?>
                </div>
            <?php endif; ?>

            <form method="POST" id="calcForm">
                <div class="input-group">
                    <label><i class="ph-bold ph-cube"></i> Mineral</label>
                    <div class="input-wrapper">
                        <select name="mineral">
                            <?php foreach(MineralType::cases() as $mineral): ?>
                                <option value="<?= $mineral->value ?>">
                                    <?= $mineral->getEmoji() ?> <?= $mineral->value ?> (<?= $mineral->getSymbol() ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <i class="ph-bold ph-caret-down select-icon"></i>
                    </div>
                </div>

                <div class="row">
                    <div class="input-group">
                        <label><i class="ph-bold ph-scales"></i> Peso (Kg)</label>
                        <div class="input-wrapper">
                            <input type="number" step="0.01" name="peso" placeholder="0.00" required>
                        </div>
                    </div>

                    <div class="input-group">
                        <label><i class="ph-bold ph-currency-dollar"></i> Cotización</label>
                        <div class="input-wrapper">
                            <input type="number" step="0.01" name="cotizacion" placeholder="0.00" required>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn-primary">
                    <i class="ph-bold ph-calculator"></i> CALCULAR AHORA
                </button>
            </form>
        </div>

        <!-- Columna Derecha: Resultados + Historial -->
        <div class="result-section">
            
            <?php if ($resultado): ?>
                <!-- Resultado Actual -->
                <div class="result-content fade-in">
                    <div class="result-header">
                        <h2>Resultado Actual</h2>
                        <span class="badge">Nuevo</span>
                    </div>
                    
                    <div class="stat-grid">
                        <div class="stat-item">
                            <span class="label">Mineral</span>
                            <span class="value text-white"><?= $resultado['mineral'] ?></span>
                        </div>
                        <div class="stat-item">
                            <span class="label">Símbolo</span>
                            <span class="value"><?= $resultado['simbolo'] ?></span>
                        </div>
                        <div class="stat-item">
                            <span class="label">Peso Neto</span>
                            <span class="value"><?= number_format($resultado['peso'], 2) ?> <small>Kg</small></span>
                        </div>
                        <div class="stat-item">
                            <span class="label">Cotización</span>
                            <span class="value">$<?= number_format($resultado['cotizacion'], 2) ?></span>
                        </div>
                    </div>
                    
                    <div class="total-box">
                        <span class="total-label">LIQUIDACIÓN TOTAL</span>
                        <span class="total-amount">$ <?= number_format($resultado['total'], 2) ?></span>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Historial -->
            <!-- Historial -->
            <div class="history-section">
                <div class="history-title" style="display: flex; justify-content: space-between;">
                    <span><i class="ph-bold ph-clock-counter-clockwise"></i> Historial Reciente</span>
                    <?php if (!empty($_SESSION['history'])): ?>
                        <form method="POST" style="margin:0;">
                            <input type="hidden" name="action" value="clear_history">
                            <button type="submit" style="background:none; border:none; color: #ef4444; cursor:pointer; font-size: 0.75rem; padding:0;">
                                <i class="ph-bold ph-trash"></i> Borrar
                            </button>
                        </form>
                    <?php endif; ?>
                </div>

                <?php if (!empty($_SESSION['history'])): ?>
                    <div class="history-list">
                        <?php foreach ($_SESSION['history'] as $item): ?>
                            <!-- Saltamos el primero si es igual al resultado actual para no duplicar visualmente si acabamos de calcular -->
                            <?php if ($resultado && $item['fecha'] === $resultado['fecha']) continue; ?>
                            
                            <div class="history-item fade-in">
                                <div class="h-info">
                                    <span class="h-mineral"><?= $item['mineral'] ?> (<?= $item['simbolo'] ?>)</span>
                                    <span class="h-details"><?= $item['peso'] ?> Kg • $<?= $item['cotizacion'] ?> • <?= $item['fecha'] ?></span>
                                </div>
                                <div class="h-total">
                                    $<?= number_format($item['total'], 2) ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                        
                        <!-- Si solo tenemos el actual y nada más en historial "anterior", mostramos mensaje -->
                        <?php if ($resultado && count($_SESSION['history']) <= 1): ?>
                            <div class="empty-history" style="font-size: 0.8rem; padding: 1rem;">
                                No hay cálculos anteriores.
                            </div>
                        <?php endif; ?>
                    </div>
                <?php else: ?>
                    <div class="empty-history">
                        <i class="ph-duotone ph-notebook" style="font-size: 2rem; margin-bottom: 0.5rem;"></i>
                        <p>Tu historial aparecerá aquí.</p>
                    </div>
                <?php endif; ?>
            </div>

        </div>

    </div>

    <script src="js/script.js"></script>
</body>
</html>
