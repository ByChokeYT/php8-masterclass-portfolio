<?php
declare(strict_types=1);

namespace App\Enums;

/**
 * Enumeración que define las monedas soportadas por el sistema.
 * 
 * Incluye métodos para obtener símbolos, nombres legibles y banderas.
 * @package App\Enums
 */
enum Currency: string
{
    case USD = 'USD'; // Dólar Estadounidense
    case EUR = 'EUR'; // Euro (Unión Europea)
    case BOB = 'BOB'; // Boliviano (Bolivia)
    case ARS = 'ARS'; // Peso Argentino
    case BRL = 'BRL'; // Real Brasileño
    case CLP = 'CLP'; // Peso Chileno
    case PEN = 'PEN'; // Sol Peruano

    public function getSymbol(): string
    {
        return match($this) {
            self::USD => '$',
            self::EUR => '€',
            self::BOB => 'Bs',
            self::ARS => '$',
            self::BRL => 'R$',
            self::CLP => '$',
            self::PEN => 'S/',
        };
    }

    public function getName(): string
    {
        return match($this) {
            self::USD => 'Dólar Americano',
            self::EUR => 'Euro',
            self::BOB => 'Boliviano',
            self::ARS => 'Peso Argentino',
            self::BRL => 'Real Brasileño',
            self::CLP => 'Peso Chileno',
            self::PEN => 'Sol Peruano',
        };
    }

    public function getFlag(): string
    {
        return match($this) {
            self::USD => '🇺🇸',
            self::EUR => '🇪🇺',
            self::BOB => '🇧🇴', // Flag for Bolivia
            self::ARS => '🇦🇷',
            self::BRL => '🇧🇷',
            self::CLP => '🇨🇱',
            self::PEN => '🇵🇪',
        };
    }
}
