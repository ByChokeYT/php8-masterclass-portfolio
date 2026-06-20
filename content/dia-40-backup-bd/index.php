<?php
declare(strict_types=1);

$dayNumber = 40;
$dayLabel = 'DÍA 40';
$dayTitle = 'Script de Backup de BD';
$dayDescription = 'Automatización del respaldo de bases de datos relacionales en archivos SQL comprimidos mediante PHP.';

$learningObjectives = [
    [
        'title' => 'Gestión de Archivos',
        'desc' => 'Uso de flujos y funciones del sistema de archivos como <code>fopen</code> y <code>fwrite</code>.'
    ],
    [
        'title' => 'Compresión Gzip',
        'desc' => 'Uso de la extensión zlib mediante <code>gzwrite</code> para optimizar almacenamiento.'
    ],
    [
        'title' => 'Automatización (Cron)',
        'desc' => 'Diseño de scripts ejecutables en consola preparados para programarse con cronjobs.'
    ]
];

$professorNote = '
    <div class="space-y-4">
        <p>¡Hola, dev! Realizar backups automáticos es la última línea de defensa contra desastres en producción (como ataques de ransomware o fallas en el disco duro).</p>
        <div class="bg-blue-100/50 p-4 rounded-lg border-l-4 border-blue-400 my-4">
            <strong class="text-blue-900 block mb-1">Dato de Operaciones (DevOps):</strong>
            <p>Siempre escribe backups a un sistema de almacenamiento externo descentralizado (como AWS S3 o un servidor FTP remoto) y nunca los dejes en el mismo servidor web que corre tu aplicación, para evitar que una intrusión total borre también los respaldos.</p>
        </div>
    </div>
';

$files = [
    'main.php'          => ['path' => 'main.php', 'icon' => 'ph-terminal-window'],
    'BackupService.php' => ['path' => 'src/Services/BackupService.php', 'icon' => 'ph-shield-check'],
];

$executionMode = 'cli';

$cliOutput = '
<div class="text-[#56b6c2] font-bold">SQL DATABASE BACKUP UTILITY v1.0</div>
<div class="text-slate-500">==============================================</div>
<div class="mt-3">
    <span class="text-[#98c379]">Iniciando respaldo de base de datos...</span>
</div>
<div class="mt-1 text-slate-400">[Backup] Generando esquema DDL...</div>
<div class="mt-1 text-slate-400">[Backup] Exportando datos de tabla `usuarios` (49 registros)...</div>
<div class="mt-1 text-slate-400">[Backup] Exportando datos de tabla `minerales` (120 registros)...</div>
<div class="mt-1 text-slate-400">[Backup] Comprimiendo archivo con Gzip...</div>
<br>
<div class="text-[#e5c07b]">==============================================</div>
<div class="text-[#98c379] font-bold text-sm bg-[#98c379]/10 inline-block px-3 py-1 rounded">
    ¡RESPALDO GUARDADO! backup_2026_06_19.sql.gz (14.2 KB)
</div>
';

require_once __DIR__ . '/../../templates/pedagogical_view.php';
