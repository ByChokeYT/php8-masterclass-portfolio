<?php
declare(strict_types=1);

namespace App\Classes;

class Person {
    /**
     * Constructor con Promoción de Propiedades (PHP 8.0+)
     * @param float $weight Peso en KG
     * @param int $height Altura en CM
     */
    public function __construct(
        public float $weight,
        public int $height
    ) {
        // Validación básica en el constructor
        if ($weight <= 0 || $height <= 0) {
            throw new \InvalidArgumentException("El peso y la altura deben ser mayores a 0.");
        }
    }

    // Método helper para obtener altura en metros
    public function getHeightInMeters(): float {
        return $this->height / 100;
    }
}
