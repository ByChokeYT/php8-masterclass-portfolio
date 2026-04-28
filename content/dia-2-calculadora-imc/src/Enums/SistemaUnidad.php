<?php

declare(strict_types=1);

namespace App\Enums;

/**
 * Sistema de medición del usuario.
 * Permite manejar conversiones entre sistemas Métrico e Imperial de forma encapsulada.
 */
enum SistemaUnidad: string
{
    case METRICO   = 'Métrico';
    case IMPERIAL  = 'Imperial';

    /**
     * Obtiene la sigla de la unidad de peso.
     */
    public function getUnidadPeso(): string
    {
        return match($this) {
            self::METRICO  => 'kg',
            self::IMPERIAL => 'lbs',
        };
    }

    /**
     * Obtiene la sigla de la unidad de altura.
     */
    public function getUnidadAltura(): string
    {
        return match($this) {
            self::METRICO  => 'm',
            self::IMPERIAL => 'ft',
        };
    }

    /**
     * Convierte un peso dado al estándar internacional (kg).
     */
    public function convertirPesoAKg(float $peso): float
    {
        return match($this) {
            self::METRICO  => $peso,
            self::IMPERIAL => $peso * 0.453592,
        };
    }

    /**
     * Convierte una altura dada al estándar internacional (metros).
     */
    public function convertirAlturaAMetros(float $altura): float
    {
        return match($this) {
            self::METRICO  => $altura,
            self::IMPERIAL => $altura * 0.3048,
        };
    }
}
