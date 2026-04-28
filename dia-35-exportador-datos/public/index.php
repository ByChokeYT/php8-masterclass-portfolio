<?php
declare(strict_types=1);

require_once file_exists(__DIR__ . '/../vendor/autoload.php') ? __DIR__ . '/../vendor/autoload.php' : __DIR__ . '/../../vendor/autoload.php';

use App\Services\ExportService;

$miningData = [
    ['FECHA' => '2026-04-20', 'MINERAL' => 'Estaño', 'PRODUCCION_TN' => 125.50, 'CALIDAD' => 'Alta', 'ORIGEN' => 'Mina Huanuni'],
    ['FECHA' => '2026-04-21', 'MINERAL' => 'Zinc', 'PRODUCCION_TN' => 450.20, 'CALIDAD' => 'Media', 'ORIGEN' => 'Mina Colquiri'],
    ['FECHA' => '2026-04-22', 'MINERAL' => 'Plata', 'PRODUCCION_TN' => 12.80, 'CALIDAD' => 'Alta', 'ORIGEN' => 'San Cristóbal'],
    ['FECHA' => '2026-04-23', 'MINERAL' => 'Estaño', 'PRODUCCION_TN' => 98.40, 'CALIDAD' => 'Media', 'ORIGEN' => 'Mina Huanuni'],
    ['FECHA' => '2026-04-24', 'MINERAL' => 'Plomo', 'PRODUCCION_TN' => 210.15, 'CALIDAD' => 'Baja', 'ORIGEN' => 'Mina Bolívar'],
];

if (isset($_GET['action']) && $_GET['action'] === 'export') {
    $format = $_GET['format'] ?? 'csv';
    $customName = $_GET['filename'] ?? 'reporte';
    $exportService = new ExportService();
    try {
        $exportService->export($miningData, $format, $customName);
    } catch (\Exception $e) {
        die($e->getMessage());
    }
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DÍA 35 // DATA EXPORTER // Masterclass PHP</title>
    <link rel="icon" type="image/x-icon" href="https://www.php.net/favicon.ico">
    <link rel="stylesheet" href="assets/css/style.css?v=<?= time() ?>">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;700;900&display=swap" rel="stylesheet">
</head>
<body>
<?php
$dayLabel = 'DÍA 35';
$dayTitle = 'Exportador Excel/CSV';
$prevUrl  = '../dia-34-generador-pdf/public/index.php';
$nextUrl  = '';
require_once __DIR__ . '/../../_nav.php';
?>

    <div class="container">
        <div class="card">
            <header class="header">
                <div class="pill">NODO 35 // FASE 4</div>
                <h1>Data Exporter Studio</h1>
                <p>Generación de reportes tabulares mediante PhpSpreadsheet y manejo de buffers de salida.</p>
            </header>

            <section style="margin-bottom: 2.5rem;">
                <div style="font-size: 0.7rem; color: var(--php-color); font-weight: 800; margin-bottom: 1rem; text-transform: uppercase; letter-spacing: 1px;">Configuración de Descarga</div>
                <div class="field" style="margin-bottom: 1.5rem; display: flex; flex-direction: column; gap: 0.5rem;">
                    <label style="font-size: 0.65rem; font-weight: 700; text-transform: uppercase; color: var(--white); opacity: 0.6;">Nombre del Archivo Base</label>
                    <input type="text" id="filename_input" value="reporte_minero_oruro" style="background: rgba(255,255,255,0.05); border: 1px solid var(--border); padding: 0.75rem 1rem; border-radius: 10px; color: var(--white); font-size: 0.9rem; width: 100%; outline: none;" onkeyup="updateLinks()">
                    <div style="font-size: 0.6rem; color: var(--text); opacity: 0.4;">Se añadirá automáticamente la fecha actual (<?= date('Ymd') ?>) al final.</div>
                </div>

                <div style="font-size: 0.7rem; color: var(--php-color); font-weight: 800; margin-bottom: 1rem; text-transform: uppercase; letter-spacing: 1px;">Previsualización de Reporte</div>
                <div style="overflow-x: auto; border: 1px solid var(--border); border-radius: 12px; background: rgba(0,0,0,0.2);">
                    <table class="table-preview">
                        <thead>
                            <tr>
                                <th>Mineral</th>
                                <th>Prod. (TN)</th>
                                <th>Calidad</th>
                                <th>Origen</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($miningData as $row): ?>
                                <tr>
                                    <td style="color: var(--white); font-weight: 600;"><?= $row['MINERAL'] ?></td>
                                    <td><?= number_format($row['PRODUCCION_TN'], 2) ?></td>
                                    <td>
                                        <span style="font-size: 0.6rem; padding: 0.2rem 0.5rem; border-radius: 4px; background: <?= $row['CALIDAD'] === 'Alta' ? 'rgba(16,185,129,0.15)' : 'rgba(245,158,11,0.15)' ?>; color: <?= $row['CALIDAD'] === 'Alta' ? '#10b981' : '#f59e0b' ?>;">
                                            <?= $row['CALIDAD'] ?>
                                        </span>
                                    </td>
                                    <td style="opacity: 0.6;"><?= $row['ORIGEN'] ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </section>

            <div class="actions">
                <a href="?action=export&format=xlsx&filename=reporte_minero_oruro" id="btn_excel" class="btn-export btn-excel">
                    <i class="ph-bold ph-microsoft-excel-logo"></i> Exportar XLSX
                </a>
                <a href="?action=export&format=csv&filename=reporte_minero_oruro" id="btn_csv" class="btn-export btn-csv">
                    <i class="ph-bold ph-file-csv"></i> Exportar CSV
                </a>
            </div>

            <script>
                function updateLinks() {
                    const filename = document.getElementById('filename_input').value.trim() || 'reporte';
                    document.getElementById('btn_excel').href = `?action=export&format=xlsx&filename=${filename}`;
                    document.getElementById('btn_csv').href = `?action=export&format=csv&filename=${filename}`;
                }
            </script>
        </div>

        <div style="margin-top: 2rem; padding: 1.5rem; background: rgba(79, 91, 147, 0.05); border: 1px dashed rgba(79, 91, 147, 0.2); border-radius: 12px; display: flex; gap: 1rem; align-items: flex-start;">
            <i class="ph ph-terminal-window" style="color: var(--php-color); font-size: 1.25rem;"></i>
            <div style="font-size: 0.75rem; color: #94a3b8; line-height: 1.6;">
                <strong style="color: var(--php-color);">Lógica del Reto:</strong> Manipulación de cabeceras HTTP (`Content-Type` y `Content-Disposition`) para forzar descargas en el navegador, integrando tipos de datos estrictos para la generación de archivos binarios.
            </div>
        </div>

        <footer class="footer-label">MASTERCLASS PHP 8.5 // DESIGNED BY BYCHOKE</footer>
    </div>

</body>
</html>
