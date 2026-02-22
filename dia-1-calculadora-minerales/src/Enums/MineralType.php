<?php

declare(strict_types=1);

namespace App\Enums;

/**
 * Enumeración para los tipos de minerales soportados.
 * Usamos un Enum respaldado por string.
 */
enum MineralType: string
{
    case ESTANO = 'Estaño';
    case ZINC = 'Zinc';
    case PLATA = 'Plata';

    /**
     * Obtener el símbolo químico o abreviatura.
     */
    public function getSymbol(): string
    {
        return match($this) {
            self::ESTANO => 'Sn',
            self::ZINC => 'Zn',
            self::PLATA => 'Ag',
        };
    }

    /**
     * Obtener el emoji representativo.
     */
    public function getEmoji(): string
    {
        return match($this) {
            self::ESTANO => '📦',  
            self::ZINC => '🏗️',    
            self::PLATA => '🪙',   
        };
    }
}
