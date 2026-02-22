<?php

declare(strict_types=1);

namespace App\DTO;

use App\Enums\MineralType;

/**
 * Data Transfer Object inmutable usando readonly class (PHP 8.2+).
 */
readonly class Liquidacion
{
    public function __construct(
        public MineralType $mineral,
        public float $pesoKg,
        public float $cotizacionUsd,
        public float $purezaPorcentaje
    ) {}

    /**
     * Calcula el peso fino real basado en el peso bruto y la pureza.
     */
    public function getPesoFino(): float
    {
        return $this->pesoKg * ($this->purezaPorcentaje / 100);
    }
}
