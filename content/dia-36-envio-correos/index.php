<?php
declare(strict_types=1);

$dayNumber = 36;
$dayLabel = 'DÍA 36';
$dayTitle = 'Envío de Correos con PHPMailer';
$dayDescription = 'Integración de servicios SMTP y envío automatizado de correos utilizando librerías externas de Composer.';

$learningObjectives = [
    [
        'title' => 'Integración PHPMailer',
        'desc' => 'Uso de Composer para gestionar la dependencia de PHPMailer.'
    ],
    [
        'title' => 'Configuración SMTP',
        'desc' => 'Parámetros de conexión segura con autenticación TLS/SSL.'
    ],
    [
        'title' => 'Estructura HTML en Emails',
        'desc' => 'Diseño de plantillas de correo profesionales con CSS en línea.'
    ]
];

$professorNote = '
    <div class="space-y-4">
        <p>¡Hola! Para enviar correos de producción nunca uses la función nativa <code>mail()</code> de PHP directamente, ya que carece de autenticación robusta y tus correos terminarán en la carpeta de Spam.</p>
        <div class="bg-blue-100/50 p-4 rounded-lg border-l-4 border-blue-400 my-4">
            <strong class="text-blue-900 block mb-1">Dato de Producción:</strong>
            <p>Usamos PHPMailer o librerías SMTP similares a través de Composer. Además, recuerda sanitizar las direcciones de correo recibidas usando <code>filter_var($email, FILTER_VALIDATE_EMAIL)</code> para evitar inyecciones de cabecera SMTP.</p>
        </div>
    </div>
';

$files = [
    'main.php'  => ['path' => 'main.php', 'icon' => 'ph-terminal-window'],
    'Mailer.php'=> ['path' => 'src/Services/Mailer.php', 'icon' => 'ph-envelope'],
];

$executionMode = 'cli';

$cliOutput = '
<div class="text-[#56b6c2] font-bold">SMTP MAIL SENDER SIMULATOR v1.0</div>
<div class="text-slate-500">==============================================</div>
<div class="mt-3">
    <span class="text-[#98c379]">Destinatario:</span> <span class="text-white">cliente@example.com</span>
</div>
<div class="mt-1">
    <span class="text-[#98c379]">Asunto:</span> <span class="text-white">Confirmación de Pedido - Minerales S.A.</span>
</div>
<br>
<div class="text-blue-400">[SMTP] Conectando a smtp.mailtrap.io:2525...</div>
<div class="text-blue-400">[SMTP] Autenticación de usuario exitosa.</div>
<div class="text-blue-400">[SMTP] Enviando cuerpo HTML (Multipart)...</div>
<br>
<div class="text-[#98c379] font-bold text-sm bg-[#98c379]/10 inline-block px-3 py-1 rounded">
    ¡CORREO ENVIADO CON ÉXITO! ID: msg_281a8f902c
</div>
';

require_once __DIR__ . '/../../templates/pedagogical_view.php';
