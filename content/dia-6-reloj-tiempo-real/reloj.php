#!/usr/bin/env php
<?php
declare(strict_types=1);

/**
 * Reloj en Tiempo Real - Proyecto 06
 * Muestra la hora actual actualizada cada segundo usando un bucle while
 */

// Función para limpiar la pantalla (compatible con Linux/Mac/Windows)
function clearScreen(): void {
    echo "\033[2J\033[H"; // ANSI escape codes
}

// Función para obtener la hora formateada
function getCurrentTime(): array {
    return [
        'hora' => date('H'),
        'minuto' => date('i'),
        'segundo' => date('s'),
        'fecha' => date('l, d \d\e F \d\e Y'),
    ];
}

// Función para crear un banner decorativo
function printBanner(): void {
    echo "\033[1;36m"; // Cyan bold
    echo "╔════════════════════════════════════════╗\n";
    echo "║     🕐  RELOJ EN TIEMPO REAL  🕐      ║\n";
    echo "║         PHP 8.5 - Proyecto 06         ║\n";
    echo "╚════════════════════════════════════════╝\033[0m\n\n";
}

// Función para mostrar el reloj digital
function displayClock(array $time): void {
    echo "\033[1;33m"; // Yellow bold
    echo "        ┌─────────────────────┐\n";
    echo "        │                     │\n";
    echo sprintf("        │   %s : %s : %s   │\n", $time['hora'], $time['minuto'], $time['segundo']);
    echo "        │                     │\n";
    echo "        └─────────────────────┘\033[0m\n\n";
}

// Función para mostrar información adicional
function displayInfo(array $time): void {
    echo "\033[0;37m"; // White
    echo "  📅 Fecha: \033[1;37m{$time['fecha']}\033[0m\n\n";
    echo "\033[0;90m  Presiona Ctrl+C para salir...\033[0m\n";
}

// ============================================
// BUCLE PRINCIPAL (while infinito)
// ============================================

echo "\033[?25l"; // Ocultar cursor

try {
    while (true) {
        clearScreen();
        
        $time = getCurrentTime();
        
        printBanner();
        displayClock($time);
        displayInfo($time);
        
        // Esperar 1 segundo antes de actualizar
        sleep(1);
    }
} finally {
    echo "\033[?25h"; // Mostrar cursor al salir
    echo "\n\033[1;32m¡Hasta luego! 👋\033[0m\n\n";
}
