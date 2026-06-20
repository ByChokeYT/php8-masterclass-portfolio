<?php
declare(strict_types=1);

require_once __DIR__ . '/src/Services/Mailer.php';

use App\Services\Mailer;

echo "SMTP MAIL SENDER SIMULATOR v1.0\n";
echo "==============================================\n";

$to = "cliente@example.com";
$subject = "Confirmación de Pedido - Minerales S.A.";
$body = "<h1>¡Pedido Confirmado!</h1><p>Su compra ha sido procesada con éxito.</p>";

try {
    $mailer = new Mailer("smtp.mailtrap.io", 2525, "bychoke_studios");
    $status = $mailer->send($to, $subject, $body);

    if ($status) {
        echo "==============================================\n";
        echo "¡CORREO ENVIADO CON ÉXITO! ID: msg_281a8f902c\n";
    }
} catch (\Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}
