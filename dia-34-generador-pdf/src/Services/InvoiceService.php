<?php
declare(strict_types=1);

namespace App\Services;

use Dompdf\Dompdf;
use Dompdf\Options;

class InvoiceService {
    public function generate(array $data): void {
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);
        $options->set('defaultFont', 'Helvetica');

        $dompdf = new Dompdf($options);
        
        $html = $this->getTemplate($data);
        
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        
        // Output to browser
        $dompdf->stream("factura-" . ($data['invoice_number'] ?? '001') . ".pdf", [
            "Attachment" => false
        ]);
    }

    private function getTemplate(array $data): string {
        $itemsHtml = '';
        foreach ($data['items'] as $item) {
            $itemsHtml .= "
            <tr>
                <td style='padding: 10px; border-bottom: 1px solid #eee;'>{$item['desc']}</td>
                <td style='padding: 10px; border-bottom: 1px solid #eee; text-align: center;'>{$item['qty']}</td>
                <td style='padding: 10px; border-bottom: 1px solid #eee; text-align: right;'>$" . number_format($item['price'], 2) . "</td>
                <td style='padding: 10px; border-bottom: 1px solid #eee; text-align: right;'>$" . number_format($item['qty'] * $item['price'], 2) . "</td>
            </tr>";
        }

        return "
        <html>
        <head>
            <style>
                body { font-family: 'Helvetica', sans-serif; color: #333; line-height: 1.5; }
                .invoice-box { max-width: 800px; margin: auto; padding: 30px; }
                .header { border-bottom: 2px solid #3b82f6; padding-bottom: 20px; margin-bottom: 20px; }
                .company-info { float: left; }
                .invoice-info { float: right; text-align: right; }
                .clear { clear: both; }
                table { width: 100%; border-collapse: collapse; margin-top: 30px; }
                th { background: #f8fafc; color: #64748b; text-align: left; padding: 10px; text-transform: uppercase; font-size: 12px; }
                .total-section { margin-top: 30px; float: right; width: 250px; }
                .total-row { display: flex; justify-content: space-between; padding: 5px 0; }
                .grand-total { font-size: 18px; font-weight: bold; color: #3b82f6; border-top: 2px solid #eee; padding-top: 10px; margin-top: 10px; }
                .footer { margin-top: 50px; font-size: 10px; color: #94a3b8; text-align: center; border-top: 1px solid #eee; padding-top: 20px; }
            </style>
        </head>
        <body>
            <div class='invoice-box'>
                <div class='header'>
                    <div class='company-info'>
                        <h2 style='color: #3b82f6; margin: 0;'>BYCHOKE SOLUTIONS</h2>
                        <p style='font-size: 12px; margin: 5px 0;'>Oruro, Bolivia<br>Calle Camacho #456<br>NIT: 456789123</p>
                    </div>
                    <div class='invoice-info'>
                        <h1 style='margin: 0; color: #cbd5e1;'>FACTURA</h1>
                        <p style='font-size: 14px; margin: 5px 0;'>
                            Nº: <strong>#{$data['invoice_number']}</strong><br>
                            Fecha: " . date('d/m/Y') . "
                        </p>
                    </div>
                    <div class='clear'></div>
                </div>

                <div style='margin-bottom: 40px;'>
                    <h4 style='margin-bottom: 5px; color: #64748b;'>FACTURAR A:</h4>
                    <p style='margin: 0;'><strong>{$data['client_name']}</strong></p>
                    <p style='margin: 0; font-size: 12px;'>{$data['client_nit']}<br>{$data['client_email']}</p>
                </div>

                <table>
                    <thead>
                        <tr>
                            <th>Descripción</th>
                            <th style='text-align: center;'>Cant.</th>
                            <th style='text-align: right;'>P. Unitario</th>
                            <th style='text-align: right;'>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        {$itemsHtml}
                    </tbody>
                </table>

                <div class='total-section'>
                    <div style='text-align: right;'>
                        <p style='margin: 5px 0;'>Subtotal: <strong>$" . number_format($data['total'], 2) . "</strong></p>
                        <p style='margin: 5px 0;'>IVA (13%): <strong>$" . number_format($data['total'] * 0.13, 2) . "</strong></p>
                        <div class='grand-total'>
                            TOTAL: $" . number_format($data['total'] * 1.13, 2) . "
                        </div>
                    </div>
                </div>
                <div class='clear'></div>

                <div class='footer'>
                    <p>Esta factura ha sido generada electrónicamente mediante el sistema Masterclass PHP 8.5.<br>
                    <strong>GRACIAS POR SU PREFERENCIA</strong></p>
                </div>
            </div>
        </body>
        </html>";
    }
}
