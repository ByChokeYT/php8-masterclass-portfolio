<?php
declare(strict_types=1);

$dayNumber = 47;
$dayLabel = 'DÍA 47';
$dayTitle = 'Autenticación con JWT';
$dayDescription = 'Construcción de un generador y validador de JSON Web Tokens (JWT) en PHP puro para proteger APIs REST de manera stateless.';

$learningObjectives = [
    [
        'title' => 'Estructura de un JWT',
        'desc' => 'Comprender las 3 partes de un token: Header (algoritmo), Payload (claims) y Signature (firma secreta).'
    ],
    [
        'title' => 'Codificación Base64Url',
        'desc' => 'Implementar codificación adaptada para URLs eliminando caracteres de relleno como <code>=</code>.'
    ],
    [
        'title' => 'Verificación con HMAC',
        'desc' => 'Usar <code>hash_hmac</code> con SHA256 para validar la integridad y firma del token recibido.'
    ]
];

$professorNote = '
    <div class="space-y-4">
        <p>¡Hola! Las sesiones tradicionales (cookies de sesión) requieren persistencia de estado en el servidor. En arquitecturas modernas de APIs distribuidas o microservicios, preferimos usar **tokens JWT**.</p>
        <div class="bg-blue-100/50 p-4 rounded-lg border-l-4 border-blue-400 my-4">
            <strong class="text-blue-900 block mb-1">Dato de Seguridad de APIs:</strong>
            <p>Los JWT son <strong>stateless</strong> (sin estado): el servidor no necesita guardar nada en memoria. Toda la información del usuario viaja en el mismo token, protegida por una firma criptográfica usando una contraseña secreta. ¡Nunca almacenes contraseñas o datos altamente confidenciales en el Payload, ya que cualquiera puede decodificarlo usando Base64!</p>
        </div>
    </div>
';

$files = [
    'public/index.php' => ['path' => 'public/index.php', 'icon' => 'ph-browser'],
    'src/JWT.php'      => ['path' => 'src/JWT.php', 'icon' => 'ph-key'],
];

$executionMode = 'web';
$webAppUrl = '/content/dia-47-jwt-auth/public/index.php';

require_once __DIR__ . '/../../templates/pedagogical_view.php';
