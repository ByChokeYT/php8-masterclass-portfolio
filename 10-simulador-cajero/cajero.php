#!/usr/bin/env php
<?php

declare(strict_types=1);

require_once __DIR__ . '/src/Classes/CajeroAutomatico.php';

use App\Classes\CajeroAutomatico;

// Inicializamos el cajero con un saldo de ejemplo (Bs. 2500)
$cajero = new CajeroAutomatico(2500.0);

echo "\n============================================\n";
echo "🏦 BIENVENIDO AL CAJERO AUTOMÁTICO (PHP 8)\n";
echo "============================================\n";

while (true) {
    echo "\n📋 MENÚ PRINCIPAL\n";
    echo "1. 💰 Consultar Saldo\n";
    echo "2. 💵 Depositar Dinero\n";
    echo "3. 🏧 Retirar Dinero\n";
    echo "4. 🚪 Salir\n";
    echo "--------------------------\n";
    echo "👉 Seleccione una opción: ";

    $opcion = trim(fgets(STDIN));

    switch ($opcion) {
        case '1':
            echo "\n✅  Su saldo actual es: Bs. " . number_format($cajero->consultarSaldo(), 2) . "\n";
            break;
        case '2':
            echo "\n📝 Ingrese el monto a depositar: Bs. ";
            $input = trim(fgets(STDIN));
            if (!is_numeric($input)) {
                echo "❌  Error: Ingrese un monto numérico válido.\n";
                break;
            }
            try {
                $cajero->depositar((float) $input);
                echo "✅  Depósito exitoso. Su nuevo saldo es: Bs. " . number_format($cajero->consultarSaldo(), 2) . "\n";
            } catch (Exception $e) {
                echo "❌  Error: " . $e->getMessage() . "\n";
            }
            break;
        case '3':
            echo "\n📝 Ingrese el monto a retirar: Bs. ";
            $input = trim(fgets(STDIN));
            if (!is_numeric($input)) {
                echo "❌  Error: Ingrese un monto numérico válido.\n";
                break;
            }
            try {
                $cajero->retirar((float) $input);
                echo "🏧  Retiro exitoso. Favor retire sus billetes.\n";
                echo "✅  Su nuevo saldo es: Bs. " . number_format($cajero->consultarSaldo(), 2) . "\n";
            } catch (Exception $e) {
                echo "❌  Error: " . $e->getMessage() . "\n";
            }
            break;
        case '4':
            echo "\n👋 Gracias por utilizar nuestro servicio. ¡Hasta pronto!\n\n";
            exit(0);
        default:
            echo "\n⚠️  Opción no válida. Por favor intente nuevamente.\n";
    }
}
