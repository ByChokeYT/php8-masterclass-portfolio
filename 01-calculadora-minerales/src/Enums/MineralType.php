<?php

declare(strict_types=1);

namespace App\Enums;

/**
 * Enumeración para los tipos de minerales soportados.
 * Usamos un Enum respaldado por string (String Backed Enum) para facilitar la visualización.
 */
enum MineralType: string
{
    case ESTANO = 'Estaño';
    case ZINC = 'Zinc';
    case PLATA = 'Plata';
    case ORO = 'Oro';

    /**
     * Obtener el símbolo químico o abreviatura.
     */
    public function getSymbol(): string
    {
        return match($this) {
            self::ESTANO => 'Sn',
            self::ZINC => 'Zn',
            self::PLATA => 'Ag',
            self::ORO => 'Au',
        };
    }

    /**
     * Obtener el emoji representativo.
     */
    public function getEmoji(): string
    {
        return match($this) {
            self::ESTANO => '📦',  // Paquete/Lingote (Representación genérica)
            self::ZINC => '🏗️',    // Estructuras (Galvanizado)
            self::PLATA => '🪙',   // Moneda (Plata)
            self::ORO => '⚜️',     // Lujo (Flor de Lis)
        };
    }
}
