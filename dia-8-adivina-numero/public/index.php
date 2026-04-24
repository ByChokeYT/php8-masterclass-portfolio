<?php
declare(strict_types=1);

session_start();

// Inicializar (New Game Logic)
if (!isset($_SESSION['numero_secreto']) || isset($_POST['reiniciar'])) {
    $_SESSION['numero_secreto'] = random_int(1, 100);
    $_SESSION['intentos'] = 0;
    $_SESSION['historial'] = [];
    $_SESSION['rango_min'] = 1;
    $_SESSION['rango_max'] = 100;
    $_SESSION['mensaje'] = 'Adivina el número entre 1 y 100';
    $_SESSION['estado'] = 'neutral';
    
    // Redirect on restart to clear POST
    if (isset($_POST['reiniciar'])) {
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit;
    }
}

// Procesar Intento
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['adivinar'])) {
    $intento = filter_input(INPUT_POST, 'numero', FILTER_VALIDATE_INT);
    
    if ($intento !== false && $intento >= 1 && $intento <= 100) {
        $_SESSION['intentos']++;
        array_unshift($_SESSION['historial'], $intento);
        
        $secreto = $_SESSION['numero_secreto'];
        
        if ($intento === $secreto) {
            $_SESSION['mensaje'] = "🎉 ¡CORRECTO! Era el $secreto";
            $_SESSION['estado'] = 'ganado';
        } elseif ($intento < $secreto) {
            $_SESSION['mensaje'] = "El número es MAYOR ▲";
            $_SESSION['estado'] = 'mayor';
            $_SESSION['rango_min'] = max($_SESSION['rango_min'], $intento + 1);
        } else {
            $_SESSION['mensaje'] = "El número es MENOR ▼";
            $_SESSION['estado'] = 'menor';
            $_SESSION['rango_max'] = min($_SESSION['rango_max'], $intento - 1);
        }
    }
    
    // PRG Pattern
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}

// Variables para la Vista
$min = $_SESSION['rango_min'];
$max = $_SESSION['rango_max'];
$intentos = $_SESSION['intentos'];
$mensaje = $_SESSION['mensaje'];
$estado = $_SESSION['estado'];
$ganado = ($estado === 'ganado');
$historial = array_slice($_SESSION['historial'], 0, 5);

// Cálculos para la Barra Visual
$total_range = 100;
$current_range_width = (($max - $min + 1) / $total_range) * 100;
$current_range_left = (($min - 1) / $total_range) * 100;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Neon Guess | PHP 8.5</title>
    <link rel="icon" type="image/x-icon" href="https://www.php.net/favicon.ico">
    <link href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@500;700;900&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg: #090910;
            --card: #13131f;
            --primary: #00f3ff; /* Cyan Neon */
            --secondary: #bc13fe; /* Purple Neon */
            --success: #00ff9d;
            --text: #e0e0e0;
        }
        
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body {
            font-family: 'Rajdhani', sans-serif;
            background-color: var(--bg);
            color: var(--text);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }
        
        .game-wrapper {
            width: 100%;
            max-width: 400px;
            padding: 1rem;
        }

        /* --- Header --- */
        .cyber-header {
            text-align: center;
            margin-bottom: 2rem;
            text-transform: uppercase;
            letter-spacing: 2px;
        }
        
        .cyber-header h1 {
            font-size: 2rem;
            color: #fff;
            text-shadow: 0 0 10px var(--primary);
            margin: 0;
            line-height: 1;
        }
        
        .cyber-header p {
            font-size: 0.8rem;
            color: var(--primary);
            opacity: 0.8;
            margin-top: 5px;
        }

        /* --- Visual Range Bar --- */
        .range-container {
            position: relative;
            height: 40px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 4px;
            margin-bottom: 2rem;
            border: 1px solid rgba(255, 255, 255, 0.1);
            overflow: hidden;
        }
        
        .range-labels {
            display: flex;
            justify-content: space-between;
            padding: 0 10px;
            font-size: 0.7rem;
            color: #666;
            margin-bottom: 5px;
        }
        
        .range-bar-active {
            position: absolute;
            top: 0;
            bottom: 0;
            background: linear-gradient(90deg, var(--secondary), var(--primary));
            border-radius: 4px;
            box-shadow: 0 0 15px var(--secondary);
            transition: all 0.5s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            /* Striped pattern overlay */
            background-image: linear-gradient(45deg,rgba(255,255,255,.15) 25%,transparent 25%,transparent 50%,rgba(255,255,255,.15) 50%,rgba(255,255,255,.15) 75%,transparent 75%,transparent);
            background-size: 1rem 1rem;
        }
        
        .range-text {
            position: absolute;
            width: 100%;
            text-align: center;
            line-height: 40px;
            font-weight: 700;
            font-size: 1.2rem;
            text-shadow: 0 1px 3px rgba(0,0,0,0.8);
            z-index: 2;
        }

        /* --- Input Area --- */
        .input-area {
            position: relative;
            margin-bottom: 2rem;
        }
        
        .cyber-input {
            width: 100%;
            background: transparent;
            border: none;
            border-bottom: 2px solid var(--primary);
            color: #fff;
            font-size: 4rem;
            text-align: center;
            font-family: 'Rajdhani', sans-serif;
            font-weight: 700;
            padding: 0.5rem 0;
            outline: none;
            text-shadow: 0 0 20px rgba(0, 243, 255, 0.3);
            transition: all 0.3s;
        }
        
        .cyber-input:focus {
            border-bottom-color: var(--secondary);
            text-shadow: 0 0 30px rgba(188, 19, 254, 0.5);
        }
        
        .cyber-input::placeholder {
            color: rgba(255, 255, 255, 0.1);
        }

        /* --- Buttons --- */
        .cyber-btn {
            width: 100%;
            background: var(--card);
            border: 1px solid var(--primary);
            color: var(--primary);
            padding: 1rem;
            font-family: 'Rajdhani', sans-serif;
            font-size: 1.2rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 2px;
            cursor: pointer;
            transition: all 0.3s;
            position: relative;
            overflow: hidden;
        }
        
        .cyber-btn:hover {
            background: var(--primary);
            color: #000;
            box-shadow: 0 0 20px var(--primary);
        }
        
        .cyber-btn.restart-btn {
            border-color: var(--success);
            color: var(--success);
        }
        
        .cyber-btn.restart-btn:hover {
            background: var(--success);
            color: #000;
            box-shadow: 0 0 20px var(--success);
        }

        /* --- Status & History --- */
        .status-display {
            text-align: center;
            min-height: 3rem;
            margin-bottom: 1rem;
        }
        
        .status-msg {
            font-size: 1.2rem;
            font-weight: 700;
        }
        
        .status-msg.mayor { color: var(--secondary); text-shadow: 0 0 10px var(--secondary); }
        .status-msg.menor { color: var(--primary); text-shadow: 0 0 10px var(--primary); }
        .status-msg.ganado { color: var(--success); text-shadow: 0 0 10px var(--success); font-size: 1.5rem; }

        .history-bar {
            margin-top: 2rem;
            display: flex;
            justify-content: center;
            gap: 10px;
        }
        
        .history-pill {
            background: rgba(255,255,255,0.1);
            padding: 5px 10px;
            font-size: 0.8rem;
            border-radius: 2px;
            border: 1px solid rgba(255,255,255,0.1);
        }

        /* --- Decorations --- */
        .corner {
            position: fixed;
            width: 50px;
            height: 50px;
            border: 2px solid var(--secondary);
            opacity: 0.5;
            pointer-events: none;
        }
        .tl { top: 20px; left: 20px; border-right: none; border-bottom: none; }
        .br { bottom: 20px; right: 20px; border-left: none; border-top: none; }

    </style>
</head>
<body>
<?php
$dayLabel = 'DÍA 08';
$dayTitle = 'Adivina el Número';
$prevUrl  = '';
$nextUrl  = '';
require_once __DIR__ . '/../../_nav.php';
?>

    <div class="corner tl"></div>
    <div class="corner br"></div>

    <div class="game-wrapper">
        <header class="cyber-header">
            <h1>Neon Guess</h1>
            <p>Rango Activo: <?= $min ?> - <?= $max ?></p>
        </header>

        <!-- Visual Range Bar -->
        <div class="range-labels">
            <span>1</span>
            <span>INTENTOS: <?= $intentos ?></span>
            <span>100</span>
        </div>
        <div class="range-container">
            <div class="range-text"><?= $min ?> - <?= $max ?></div>
            <div class="range-bar-active" style="left: <?= $current_range_left ?>%; width: <?= $current_range_width ?>%;"></div>
        </div>

        <!-- Feedback Area -->
        <div class="status-display">
            <div class="status-msg <?= $estado ?>">
                <?= $mensaje ?>
            </div>
        </div>

        <?php if (!$ganado): ?>
        <form method="POST" autocomplete="off">
            <div class="input-area">
                <input type="number" name="numero" class="cyber-input" 
                       min="<?= $min ?>" max="<?= $max ?>" 
                       placeholder="?" autofocus required>
            </div>
            <button type="submit" name="adivinar" class="cyber-btn">
                Ejecutar
            </button>
        </form>
        <?php else: ?>
        <form method="POST">
            <button type="submit" name="reiniciar" class="cyber-btn restart-btn">
                Reiniciar Sistema
            </button>
        </form>
        <?php endif; ?>

        <?php if (!empty($historial)): ?>
        <div class="history-bar">
            <?php foreach ($historial as $h): ?>
                <span class="history-pill"><?= $h ?></span>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>

</body>
</html>
