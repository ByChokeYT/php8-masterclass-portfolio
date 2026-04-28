<?php

declare(strict_types=1);

namespace App\DTO;

use App\Enums\MineralType;

/**
 * DTO inmutable — PHP 8.2 readonly class.
 *
 * Los valores monetarios se almacenan en CENTAVOS (int)
 * para eliminar errores de punto flotante IEEE 754.
 */
readonly class Liquidacion
{
    /** Peso convertido a gramos (int) */
    public int $pesoGramos;

    /** Cotización convertida a centavos por kg (int) */
    public int $cotizacionCentavos;

    /**
     * Constructor con validaciones estrictas.
     * Si algo está mal, lanza ValueError — el programa para con mensaje claro.
     */
    public function __construct(
        public MineralType $mineral,
        float $pesoKg,
        float $cotizacionUsd,
        public float $purezaPorcentaje
    ) {
        // Validación 1: pureza entre 0% y 100%
        if ($purezaPorcentaje < 0.0 || $purezaPorcentaje > 100.0) {
            throw new \ValueError(
                sprintf('La pureza debe estar entre 0 y 100. Valor recibido: %s%%', $purezaPorcentaje)
            );
        }

        // Validación 2: peso positivo
        if ($pesoKg <= 0.0) {
            throw new \ValueError('El peso debe ser mayor a 0 kg.');
        }

        // Validación 3: cotización positiva
        if ($cotizacionUsd <= 0.0) {
            throw new \ValueError('La cotización debe ser mayor a 0 USD.');
        }

        // Conversión a enteros — adiós punto flotante
        $this->pesoGramos          = (int) round($pesoKg * 1000);
        $this->cotizacionCentavos  = (int) round($cotizacionUsd * 100);
    }

    /** Peso en kg para mostrar al usuario */
    public function getPesoKg(): float
    {
        return $this->pesoGramos / 1000;
    }

    /** Cotización en USD para mostrar al usuario */
    public function getCotizacionUsd(): float
    {
        return $this->cotizacionCentavos / 100;
    }

    /**
     * Peso fino = peso bruto × (pureza / 100)
     * Operación entera — cero pérdida de precisión.
     */
    public function getPesoFinoGramos(): int
    {
        return (int) round($this->pesoGramos * ($this->purezaPorcentaje / 100));
    }

    /** Peso fino en kg para mostrar al usuario */
    public function getPesoFinoKg(): float
    {
        return $this->getPesoFinoGramos() / 1000;
    }

    /**
     * Clasifica la calidad del mineral según su pureza.
     * match(true) evalúa condiciones en orden — devuelve la primera que sea true.
     *
     * @return array{label: string, color: string, desc: string}
     */
    public function getGradoCalidad(): array
    {
        return match(true) {
            $this->purezaPorcentaje >= 99.0 => [
                'label' => 'GRADO REFINERÍA',
                'color' => '1;32',
                'desc'  => 'Pureza ultrafina — apto para uso industrial directo.',
            ],
            $this->purezaPorcentaje >= 80.0 => [
                'label' => 'ALTA CALIDAD',
                'color' => '1;34',
                'desc'  => 'Concentrado de alta ley — prima de mercado aplicable.',
            ],
            $this->purezaPorcentaje >= 50.0 => [
                'label' => 'CALIDAD MEDIA',
                'color' => '1;33',
                'desc'  => 'Concentrado estándar — requiere proceso de fundición.',
            ],
            $this->purezaPorcentaje >= 20.0 => [
                'label' => 'BAJA LEY',
                'color' => '0;33',
                'desc'  => 'Mineral de baja ley — descuento por impurezas aplicado.',
            ],
            default => [
                'label' => 'MINERAL POBRE',
                'color' => '1;31',
                'desc'  => 'Por debajo del umbral económico mínimo de procesamiento.',
            ],
        };
    }
}
