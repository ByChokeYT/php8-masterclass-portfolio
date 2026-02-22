<?php

declare(strict_types=1);

namespace App\Classes;

class CajeroAutomatico
{
    /**
     * @param float $saldo
     */
    public function __construct(
        private float $saldo = 0.0
    ) {}

    public function consultarSaldo(): float
    {
        return $this->saldo;
    }

    public function depositar(float $monto): void
    {
        if ($monto <= 0) {
            throw new \InvalidArgumentException("El monto a depositar debe ser mayor a 0.");
        }
        $this->saldo += $monto;
    }

    public function retirar(float $monto): void
    {
        if ($monto <= 0) {
            throw new \InvalidArgumentException("El monto a retirar debe ser mayor a 0.");
        }
        
        if ($monto > $this->saldo) {
            throw new \RuntimeException("Fondos insuficientes para realizar este retiro.");
        }
        
        $this->saldo -= $monto;
    }
}
