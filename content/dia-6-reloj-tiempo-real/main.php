<?php
declare(strict_types=1);

echo "\033[1;35mTIME ARCHITECTURE — CLI CLOCK\033[0m\n";
echo "==============================================\n\n";

$tzs = ['UTC', 'America/La_Paz', 'Europe/Madrid', 'Asia/Tokyo'];

echo "Sincronizando con servidores de tiempo...\n";
echo "----------------------------------------------\n";

foreach ($tzs as $tzName) {
    try {
        $tz = new \DateTimeZone($tzName);
        $now = new \DateTime('now', $tz);
        
        printf("\033[1;37m%-20s\033[0m | \033[1;32m%s\033[0m\n", 
            $tzName, 
            $now->format('Y-m-d H:i:s')
        );
    } catch (\Exception $e) {
        echo "Error cargando zona horaria: $tzName\n";
    }
}

echo "----------------------------------------------\n";
echo "\033[1;33mDETALLE TÉCNICO (Timestamp):\033[0m " . time() . "\n";
echo "==============================================\n";
