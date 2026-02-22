<?php
declare(strict_types=1);

namespace App\Services;

use App\Classes\Person;

class BMIService {
    public function calculate(Person $person): array {
        $heightM = $person->getHeightInMeters();
        $bmi = $person->weight / ($heightM * $heightM);
        
        // Diagnóstico con match (PHP 8.0+)
        $diagnosis = match (true) {
            $bmi < 18.5 => ['estado' => 'Bajo Peso', 'color' => 'blue', 'icon' => 'ph-trend-down'],
            $bmi < 24.9 => ['estado' => 'Peso Normal', 'color' => 'green', 'icon' => 'ph-check-circle'],
            $bmi < 29.9 => ['estado' => 'Sobrepeso', 'color' => 'orange', 'icon' => 'ph-warning'],
            $bmi < 34.9 => ['estado' => 'Obesidad I', 'color' => 'red', 'icon' => 'ph-warning-octagon'],
            default => ['estado' => 'Obesidad II+', 'color' => 'red', 'icon' => 'ph-siren'],
        };

        return [
            'bmi' => round($bmi, 1),
            'diagnosis' => $diagnosis
        ];
    }
}
