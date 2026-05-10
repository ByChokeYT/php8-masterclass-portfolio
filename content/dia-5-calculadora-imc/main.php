<?php
declare(strict_types=1);

require_once __DIR__ . '/src/Classes/Person.php';
require_once __DIR__ . '/src/Services/BMIService.php';

use App\Classes\Person;
use App\Services\BMIService;

echo "\033[1;32mHEALTH-TECH SERVICE — CLI EDITION\033[0m\n";
echo "==============================================\n\n";

try {
    $weight = 75.0;
    $height = 1.75;
    
    echo "Analizando paciente: Peso \033[1;37m$weight kg\033[0m | Altura \033[1;37m$height m\033[0m...\n\n";
    
    $person = new Person($weight, $height);
    $service = new BMIService();
    $result = $service->calculate($person);
    
    echo "\033[1;33mDIAGNÓSTICO MÉDICO:\033[0m\n";
    echo "----------------------------------------------\n";
    echo "IMC Calculado: \033[1;37m" . number_format($result['bmi'], 2) . "\033[0m\n";
    
    $estado = $result['diagnosis']['estado'];
    $color = match($result['diagnosis']['color']) {
        'green' => "\033[1;32m",
        'yellow' => "\033[1;33m",
        'red' => "\033[1;31m",
        default => "\033[0m"
    };
    
    echo "Estado Actual: " . $color . strtoupper($estado) . "\033[0m\n";
    echo "----------------------------------------------\n";
    echo "\033[1;36mRECOMENDACIÓN:\033[0m\n";
    echo "Mantenga una dieta equilibrada y actividad física regular.\n";
    
} catch (\InvalidArgumentException $e) {
    echo "\033[1;31mERROR DE VALIDACIÓN:\033[0m " . $e->getMessage() . "\n";
} catch (\Exception $e) {
    echo "\033[1;31mERROR INESPERADO:\033[0m " . $e->getMessage() . "\n";
}

echo "\n==============================================\n";
