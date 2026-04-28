<?php

declare(strict_types=1);

namespace App\Contracts;

/**
 * Contrato para cualquier calculadora del sistema.
 * Asegura la consistencia en el cálculo y la obtención de resultados.
 */
interface CalculadoraInterface
{
    /**
     * Ejecuta el cálculo principal y devuelve el resultado numérico.
     */
    public function calcular(): float;

    /**
     * Devuelve un array asociativo con todos los detalles del resultado.
     *
     * @return array<string, mixed>
     */
    public function getResultado(): array;
}
