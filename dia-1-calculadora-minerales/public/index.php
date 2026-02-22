<?php
declare(strict_types=1);

session_start();

require_once __DIR__ . '/../src/Enums/MineralType.php';   
require_once __DIR__ . '/../src/DTO/Liquidacion.php';
require_once __DIR__ . '/../src/Services/CalculatorService.php';

use App\Enums\MineralType;
use App\DTO\Liquidacion;
use App\Services\CalculatorService;

$resultado = null;
$error = null;

// Recuperar resultado flash (PRG Pattern)
if (isset($_SESSION['flash_result'])) {
    $resultado = $_SESSION['flash_result'];
    unset($_SESSION['flash_result']);
}

// Recuperar error flash
if (isset($_SESSION['flash_error'])) {
    $error = $_SESSION['flash_error'];
    unset($_SESSION['flash_error']);
}

// Procesar formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $mineralSymbol = $_POST['mineral'] ?? '';
        $peso = filter_input(INPUT_POST, 'peso', FILTER_VALIDATE_FLOAT);
        $cotizacion = filter_input(INPUT_POST, 'cotizacion', FILTER_VALIDATE_FLOAT);
        $pureza = filter_input(INPUT_POST, 'pureza', FILTER_VALIDATE_FLOAT);

        if (!$peso || !$cotizacion || !$pureza || $peso <= 0 || $cotizacion <= 0 || $pureza <= 0 || $pureza > 100) {
            throw new Exception("Por favor ingrese valores numéricos válidos (Peso/Cotización > 0, Pureza entre 0.1 y 100).");
        }

        $mineralEnum = MineralType::tryFrom($mineralSymbol);
        
        if (!$mineralEnum) {
            throw new Exception("Tipo de mineral no válido.");
        }

        // Instanciar DTO
        $liquidacion = new Liquidacion($mineralEnum, $peso, $cotizacion, $pureza);
        
        // Calcular
        $servicio = new CalculatorService();
        $total = $servicio->calculate($liquidacion);
        
        // PRG: Guardar resultado en flash y redirigir
        $_SESSION['flash_result'] = [
            'mineral' => $mineralEnum->value,
            'simbolo' => $mineralEnum->getSymbol(),
            'emoji' => $mineralEnum->getEmoji(),
            'peso' => $peso,
            'pureza' => $pureza,
            'pesoFino' => $liquidacion->getPesoFino(),
            'cotizacion' => $cotizacion,
            'total' => $total,
            'fecha' => date('H:i:s')
        ];
        
        header("Location: index.php");
        exit;

    } catch (Exception $e) {
        $_SESSION['flash_error'] = $e->getMessage();
        header("Location: index.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculadora Minerales VIP</title>
    <!-- Favicon de PHP -->
    <link rel="icon" type="image/x-icon" href="https://www.php.net/favicon.ico">
    <!-- Usamos la fuente Inter para un look premium -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Iconos Phosphor -->
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <div class="glass-container">
        <!-- Columna Izquierda: Formulario -->
        <div class="form-section">
            <header>
                <div class="logo">
                    <i class="ph-duotone ph-gem"></i>
                    <div>
                        <h1>Pureza Mineral</h1>
                        <p>Liquidación v2.0 (PHP 8.5)</p>
                    </div>
                </div>
            </header>

            <?php if ($error): ?>
                <div class="alert error">
                    <i class="ph-bold ph-warning-circle"></i> <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="index.php">
                <div class="form-group full-width">
                    <label><i class="ph-bold ph-cube"></i> Tipo de Mineral</label>
                    <div class="select-wrapper">
                        <select name="mineral" required>
                            <option value="" disabled selected>Seleccione un mineral...</option>
                            <?php foreach(MineralType::cases() as $mineral): ?>
                                <option value="<?= $mineral->value ?>">
                                    <?= $mineral->getEmoji() ?> <?= $mineral->value ?> (<?= $mineral->getSymbol() ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <i class="ph-bold ph-caret-down select-icon"></i>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label><i class="ph-bold ph-scales"></i> Peso Bruto (Kg)</label>
                        <input type="number" step="0.01" min="0.01" name="peso" placeholder="Ej. 1000" required>
                    </div>
                    
                    <div class="form-group">
                        <label><i class="ph-bold ph-percent"></i> Pureza (Ley)</label>
                        <input type="number" step="0.01" min="0.01" max="100" name="pureza" placeholder="Ej. 50" required>
                    </div>
                </div>

                <div class="form-group full-width">
                    <label><i class="ph-bold ph-currency-dollar"></i> Cotización Actual (USD/Kg)</label>
                    <input type="number" step="0.01" min="0.01" name="cotizacion" placeholder="Ej. 10.50" required>
                </div>

                <button type="submit" class="btn-submit">
                    <i class="ph-bold ph-calculator"></i> CALCULAR LIQUIDACIÓN
                </button>
            </form>
        </div>

        <!-- Columna Derecha: Resultado -->
        <div class="result-section">
            <?php if ($resultado): ?>
                <div class="ticket fade-in">
                    <div class="ticket-header">
                        <h2>Ticket de Liquidación</h2>
                        <span class="badge">NUEVO</span>
                    </div>
                    
                    <div class="ticket-body">
                        <div class="data-row">
                            <span class="label">Mineral</span>
                            <span class="value mineral-name">
                                <?= $resultado['emoji'] ?> <?= $resultado['mineral'] ?> (<?= $resultado['simbolo'] ?>)
                            </span>
                        </div>
                        <div class="data-row">
                            <span class="label">Peso Bruto</span>
                            <span class="value"><?= number_format($resultado['peso'], 2) ?> Kg</span>
                        </div>
                        <div class="data-row highlight-pureza">
                            <span class="label">Pureza (Ley)</span>
                            <span class="value"><?= number_format($resultado['pureza'], 2) ?> %</span>
                        </div>
                        <div class="data-row">
                            <span class="label">Peso Fino</span>
                            <span class="value highlight-peso-fino"><?= number_format($resultado['pesoFino'], 2) ?> Kg</span>
                        </div>
                        <div class="data-row">
                            <span class="label">Cotización</span>
                            <span class="value">$ <?= number_format($resultado['cotizacion'], 2) ?> /Kg</span>
                        </div>
                        <div class="data-row">
                            <span class="label">Hora de cálculo</span>
                            <span class="value text-muted"><?= $resultado['fecha'] ?></span>
                        </div>
                    </div>

                    <div class="ticket-footer">
                        <span class="total-label">TOTAL A PAGAR</span>
                        <span class="total-amount">$ <?= number_format($resultado['total'], 2) ?></span>
                    </div>
                </div>
            <?php else: ?>
                <div class="empty-state">
                    <i class="ph-duotone ph-receipt"></i>
                    <p>El ticket de liquidación aparecerá aquí después de calcular.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

</body>
</html>
