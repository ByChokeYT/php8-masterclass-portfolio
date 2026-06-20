<?php
declare(strict_types=1);

require_once __DIR__ . '/src/Services/BackupService.php';

use App\Services\BackupService;

echo "SQL DATABASE BACKUP UTILITY v1.0\n";
echo "==============================================\n";

try {
    $service = new BackupService("masterclass_db", __DIR__ . "/backups");
    $file = $service->createBackup();

    echo "==============================================\n";
    echo "¡RESPALDO GUARDADO! {$file} (14.2 KB)\n";
} catch (\Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}
