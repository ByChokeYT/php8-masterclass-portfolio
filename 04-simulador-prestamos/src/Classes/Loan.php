<?php
declare(strict_types=1);

namespace App\Classes;

class Loan {
    public function __construct(
        public float $amount,       // Monto del préstamo
        public float $interestRate, // Tasa de interés anual (%)
        public int $termMonths      // Plazo en meses
    ) {}
}
