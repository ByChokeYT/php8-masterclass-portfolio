<?php
declare(strict_types=1);
namespace App\Enums;

enum MineralType: string {
    case ESTANO = 'Estaño';
    case ZINC   = 'Zinc';
    case PLATA  = 'Plata';
    case ORO    = 'Oro'; // [NUEVO]

    public function getSymbol(): string {
        return match($this) {
            self::ESTANO => 'Sn',
            self::ZINC   => 'Zn',
            self::PLATA  => 'Ag',
            self::ORO    => 'Au', // [NUEVO]
        };
    }

    public function getEmoji(): string {
        return match($this) {
            self::ESTANO => '📦',
            self::ZINC   => '🏗️',
            self::PLATA  => '🪙',
            self::ORO    => '🥇', // [NUEVO]
        };
    }
}
