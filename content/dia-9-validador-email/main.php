<?php
declare(strict_types=1);

require_once __DIR__ . '/src/Classes/EmailValidator.php';

use App\Classes\EmailValidator;

echo "\033[1;31mSECURITY SERVICE — EMAIL VALIDATOR CLI\033[0m\n";
echo "==============================================\n\n";

$emails = [
    'choke@google.com',
    'test@invalid-domain-123.com',
    'admin<script>@evil.com',
    'usuario@outlook.es'
];

$validator = new EmailValidator();

foreach ($emails as $email) {
    echo "Validando: \033[1;37m$email\033[0m\n";
    
    $result = $validator->validate($email);
    
    if ($result['isValid']) {
        echo "Resultado: \033[1;32m✓ VÁLIDO\033[0m\n";
        echo "Detalle  : Dominio con registros MX detectado.\n";
    } else {
        echo "Resultado: \033[1;31m✗ INVÁLIDO\033[0m\n";
        echo "Motivo   : " . ($result['error'] ?? 'Dominio no encontrado o registros MX fallidos.') . "\n";
    }
    echo "----------------------------------------------\n";
}

echo "\033[1;36mLOG DE SEGURIDAD:\033[0m Saneamiento FILTER_SANITIZE_EMAIL aplicado.\n";
echo "==============================================\n";
