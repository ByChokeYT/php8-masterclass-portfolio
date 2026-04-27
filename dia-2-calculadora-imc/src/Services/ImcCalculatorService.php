<?php

declare(strict_types=1);

namespace App\Services;

use App\Contracts\CalculadoraInterface;
use App\DTO\MedicionCorporal;
use App\Enums\ClasificacionImc;

/**
 * Servicio encargado de la lógica de cálculo del Índice de Masa Corporal.
 */
class ImcCalculatorService implements CalculadoraInterface
{
    /** Cache interna para el cálculo (Lazy calculation) */
    private ?float $imcCalculado = null;

    public function __construct(
        private readonly MedicionCorporal $medicion
    ) {}

    /**
     * Calcula el IMC utilizando aritmética entera para maximizar la precisión.
     * Fórmula: IMC = peso(kg) / altura²(m)
     */
    public function calcular(): float
    {
        if ($this->imcCalculado !== null) {
            return $this->imcCalculado;
        }

        // Operamos en enteros x100000 para mantener 2 decimales de precisión final
        // (gramos * 1000 * 100) / mm2
        $valorX100 = intdiv(
            $this->medicion->pesoGramos * 1000 * 100,
            $this->medicion->getAlturaAlCuadradoMm2()
        );

        return $this->imcCalculado = $valorX100 / 100;
    }

    /**
     * Devuelve el conjunto completo de datos del resultado.
     *
     * @return array<string, mixed>
     */
    public function getResultado(): array
    {
        $imc            = $this->calcular();
        $clasificacion  = ClasificacionImc::fromImc($imc);

        return [
            'imc'            => $imc,
            'imcFormateado'  => number_format($imc, 2),
            'label'          => $clasificacion->getLabel(),
            'color'          => $clasificacion->getColor(),
            'recomendacion'  => $clasificacion->getRecomendacion(),
            'posicionBarra'  => $clasificacion->getPosicionBarra(),
            'pesoKg'         => $this->medicion->getPesoKg(),
            'alturaMetros'   => $this->medicion->getAlturaMetros(),
            'nombre'         => $this->medicion->nombre,
        ];
    }

    /**
     * Calcula el peso ideal y la diferencia necesaria para alcanzarlo.
     *
     * @return array<string, mixed>
     */
    public function getPesoIdeal(): array
    {
        $alturaMetros = $this->medicion->getAlturaMetros();
        $pesoActual   = $this->medicion->getPesoKg();

        // Pesos para IMC 18.5 y 24.9 (límites de salud según la OMS)
        $pesoMinimo = 18.5 * ($alturaMetros ** 2);
        $pesoMaximo = 24.9 * ($alturaMetros ** 2);

        $diferencia = 0.0;
        if ($pesoActual < $pesoMinimo) {
            $diferencia = $pesoMinimo - $pesoActual;
        } elseif ($pesoActual > $pesoMaximo) {
            $diferencia = $pesoMaximo - $pesoActual;
        }

        return [
            'enRango'     => ($pesoActual >= $pesoMinimo && $pesoActual <= $pesoMaximo),
            'pesoMinimo'  => round($pesoMinimo, 1),
            'pesoMaximo'  => round($pesoMaximo, 1),
            'diferencia'  => round($diferencia, 1),
        ];
    }
}
