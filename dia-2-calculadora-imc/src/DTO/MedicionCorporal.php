<?php

declare(strict_types=1);

namespace App\DTO;

use App\Enums\SistemaUnidad;

/**
 * DTO inmutable que representa los datos físicos de una persona.
 * Internamente siempre trabaja en el sistema métrico (kg, metros) para asegurar precisión.
 */
readonly class MedicionCorporal
{
    /** Peso en gramos para evitar errores de precisión de punto flotante */
    public int $pesoGramos;

    /** Altura en milímetros para evitar errores de precisión de punto flotante */
    public int $alturaMilimetros;

    public function __construct(
        public SistemaUnidad $sistema,
        float $peso,
        float $altura,
        public string $nombre = 'Paciente'
    ) {
        if ($peso <= 0.0 || $altura <= 0.0) {
            throw new \ValueError('El peso y la altura deben ser mayores a 0.');
        }

        // Convertimos al sistema métrico (estándar interno)
        $pesoKilogramos = $sistema->convertirPesoAKg($peso);
        $alturaMetros   = $sistema->convertirAlturaAMetros($altura);

        // Guardamos como enteros de alta precisión (x1000)
        $this->pesoGramos        = (int) round($pesoKilogramos * 1000);
        $this->alturaMilimetros = (int) round($alturaMetros * 1000);
    }

    /**
     * Obtiene el peso en kilogramos (float).
     */
    public function getPesoKg(): float
    {
        return $this->pesoGramos / 1000;
    }

    /**
     * Obtiene la altura en metros (float).
     */
    public function getAlturaMetros(): float
    {
        return $this->alturaMilimetros / 1000;
    }

    /**
     * Obtiene el cuadrado de la altura en milímetros cuadrados.
     */
    public function getAlturaAlCuadradoMm2(): int
    {
        return $this->alturaMilimetros * $this->alturaMilimetros;
    }
}
