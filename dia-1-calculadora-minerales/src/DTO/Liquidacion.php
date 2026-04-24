<?php

declare(strict_types=1);

namespace App\DTO;

use App\Enums\MineralType;

/**
 * Data Transfer Object inmutable — PHP 8.5 readonly class.
 *
 * UPGRADE v2: Los valores monetarios se almacenan en CENTAVOS (int)
 * para eliminar la pérdida de precisión del punto flotante.
 * Se lanzan ValueError si la pureza está fuera del rango [0, 100].
 */
readonly class Liquidacion
{
    /** Peso en gramos (int) para evitar pérdida de flotante */
    public int $pesoGramos;

    /** Cotización en centavos USD por kg (int) */
    public int $cotizacionCentavos;

    /**
     * @throws \ValueError si la pureza está fuera del rango [0, 100]
     */
    public function __construct(
        public MineralType $mineral,
        float $pesoKg,
        float $cotizacionUsd,
        public float $purezaPorcentaje
    ) {
        // ── Validación estricta con ValueError (PHP 8) ──────────────────
        if ($purezaPorcentaje < 0.0 || $purezaPorcentaje > 100.0) {
            throw new \ValueError(
                sprintf(
                    'La pureza debe estar entre 0 y 100. Valor recibido: %s%%',
                    $purezaPorcentaje
                )
            );
        }

        if ($pesoKg <= 0.0) {
            throw new \ValueError('El peso debe ser mayor a 0 kg.');
        }

        if ($cotizacionUsd <= 0.0) {
            throw new \ValueError('La cotización debe ser mayor a 0 USD.');
        }

        // ── Conversión a enteros para cálculo seguro ──────────────────
        // Peso: flotante → gramos enteros (× 1000 con redondeo)
        $this->pesoGramos = (int) round($pesoKg * 1000);

        // Cotización: USD/kg → centavos/kg (× 100 con redondeo)
        $this->cotizacionCentavos = (int) round($cotizacionUsd * 100);
    }

    /**
     * Devuelve el peso bruto en kg (float) para visualización.
     */
    public function getPesoKg(): float
    {
        return $this->pesoGramos / 1000;
    }

    /**
     * Devuelve la cotización en USD (float) para visualización.
     */
    public function getCotizacionUsd(): float
    {
        return $this->cotizacionCentavos / 100;
    }

    /**
     * Calcula el peso fino en gramos (int) — operación entera, cero pérdida de precisión.
     * pesoFino = pesoGramos × (pureza / 100)
     */
    public function getPesoFinoGramos(): int
    {
        return (int) round($this->pesoGramos * ($this->purezaPorcentaje / 100));
    }

    /**
     * Peso fino para visualización en kg.
     */
    public function getPesoFinoKg(): float
    {
        return $this->getPesoFinoGramos() / 1000;
    }

    /**
     * Clasifica la calidad del mineral usando match — PHP 8.
     * Devuelve etiqueta, color CSS y descripción técnica del grado.
     *
     * @return array{label: string, color: string, desc: string}
     */
    public function getGradoCalidad(): array
    {
        return match(true) {
            $this->purezaPorcentaje >= 99.0 => [
                'label' => 'GRADO REFINERÍA',
                'color' => '#10b981',
                'desc'  => 'Pureza ultrafina — apto para uso industrial directo.',
            ],
            $this->purezaPorcentaje >= 80.0 => [
                'label' => 'ALTA CALIDAD',
                'color' => '#3b82f6',
                'desc'  => 'Concentrado de alta ley — prima de mercado aplicable.',
            ],
            $this->purezaPorcentaje >= 50.0 => [
                'label' => 'CALIDAD MEDIA',
                'color' => '#f59e0b',
                'desc'  => 'Concentrado estándar — requiere proceso de fundición.',
            ],
            $this->purezaPorcentaje >= 20.0 => [
                'label' => 'BAJA LEY',
                'color' => '#f97316',
                'desc'  => 'Mineral de baja ley — descuento por impurezas aplicado.',
            ],
            default => [
                'label' => 'MINERAL POBRE',
                'color' => '#ef4444',
                'desc'  => 'Por debajo del umbral económico mínimo de procesamiento.',
            ],
        };
    }
}
