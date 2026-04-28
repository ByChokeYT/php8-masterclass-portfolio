<?php
declare(strict_types=1);
require_once file_exists(__DIR__ . '/../vendor/autoload.php') ? __DIR__ . '/../vendor/autoload.php' : __DIR__ . '/../../../vendor/autoload.php';

spl_autoload_register(function ($class) {
    if (str_starts_with($class, 'App\\')) {
        $file = __DIR__ . '/../src/' . str_replace(['App\\', '\\'], ['', '/'], $class) . '.php';
        if (file_exists($file)) require $file;
    }
});

use App\Services\QrService;

$qrService = new QrService();
$data   = trim($_POST['data']   ?? 'https://bychoke.yt');
$format = $_POST['format'] ?? 'svg';

$qrOutput = null;
$error    = null;

if (!empty($data)) {
    try {
        $qrOutput = $qrService->generate($data, $format);
    } catch (\Exception $e) {
        $error = $e->getMessage();
    }
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DÍA 31 // QR STUDIO // Masterclass PHP</title>
    <link rel="icon" type="image/x-icon" href="https://www.php.net/favicon.ico">
    <link rel="stylesheet" href="assets/css/style.css?v=<?= time() ?>">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
</head>
<body>
<?php
$dayLabel = 'DÍA 31';
$dayTitle = 'Generador de Códigos QR';
$prevUrl  = 'http://localhost:8030';
$nextUrl  = '';
require_once __DIR__ . '/../../../_nav.php';
?>

    <header class="header">
        <div class="pill"><i class="ph-bold ph-lightning"></i> NODO 31 // FASE 4</div>
        <h1>QR Code Studio</h1>
        <p>Generación vectorial mediante Composer y librerías externas.</p>
    </header>

    <div class="studio">

        <!-- FORM -->
        <div class="form-side">
            <form method="POST" action="index.php">

                <div class="field" style="margin-bottom: 1.25rem;">
                    <label>Contenido</label>
                    <textarea name="data" placeholder="URL, texto, email..."><?= htmlspecialchars($data) ?></textarea>
                </div>

                <div class="field" style="margin-bottom: 1.25rem;">
                    <label>Formato de Salida</label>
                    <select name="format">
                        <option value="svg" <?= $format === 'svg' ? 'selected' : '' ?>>Vectorial SVG</option>
                        <option value="png" <?= $format === 'png' ? 'selected' : '' ?>>Imagen PNG</option>
                    </select>
                </div>

                <?php if ($error): ?>
                    <div style="background: rgba(244,63,94,.1); border: 1px solid rgba(244,63,94,.2); color: #f43f5e; padding: 0.75rem 1rem; border-radius: 10px; font-size: 0.8rem; margin-bottom: 1rem;">
                        <i class="ph ph-warning-circle" style="margin-right: .3rem;"></i>
                        <?= htmlspecialchars($error) ?>
                    </div>
                <?php endif; ?>

                <button type="submit" class="btn-gen">
                    <i class="ph-bold ph-qr-code"></i> Generar Código QR
                </button>

                <div style="margin-top: 1.5rem; border-top: 1px solid var(--border); padding-top: 1.25rem; display: flex; flex-direction: column; gap: 0.5rem;">
                    <div style="font-size: 0.72rem; color: var(--muted); font-weight: 700; text-transform: uppercase; letter-spacing: 1px;">Técnica PHP 8.5</div>
                    <div style="font-size: 0.8rem; color: var(--muted); display: flex; align-items: center; gap: 0.5rem;">
                        <i class="ph ph-package" style="color: #f43f5e;"></i> chillerlan/php-qrcode v6.0
                    </div>
                    <div style="font-size: 0.8rem; color: var(--muted); display: flex; align-items: center; gap: 0.5rem;">
                        <i class="ph ph-files" style="color: #f43f5e;"></i> Composer Autoload (PSR-4)
                    </div>
                    <div style="font-size: 0.8rem; color: var(--muted); display: flex; align-items: center; gap: 0.5rem;">
                        <i class="ph ph-shield-check" style="color: #f43f5e;"></i> Objeto readonly QrService
                    </div>
                </div>

            </form>
        </div>

        <!-- PREVIEW -->
        <div class="preview-side">
            <?php if ($qrOutput && !$error): ?>
                <div class="qr-box">
                    <img src="<?= htmlspecialchars($qrOutput) ?>" alt="QR Code" style="width:160px;height:160px;display:block;">
                </div>

                <a href="<?= htmlspecialchars($qrOutput) ?>"
                   download="qr-bychoke-<?= date('Ymd-His') ?>.<?= $format ?>"
                   class="dl-btn">
                    <i class="ph ph-download-simple"></i> Descargar <?= strtoupper($format) ?>
                </a>

            <?php else: ?>
                <div class="preview-hint">
                    <i class="ph ph-qr-code"></i>
                    <span>El QR aparecerá<br>aquí al generar.</span>
                </div>
            <?php endif; ?>
        </div>

    </div>

    <div class="footer-label">MASTERCLASS PHP 8.5 // DESIGNED BY BYCHOKE</div>

</body>
</html>
