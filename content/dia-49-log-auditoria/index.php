<?php
declare(strict_types=1);

$dayNumber = 49;
$dayLabel = 'DÍA 49';
$dayTitle = 'Log de Auditoría (Trazabilidad)';
$dayDescription = 'Creación de un log de auditoría persistente para registrar acciones críticas de los usuarios (como inicio de sesión, inserción o edición) con fecha, IP y detalles del agente.';

$learningObjectives = [
    [
        'title' => 'Trazabilidad de Acciones',
        'desc' => 'Comprender la importancia de registrar acciones críticas por motivos de seguridad y auditoría compliance.'
    ],
    [
        'title' => 'Captura de Metadatos',
        'desc' => 'Obtener la IP del cliente (<code>$_SERVER[\'REMOTE_ADDR\']</code>) y su navegador (User-Agent).'
    ],
    [
        'title' => 'Estructura de Base de Datos',
        'desc' => 'Diseño de tablas de auditoría inmutables (solo inserción, sin permisos de actualización o borrado).'
    ]
];

$professorNote = '
    <div class="space-y-4">
        <p>¡Hola! En entornos empresariales y financieros, el log de auditoría es innegociable. Si un registro desaparece o se modifica, el log debe decir exactamente quién lo hizo, cuándo, y desde qué IP.</p>
        <div class="bg-blue-100/50 p-4 rounded-lg border-l-4 border-blue-400 my-4">
            <strong class="text-blue-900 block mb-1">Dato de Seguridad de Auditoría:</strong>
            <p>La tabla de logs de auditoría debe configurarse idealmente en la base de datos con políticas de <strong>sólo inserción (Append-Only)</strong>. Ningún usuario común, ni siquiera la propia aplicación web, debería tener permisos de SQL <code>UPDATE</code> o <code>DELETE</code> sobre esta tabla, para evitar que un atacante borre sus huellas.</p>
        </div>
    </div>
';

$files = [
    'public/index.php'  => ['path' => 'public/index.php', 'icon' => 'ph-browser'],
    'src/AuditLogger.php'=> ['path' => 'src/AuditLogger.php', 'icon' => 'ph-list-bullets'],
];

$executionMode = 'web';
$webAppUrl = '/content/dia-49-log-auditoria/public/index.php';

require_once __DIR__ . '/../../templates/pedagogical_view.php';
