<?php
declare(strict_types=1);

require_once file_exists(__DIR__ . '/../vendor/autoload.php') ? __DIR__ . '/../vendor/autoload.php' : __DIR__ . '/../../../vendor/autoload.php';

use App\Services\InvoiceService;

if (isset($_POST['action']) && $_POST['action'] === 'generate') {
    $invoiceService = new InvoiceService();
    
    // Preparar datos
    $items = [];
    $total = 0;
    
    foreach ($_POST['item_desc'] as $key => $desc) {
        if (!empty($desc)) {
            $qty = (float)($_POST['item_qty'][$key] ?? 1);
            $price = (float)($_POST['item_price'][$key] ?? 0);
            $subtotal = $qty * $price;
            $items[] = [
                'desc' => $desc,
                'qty' => $qty,
                'price' => $price
            ];
            $total += $subtotal;
        }
    }

    $data = [
        'invoice_number' => $_POST['invoice_number'] ?? 'INV-001',
        'client_name' => $_POST['client_name'] ?? 'Cliente General',
        'client_nit' => $_POST['client_nit'] ?? '000000000',
        'client_email' => $_POST['client_email'] ?? 'correo@ejemplo.com',
        'items' => $items,
        'total' => $total
    ];

    $invoiceService->generate($data);
    exit;
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DÍA 34 // PDF GENERATOR // Masterclass PHP</title>
    <link rel="icon" type="image/x-icon" href="https://www.php.net/favicon.ico">
    <link rel="stylesheet" href="assets/css/style.css?v=<?= time() ?>">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;800&display=swap" rel="stylesheet">
</head>
<body>
<?php
$dayLabel = 'DÍA 34';
$dayTitle = 'Generador de Facturas (PDF)';
$prevUrl  = '../dia-33-consumo-api-metales/public/index.php';
$nextUrl  = '';
require_once __DIR__ . '/../../../_nav.php';
?>

    <div class="dashboard">
        <header class="header">
            <div style="display: inline-flex; padding: 0.5rem 1rem; background: rgba(59, 130, 246, 0.1); color: var(--accent); border-radius: 99px; font-size: 0.7rem; font-weight: 700; margin-bottom: 1rem;">
                <i class="ph-bold ph-file-pdf"></i> NODO 34 // FASE 4
            </div>
            <h1>PDF Invoice Studio</h1>
            <p>Generación de documentos PDF mediante Dompdf y motores de renderizado HTML5.</p>
        </header>

        <form method="POST">
            <input type="hidden" name="action" value="generate">
            
            <div class="form-grid">
                <div class="field">
                    <label>Número de Factura</label>
                    <input type="text" name="invoice_number" value="INV-<?= date('Y') ?>-034" required>
                </div>
                <div class="field">
                    <label>Nombre del Cliente</label>
                    <input type="text" name="client_name" placeholder="Ej. Juan Pérez" required>
                </div>
                <div class="field">
                    <label>NIT / CI</label>
                    <input type="text" name="client_nit" placeholder="Ej. 123456789" required>
                </div>
                <div class="field">
                    <label>Email Cliente</label>
                    <input type="email" name="client_email" placeholder="cliente@ejemplo.com" required>
                </div>
            </div>

            <div class="items-section">
                <h3><i class="ph ph-list-numbers"></i> Detalles de la Factura</h3>
                
                <div class="item-header">
                    <span>Descripción</span>
                    <span>Cant.</span>
                    <span>Precio ($)</span>
                </div>

                <div class="item-row">
                    <input type="text" name="item_desc[]" value="Servicios de Consultoría PHP 8.5">
                    <input type="number" name="item_qty[]" value="1">
                    <input type="number" name="item_price[]" value="450">
                </div>

                <div class="item-row">
                    <input type="text" name="item_desc[]" placeholder="Producto/Servicio adicional">
                    <input type="number" name="item_qty[]" value="1">
                    <input type="number" name="item_price[]" value="0">
                </div>
            </div>

            <button type="submit" class="btn-generate">
                <i class="ph-bold ph-download-simple"></i> GENERAR Y DESCARGAR FACTURA
            </button>
        </form>
    </div>

    <div class="tech-info">
        <p>Técnica: Renderizado de buffer HTML a PDF con soporte CSS2.1/3 // Dompdf v3.0</p>
    </div>

</body>
</html>
