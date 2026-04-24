<?php
declare(strict_types=1);

/**
 * Enumeración para Tipos de Materiales
 */
enum Material: string {
    case ACERO_INOX = 'Acero Inoxidable';
    case BRONCE_SAE = 'Bronce SAE';
    case ALUMINIO = 'Aluminio Industrial';
    case ACERO_CARBONO = 'Acero al Carbono';

    public function getPriceFactor(): float {
        return match($this) {
            self::ACERO_INOX => 2.5,
            self::BRONCE_SAE => 3.2,
            self::ALUMINIO => 1.8,
            self::ACERO_CARBONO => 1.2,
        };
    }
}

/**
 * DTO para la Cotización
 */
readonly class QuotationRequest {
    public function __construct(
        public Material $material,
        public float $weight,
        public int $complexity,
        public bool $urgent = false
    ) {}

    public function calculateTotal(): float {
        $base = 100.0;
        $materialCost = $this->weight * $this->material->getPriceFactor() * 10;
        $complexityMarkup = $this->complexity * 50;
        $total = $base + $materialCost + $complexityMarkup;
        
        return $this->urgent ? $total * 1.3 : $total;
    }
}

// Lógica de procesamiento de formulario
$result = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $materialStr = $_POST['material'] ?? 'ACERO_INOX';
    $weight = (float)($_POST['weight'] ?? 1.0);
    $complexity = (int)($_POST['complexity'] ?? 1);
    $urgent = isset($_POST['urgent']);

    try {
        $material = Material::from($materialStr); // Simplificado para el ejemplo
    } catch (Error $e) {
        $material = Material::ACERO_INOX;
    }

    $request = new QuotationRequest($material, $weight, $complexity, $urgent);
    $result = $request->calculateTotal();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cotizador Industrial | Tornería Samuel</title>
    <link rel="icon" type="image/x-icon" href="https://www.php.net/favicon.ico">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&family=Outfit:wght@900&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <style>
        body {
            background-color: #020617;
            color: #f1f5f9;
            font-family: 'Inter', sans-serif;
        }
        .industrial-panel {
            background: linear-gradient(145deg, rgba(30, 41, 59, 0.7), rgba(15, 23, 42, 0.9));
            backdrop-filter: blur(12px);
            border: 1px solid rgba(56, 189, 248, 0.1);
        }
        .text-steel-gradient {
            background-clip: text;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-image: linear-gradient(to right, #7DD3FC, #38BDF8);
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-6">
<?php
$dayLabel = 'DÍA 12';
$dayTitle = 'Formulario de Cotización';
$prevUrl  = '';
$nextUrl  = '';
require_once __DIR__ . '/../../_nav.php';
?>
    <div class="max-w-4xl w-full grid md:grid-cols-2 gap-8">
        
        <!-- Info del Taller -->
        <div class="flex flex-col justify-center">
            <div class="inline-flex items-center gap-2 px-3 py-1 bg-sky-500/10 text-sky-400 text-xs font-bold uppercase tracking-widest mb-6 border border-sky-500/20 rounded w-fit">
                <i class="ph-bold ph-calculator"></i> Cotizador V1.0
            </div>
            <h1 class="text-4xl md:text-6xl font-black uppercase tracking-tight mb-4 leading-none">
                Cálculo de <br> <span class="text-steel-gradient">Precisión</span>
            </h1>
            <p class="text-slate-400 mb-8 text-lg">
                Genera presupuestos inmediatos basados en material, peso técnico y complejidad del mecanizado.
            </p>
            
            <div class="space-y-4">
                <div class="flex items-center gap-4 p-4 industrial-panel rounded-lg">
                    <i class="ph-bold ph-package text-sky-400 text-2xl"></i>
                    <div>
                        <div class="text-white font-bold text-sm uppercase">Materiales Propios</div>
                        <div class="text-xs text-slate-500">Stock permanente de aleaciones SAE e Inox.</div>
                    </div>
                </div>
                <div class="flex items-center gap-4 p-4 industrial-panel rounded-lg">
                    <i class="ph-bold ph-clock-countdown text-sky-400 text-2xl"></i>
                    <div>
                        <div class="text-white font-bold text-sm uppercase">Entrega Express</div>
                        <div class="text-xs text-slate-500">Prioridad para paradas de planta y minería.</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Formulario -->
        <div class="industrial-panel p-8 rounded-2xl shadow-2xl relative overflow-hidden">
            <div class="absolute top-0 right-0 p-4 opacity-5">
                <i class="ph-fill ph-gear text-9xl animate-slow-spin"></i>
            </div>

            <form method="POST" class="space-y-6 relative z-10">
                <div>
                    <label class="block text-xs font-black uppercase tracking-widest text-slate-500 mb-2">Material de la Pieza</label>
                    <select name="material" class="w-full bg-slate-900 border border-slate-700 rounded-lg px-4 py-3 text-white focus:border-sky-400 outline-none appearance-none">
                        <?php foreach (Material::cases() as $mat): ?>
                            <option value="<?= $mat->name ?>"><?= $mat->value ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-black uppercase tracking-widest text-slate-500 mb-2">Peso Est. (kg)</label>
                        <input type="number" step="0.1" name="weight" value="1.0" class="w-full bg-slate-900 border border-slate-700 rounded-lg px-4 py-3 text-white focus:border-sky-400 outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-black uppercase tracking-widest text-slate-500 mb-2">Complejidad (1-5)</label>
                        <input type="number" min="1" max="5" name="complexity" value="1" class="w-full bg-slate-900 border border-slate-700 rounded-lg px-4 py-3 text-white focus:border-sky-400 outline-none">
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <input type="checkbox" name="urgent" id="urgent" class="w-5 h-5 accent-sky-400">
                    <label for="urgent" class="text-sm font-bold text-slate-300 uppercase">Orden de Urgencia (+30%)</label>
                </div>

                <button type="submit" class="w-full bg-sky-500 hover:bg-sky-400 text-slate-900 font-black py-4 rounded-lg transition-all uppercase tracking-widest flex items-center justify-center gap-2">
                    <i class="ph-bold ph-receipt"></i> Calcular Presupuesto
                </button>
            </form>

            <?php if ($result !== null): ?>
            <div class="mt-8 p-6 bg-sky-500 text-slate-900 rounded-xl animate-bounce-in">
                <div class="text-xs font-black uppercase tracking-widest opacity-70">Total Estimado</div>
                <div class="text-4xl font-black">Bs. <?= number_format($result, 2) ?></div>
                <div class="text-[10px] mt-2 font-bold uppercase">* Este es un valor de referencia sujeto a inspección técnica.</div>
            </div>
            <?php endif; ?>
        </div>

    </div>
</body>
</html>
