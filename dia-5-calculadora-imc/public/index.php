<?php
declare(strict_types=1);

require_once __DIR__ . '/../src/Classes/Person.php';
require_once __DIR__ . '/../src/Services/BMIService.php';

use App\Classes\Person;
use App\Services\BMIService;

$result = null;
$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $weight = filter_input(INPUT_POST, 'weight', FILTER_VALIDATE_FLOAT);
        $height = filter_input(INPUT_POST, 'height', FILTER_VALIDATE_INT);

        if (!$weight || !$height) {
            throw new \InvalidArgumentException("Por favor ingrese valores válidos.");
        }

        $person = new Person($weight, $height);
        $service = new BMIService();
        $result = $service->calculate($person);

    } catch (\Throwable $e) {
        $error = $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculadora IMC | Salud</title>
    <link rel="icon" type="image/x-icon" href="https://www.php.net/favicon.ico">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <style>
        :root {
            /* Official PHP Color Palette */
            --primary: #4F5B93;       /* PHP Dark Blue */
            --primary-light: #8892BF; /* PHP Light Blue Accent */
            --bg: #C4CCDB;            /* PHP Logo Grey Background */
            --text: #232531;
            --white: #ffffff;
        }

        body {
            font-family: 'Outfit', sans-serif;
            background-color: var(--bg);
            color: var(--text);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            padding: 0.5rem;
            background: linear-gradient(135deg, #4F5B93 0%, #8892BF 100%);
        }

        .bmi-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(15px);
            padding: 1.2rem;
            border-radius: 16px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            width: 100%;
            max-width: 340px;
            text-align: center;
            border: 1px solid rgba(255, 255, 255, 0.4);
        }

        /* Header Section */
        .header-section { text-align: center; margin-bottom: 1rem; }
        .header-icon { font-size: 2rem; color: var(--primary); margin-bottom: 0.3rem; animation: pulse 2s ease-in-out infinite; }
        h1 { 
            margin: 0.3rem 0 0.2rem 0; 
            color: var(--primary); 
            letter-spacing: -1px; 
            font-size: 1.4rem;
            font-weight: 800;
        }
        .subtitle { color: #64748b; font-size: 0.75rem; margin: 0; }
        
        /* Form Inputs */
        .input-group { margin-bottom: 0.8rem; text-align: left; }
        label { 
            display: flex; 
            align-items: center; 
            gap: 0.3rem; 
            font-weight: 600; 
            margin-bottom: 0.4rem; 
            font-size: 0.8rem; 
            color: var(--primary); 
        }
        label i { font-size: 0.9rem; }
        
        .input-wrapper { position: relative; }
        .unit {
            position: absolute;
            right: 0.8rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--primary-light);
            font-weight: 600;
            font-size: 0.75rem;
        }
        
        input {
            width: 100%;
            padding: 0.7rem 2.5rem 0.7rem 0.8rem;
            border: 2px solid #E2E4F3;
            border-radius: 10px;
            font-size: 1rem;
            font-family: inherit;
            box-sizing: border-box;
            transition: all 0.3s ease;
            color: var(--primary);
            font-weight: 600;
            text-align: center;
        }
        input:focus { 
            outline: none; 
            border-color: var(--primary); 
            box-shadow: 0 0 0 3px rgba(79, 91, 147, 0.15);
            transform: scale(1.01);
        }
        input::placeholder { color: #ccc; font-weight: 400; }

        /* Button */
        .btn-calculate {
            width: 100%;
            padding: 0.8rem;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 0.95rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 0.8rem;
            box-shadow: 0 8px 16px -3px rgba(79, 91, 147, 0.4);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.4rem;
        }
        .btn-calculate:hover { 
            transform: translateY(-2px); 
            box-shadow: 0 12px 24px -5px rgba(79, 91, 147, 0.5);
        }
        .btn-calculate:active { transform: translateY(-1px); }

        /* Result Section */
        .result-section { margin-top: 1rem; animation: slideUp 0.5s ease; }
        
        /* BMI Scale */
        .bmi-scale { margin-bottom: 0.8rem; position: relative; }
        .scale-bar {
            display: flex;
            height: 6px;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        }
        .scale-segment { flex: 1; }
        .seg-low { background: #3b82f6; }
        .seg-normal { background: #10b981; }
        .seg-over { background: #f59e0b; }
        .seg-obese { background: #ef4444; }
        
        .scale-indicator {
            position: absolute;
            top: -6px;
            width: 0;
            height: 0;
            border-left: 6px solid transparent;
            border-right: 6px solid transparent;
            border-top: 10px solid var(--primary);
            transform: translateX(-50%);
            animation: bounce 0.6s ease;
        }

        .result-box {
            padding: 1rem;
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.6);
            border: 2px solid #E2E4F3;
            text-align: center;
        }
        .result-header {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.3rem;
            margin-bottom: 0.3rem;
        }
        .result-icon { font-size: 1.2rem; }
        .result-label { 
            font-size: 0.7rem; 
            text-transform: uppercase; 
            letter-spacing: 1px; 
            color: #64748b;
            font-weight: 600;
        }
        .bmi-value { 
            font-size: 2.5rem; 
            font-weight: 900; 
            color: var(--primary); 
            margin: 0.3rem 0;
            line-height: 1;
        }
        .diagnosis { 
            font-size: 1.1rem; 
            font-weight: 700; 
            margin: 0.5rem 0;
        }
        .result-info { 
            margin-top: 0.6rem; 
            padding-top: 0.6rem; 
            border-top: 1px solid #E2E4F3;
        }
        .result-info small { color: #64748b; font-size: 0.7rem; }
        
        /* Color States */
        .color-blue .diagnosis { color: #2563eb; }
        .color-green .diagnosis { color: #059669; }
        .color-orange .diagnosis { color: #f59e0b; }
        .color-red .diagnosis { color: #ef4444; }

        /* Animations */
        @keyframes fadeIn { 
            from { opacity: 0; transform: translateY(10px); } 
            to { opacity: 1; transform: translateY(0); } 
        }
        @keyframes slideUp { 
            from { opacity: 0; transform: translateY(20px); } 
            to { opacity: 1; transform: translateY(0); } 
        }
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
        @keyframes bounce {
            0%, 100% { transform: translateX(-50%) translateY(0); }
            50% { transform: translateX(-50%) translateY(-5px); }
        }
        
        .error { 
            color: #dc2626; 
            background: #fee2e2; 
            padding: 0.7rem; 
            border-radius: 10px; 
            margin-bottom: 1rem;
            border-left: 3px solid #dc2626;
            animation: fadeIn 0.3s ease;
            font-size: 0.85rem;
        }
    </style>
</head>
<body>
<?php
$dayLabel = 'DÍA 05';
$dayTitle = 'Calculadora IMC';
$prevUrl  = '';
$nextUrl  = '';
require_once __DIR__ . '/../../_nav.php';
?>

<div class="bmi-card">
    <div class="header-section">
        <i class="ph-duotone ph-heart-beat header-icon"></i>
        <h1>Calculadora IMC</h1>
        <p class="subtitle">Conoce tu Índice de Masa Corporal</p>
    </div>

    <?php if ($error): ?>
        <div class="error"><i class="ph-bold ph-warning"></i> <?= $error ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="input-group">
            <label><i class="ph ph-scales"></i> Peso</label>
            <div class="input-wrapper">
                <input type="number" name="weight" step="0.1" placeholder="70.5" required>
                <span class="unit">kg</span>
            </div>
        </div>

        <div class="input-group">
            <label><i class="ph ph-ruler"></i> Altura</label>
            <div class="input-wrapper">
                <input type="number" name="height" step="1" placeholder="175" required>
                <span class="unit">cm</span>
            </div>
        </div>

        <button type="submit" class="btn-calculate">
            <span>Calcular IMC</span>
            <i class="ph-bold ph-arrow-right"></i>
        </button>
    </form>

    <?php if ($result): ?>
        <div class="result-section">
            <div class="bmi-scale">
                <div class="scale-bar">
                    <div class="scale-segment seg-low"></div>
                    <div class="scale-segment seg-normal"></div>
                    <div class="scale-segment seg-over"></div>
                    <div class="scale-segment seg-obese"></div>
                </div>
                <div class="scale-indicator" style="left: <?= min(95, ($result['bmi'] / 40) * 100) ?>%"></div>
            </div>
            
            <div class="result-box color-<?= $result['diagnosis']['color'] ?>">
                <div class="result-header">
                    <i class="ph-fill <?= $result['diagnosis']['icon'] ?> result-icon"></i>
                    <span class="result-label">Tu IMC</span>
                </div>
                <div class="bmi-value"><?= $result['bmi'] ?></div>
                <div class="diagnosis"><?= $result['diagnosis']['estado'] ?></div>
                <div class="result-info">
                    <small>Rango saludable: 18.5 - 24.9</small>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

</body>
</html>
