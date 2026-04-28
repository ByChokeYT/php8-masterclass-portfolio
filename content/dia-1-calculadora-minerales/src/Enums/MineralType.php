<?php

declare(strict_types=1);

namespace App\Enums;

/**
 * Enum respaldado por string — PHP 8.1+
 * Cada case representa un mineral válido del sistema.
 */
enum MineralType: string
{
    case ESTANO = 'Estaño';
    case ZINC   = 'Zinc';
    case PLATA  = 'Plata';

    /**
     * Símbolo químico del mineral.
     * match() es como un switch pero más limpio y seguro.
     */
    public function getSymbol(): string
    {
        return match($this) {
            self::ESTANO => 'Sn',
            self::ZINC   => 'Zn',
            self::PLATA  => 'Ag',
        };
    }

    /**
     * Emoji para mostrar en la terminal.
     */
    public function getEmoji(): string
    {
        return match($this) {
            self::ESTANO => '📦',
            self::ZINC   => '🏗️',
            self::PLATA  => '🪙',
        };
    }
}
