<?php
declare(strict_types=1);

session_start();

echo "\033[1;33mGAME ARCHITECTURE — CLI SIMULATOR\033[0m\n";
echo "==============================================\n\n";

// Simulación de un juego de adivinanza en CLI
$secret = 42;
$attempts = [10, 50, 42];

echo "Sistema: \033[1;37mGenerando número aleatorio entre 1 y 100...\033[0m\n";
echo "Pista del Desarrollador: \033[0;90mEl número es $secret\033[0m\n\n";

foreach ($attempts as $idx => $guess) {
    $num = $idx + 1;
    echo "Intento #$num: \033[1;37m$guess\033[0m\n";
    
    if ($guess < $secret) {
        echo "Resultado: \033[1;33m¡Demasiado bajo!\033[0m\n";
    } elseif ($guess > $secret) {
        echo "Resultado: \033[1;31m¡Demasiado alto!\033[0m\n";
    } else {
        echo "Resultado: \033[1;32m¡CORRECTO! Has ganado.\033[0m\n";
        break;
    }
    echo "----------------------------------------------\n";
}

echo "\n\033[1;36mLOG DE SESIÓN (Persistencia):\033[0m\n";
echo "Intentos realizados: " . count($attempts) . "\n";
echo "Estado final: \033[1;32mGANADO\033[0m\n";
echo "==============================================\n";
