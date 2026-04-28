<?php

declare(strict_types=1);

namespace App\Enums;

/**
 * Clasificación médica del IMC según la OMS.
 */
enum ClasificacionImc
{
    case BAJO_PESO;
    case NORMAL;
    case SOBREPESO;
    case OBESIDAD_I;
    case OBESIDAD_II;
    case OBESIDAD_III;

    /**
     * Factory method — crea la instancia correcta según un valor IMC.
     */
    public static function fromImc(float $imc): self
    {
        return match(true) {
            $imc < 18.5 => self::BAJO_PESO,
            $imc < 25.0 => self::NORMAL,
            $imc < 30.0 => self::SOBREPESO,
            $imc < 35.0 => self::OBESIDAD_I,
            $imc < 40.0 => self::OBESIDAD_II,
            default     => self::OBESIDAD_III,
        };
    }

    /**
     * Etiqueta legible para el usuario.
     */
    public function getLabel(): string
    {
        return match($this) {
            self::BAJO_PESO    => 'Bajo peso',
            self::NORMAL       => 'Normal',
            self::SOBREPESO    => 'Sobrepeso',
            self::OBESIDAD_I   => 'Obesidad grado I',
            self::OBESIDAD_II  => 'Obesidad grado II',
            self::OBESIDAD_III => 'Obesidad grado III',
        };
    }

    /**
     * Color ANSI para presentación en terminal.
     */
    public function getColor(): string
    {
        return match($this) {
            self::BAJO_PESO    => '1;34', // Azul
            self::NORMAL       => '1;32', // Verde
            self::SOBREPESO    => '1;33', // Amarillo
            self::OBESIDAD_I   => '0;33', // Naranja
            self::OBESIDAD_II  => '1;31', // Rojo claro
            self::OBESIDAD_III => '0;31', // Rojo oscuro
        };
    }

    /**
     * Recomendación básica según la clasificación.
     */
    public function getRecomendacion(): string
    {
        return match($this) {
            self::BAJO_PESO    => 'Consulta un nutricionista para un plan de alimentación.',
            self::NORMAL       => 'Mantén tus hábitos. ¡Vas por buen camino!',
            self::SOBREPESO    => 'Considera ajustar dieta y aumentar actividad física.',
            self::OBESIDAD_I   => 'Recomendable consultar con un médico especialista.',
            self::OBESIDAD_II  => 'Importante iniciar tratamiento médico supervisado.',
            self::OBESIDAD_III => 'Busca atención médica especializada a la brevedad.',
        };
    }

    /**
     * Posición porcentual (0-100) para el indicador visual en la barra.
     */
    public function getPosicionBarra(): int
    {
        return match($this) {
            self::BAJO_PESO    => 10,
            self::NORMAL       => 30,
            self::SOBREPESO    => 52,
            self::OBESIDAD_I   => 65,
            self::OBESIDAD_II  => 78,
            self::OBESIDAD_III => 92,
        };
    }
}
