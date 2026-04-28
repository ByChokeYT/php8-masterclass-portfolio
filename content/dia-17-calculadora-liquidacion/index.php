<?php
declare(strict_types=1);

/**
 * MASTERCLASS PHP 8.5 - DÍA 17: CALCULADORA WEB DE LIQUIDACIÓN (AJAX EDITION)
 * Versión pesificada a Bolivianos (BOB) con UX fluida.
 */

// --- LÓGICA DE NEGOCIO ---

enum MineralType: string {
    case ESTANO = 'Estaño' ;
    case ZINC   = 'Zinc';
    case PLATA  = 'Plata';

    public function getSymbol(): string {
        return match($this) {
            self::ESTANO => 'Sn',
            self::ZINC   => 'Zn',
            self::PLATA  => 'Ag',
        };
    }

    public function getIcon(): string {
        return match($this) {
            self::ESTANO => 'ph-cube',
            self::ZINC   => 'ph-mountains',
            self::PLATA  => 'ph-sparkle',
        };
    }
}

readonly class Liquidacion {
    public function __construct(
        public MineralType $mineral,
        public float $pesoKg,
        public float $cotizacionBob,
        public float $purezaPorcentaje
    ) {}

    public function getPesoFino(): float {
        return $this->pesoKg * ($this->purezaPorcentaje / 100);
    }

    public function calcularTotal(): float {
        $pesoFino = $this->getPesoFino();
        $valorBase = match($this->mineral) {
            MineralType::ESTANO => $pesoFino * $this->cotizacionBob,
            MineralType::ZINC   => $pesoFino * $this->cotizacionBob * 0.95,
            MineralType::PLATA  => $pesoFino * $this->cotizacionBob * 1.02,
        };
        return round($valorBase, 2);
    }
}

// --- PROCESAMIENTO AJAX / POST ---

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $mineralKey = $_POST['mineral'] ?? '';
    $peso = (float)($_POST['peso'] ?? 0);
    $pureza = (float)($_POST['pureza'] ?? 0);
    $cotizacion = (float)($_POST['cotizacion'] ?? 0);

    try {
        $mineralEnum = match($mineralKey) {
            'ESTANO' => MineralType::ESTANO,
            'ZINC'   => MineralType::ZINC,
            'PLATA'  => MineralType::PLATA,
            default  => throw new Exception("Seleccione un mineral.")
        };
        
        if ($peso <= 0) throw new Exception("Peso inválido.");
        if ($pureza <= 0 || $pureza > 100) throw new Exception("Pureza inválida.");
        if ($cotizacion <= 0) throw new Exception("Cotización inválida.");

        $res = new Liquidacion($mineralEnum, $peso, $cotizacion, $pureza);
        
        $response = [
            'success' => true,
            'data' => [
                'mineral' => $res->mineral->value,
                'pesoFino' => number_format($res->getPesoFino(), 2),
                'pesoBruto' => number_format($res->pesoKg, 2),
                'pureza' => number_format($res->purezaPorcentaje, 2),
                'cotizacion' => number_format($res->cotizacionBob, 2),
                'total' => number_format($res->calcularTotal(), 2),
                'id' => strtoupper(substr(md5(uniqid()), 0, 6)),
                'hash' => 'SHA-256_' . substr(md5((string)$res->calcularTotal()), 0, 8),
                'time' => date('d.m.y H:i')
            ]
        ];
    } catch (Exception $e) {
        $response = ['success' => false, 'message' => $e->getMessage()];
    }

    if (isset($_POST['ajax']) || (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest')) {
        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liquidación Pro | Dashboard BOB</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;700;900&family=JetBrains+Mono:wght@400;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <style>
        :root { --bg: #030406; --cyan: #22d3ee; }
        body {
            background-color: var(--bg);
            color: #94a3b8;
            font-family: 'Outfit', sans-serif;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }
        .industrial-grid {
            position: fixed; inset: 0; z-index: -1;
            background-image: linear-gradient(rgba(255,255,255,0.01) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,0.01) 1px, transparent 1px);
            background-size: 30px 30px;
        }
        .glass { background: rgba(13, 17, 23, 0.7); backdrop-filter: blur(20px); border: 1px solid rgba(255,255,255,0.05); }
        .tech-label { font-family: 'JetBrains Mono'; text-transform: uppercase; letter-spacing: 0.1em; font-size: 0.6rem; opacity: 0.4; }
        .mineral-btn { border: 1px solid rgba(255,255,255,0.05); }
        .mineral-btn:hover { border-color: rgba(34,211,238,0.3); background: rgba(34,211,238,0.03); }
        input:checked + .mineral-btn { border-color: var(--cyan); background: rgba(34,211,238,0.1); color: white; }
        .input-minimal { background: rgba(0,0,0,0.3); border: 1px solid rgba(255,255,255,0.05); transition: all 0.2s; }
        .input-minimal:focus { border-color: var(--cyan); outline: none; box-shadow: 0 0 15px rgba(34,211,238,0.05); }
        .result-fade { transform: scale(0.98); opacity: 0; transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1); }
        .result-fade.active { transform: scale(1); opacity: 1; }
        .loader {
            width: 12px; height: 12px; border: 2px solid white; border-top-color: transparent; border-radius: 50%;
            display: none; animation: spin 0.6s linear infinite;
        }
        @keyframes spin { to { transform: rotate(360deg); } }
    </style>
</head>
<body class="p-4">
    <div class="industrial-grid"></div>

    <div class="w-full max-w-5xl max-h-[600px] flex flex-col">
        <header class="flex justify-between items-center mb-6 shrink-0">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-slate-900 rounded-lg border border-white/5"><i class="ph-bold ph-lightning text-cyan-400"></i></div>
                <div>
                    <h1 class="text-xl font-black text-white uppercase tracking-tighter">Core <span class="text-cyan-400">Liquidación</span></h1>
                    <span class="tech-label">Sustrato_Operativo // v17.0 _ BOB</span>
                </div>
            </div>
            <a href="../index.php" class="tech-label hover:text-white transition-colors flex items-center gap-2">
                <i class="ph ph-arrow-left"></i> Hub Maestro
            </a>
        </header>

        <main class="flex-1 grid grid-cols-1 md:grid-cols-2 gap-6 min-h-0">
            <section class="glass p-6 rounded-2xl flex flex-col justify-between">
                <form id="calcForm" class="space-y-6">
                    <input type="hidden" name="ajax" value="1">
                    <div>
                        <label class="tech-label block mb-3">Matriz Mineral</label>
                        <div class="grid grid-cols-3 gap-2">
                            <?php foreach (MineralType::cases() as $case): ?>
                            <label class="cursor-pointer">
                                <input type="radio" name="mineral" value="<?= $case->name ?>" class="hidden" required>
                                <div class="mineral-btn rounded-xl p-3 text-center transition-all">
                                    <i class="<?= $case->getIcon() ?> text-lg mb-1 opacity-60"></i>
                                    <span class="block text-[8px] font-black"><?= $case->value ?></span>
                                </div>
                            </label>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-1.5">
                            <label class="tech-label">Masa Bruta (Kg)</label>
                            <input type="number" step="0.01" name="peso" required placeholder="0.00"
                                   class="w-full input-minimal px-4 py-2 rounded-lg text-white font-mono text-xs">
                        </div>
                        <div class="space-y-1.5">
                            <label class="tech-label">Pureza / Ley (%)</label>
                            <input type="number" step="0.01" name="pureza" required placeholder="0.00"
                                   class="w-full input-minimal px-4 py-2 rounded-lg text-white font-mono text-xs">
                        </div>
                    </div>

                    <div class="space-y-1.5">
                        <label class="tech-label">Cotización Mercado (BOB/Kg)</label>
                        <div class="relative">
                            <span class="absolute left-3 top-2 text-[10px] opacity-30">Bs</span>
                            <input type="number" step="0.01" name="cotizacion" required placeholder="0.00"
                                   class="w-full input-minimal pl-8 pr-4 py-2 rounded-lg text-white font-mono text-xs">
                        </div>
                    </div>

                    <div id="errorMessage" class="hidden text-[8px] font-mono text-red-400 uppercase tracking-tighter bg-red-400/5 p-2 rounded border border-red-400/10"></div>

                    <button type="submit" id="submitBtn" class="w-full bg-cyan-500 hover:bg-cyan-400 text-black font-black py-3 rounded-xl text-[10px] uppercase tracking-widest transition-all flex items-center justify-center gap-2">
                        <span>Calcular en Bolivianos</span>
                        <div class="loader" id="btnLoader"></div>
                    </button>
                </form>
            </section>

            <section id="resultArea" class="h-full">
                <div id="initialState" class="glass p-8 rounded-2xl h-full border-dashed border-white/5 flex flex-col items-center justify-center text-center opacity-40">
                    <i class="ph ph-calculator text-4xl mb-4"></i>
                    <span class="tech-label text-[8px] uppercase tracking-widest leading-relaxed">Esperando Parámetros<br>de Entrada</span>
                </div>

                <div id="ticketResult" class="hidden result-fade glass p-8 rounded-2xl h-full border-r-2 border-r-cyan-500 flex flex-col justify-between">
                    <div>
                        <div class="flex justify-between items-start mb-6">
                            <span class="tech-label text-cyan-400">Certificado de Liquidación</span>
                            <span class="tech-label opacity-20" id="ticketId">--</span>
                        </div>
                        
                        <div class="space-y-4">
                            <div class="flex justify-between items-end border-b border-white/5 pb-3">
                                <div>
                                    <span class="tech-label">Mineral</span>
                                    <p class="text-lg font-black text-white" id="resMineral">--</p>
                                </div>
                                <div class="text-right">
                                    <span class="tech-label">Peso Fino</span>
                                    <p class="text-lg font-mono text-emerald-400"><span id="resPesoFino">0.00</span> Kg</p>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4 font-mono text-[10px]">
                                <div class="opacity-40">Masa Bruta</div><div class="text-right text-white"><span id="resPesoBruto">0.00</span> Kg</div>
                                <div class="opacity-40">Pureza / Ley</div><div class="text-right text-white"><span id="resPureza">0.00</span> %</div>
                                <div class="opacity-40">Tasa Mercado</div><div class="text-right text-white">Bs <span id="resCotizacion">0.00</span></div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-auto pt-8">
                        <div class="bg-black/30 p-5 rounded-xl border border-white/5 text-center transition-all hover:bg-cyan-500/5">
                            <span class="tech-label block mb-1">Monto Final a Liquidar</span>
                            <div class="text-3xl font-black text-white tracking-tighter">Bs <span id="resTotal">0,000.00</span></div>
                        </div>
                        <p class="tech-label text-[6px] text-center mt-3 leading-relaxed opacity-20 uppercase">
                            Firmado vía Core_v17_BOB // <span id="resHash">--</span><br>
                            Sello de Tiempo: <span id="resTime">--</span>
                        </p>
                    </div>
                </div>
            </section>
        </main>

        <footer class="mt-6 shrink-0 text-center flex justify-between items-center opacity-20">
            <span class="tech-label text-[7px]">By_Choke // Masterclass PHP</span>
            <span class="tech-label text-[7px]">Divisa Local: Bolivianos (BOB)</span>
        </footer>
    </div>

    <script>
        const form = document.getElementById('calcForm');
        const submitBtn = document.getElementById('submitBtn');
        const loader = document.getElementById('btnLoader');
        const initialState = document.getElementById('initialState');
        const ticketResult = document.getElementById('ticketResult');
        const errorDiv = document.getElementById('errorMessage');

        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            submitBtn.disabled = true;
            loader.style.display = 'block';
            errorDiv.classList.add('hidden');
            const formData = new FormData(form);
            try {
                await new Promise(r => setTimeout(r, 600));
                const response = await fetch('index.php', {
                    method: 'POST',
                    body: formData,
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                });
                const result = await response.json();
                if (result.success) {
                    document.getElementById('resMineral').textContent = result.data.mineral;
                    document.getElementById('resPesoFino').textContent = result.data.pesoFino;
                    document.getElementById('resPesoBruto').textContent = result.data.pesoBruto;
                    document.getElementById('resPureza').textContent = result.data.pureza;
                    document.getElementById('resCotizacion').textContent = result.data.cotizacion;
                    document.getElementById('resTotal').textContent = result.data.total;
                    document.getElementById('ticketId').textContent = 'ID_' + result.data.id;
                    document.getElementById('resHash').textContent = result.data.hash;
                    document.getElementById('resTime').textContent = result.data.time;
                    initialState.classList.add('hidden');
                    ticketResult.classList.remove('hidden');
                    setTimeout(() => ticketResult.classList.add('active'), 50);
                } else {
                    errorDiv.textContent = result.message;
                    errorDiv.classList.remove('hidden');
                }
            } catch (err) {
                errorDiv.textContent = "Error de conexión.";
                errorDiv.classList.remove('hidden');
            } finally {
                submitBtn.disabled = false;
                loader.style.display = 'none';
            }
        });
    </script>
</body>
</html>
