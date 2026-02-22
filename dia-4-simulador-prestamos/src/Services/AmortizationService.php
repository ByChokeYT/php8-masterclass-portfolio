<?php
declare(strict_types=1);

namespace App\Services;

use App\Classes\Loan;

class AmortizationService {
    /**
     * Calcula la tabla de amortización usando el sistema francés (Cuota fija).
     */
    public function calculate(Loan $loan): array {
        $balance = $loan->amount;
        $monthlyRate = ($loan->interestRate / 100) / 12;
        $schedule = [];
        
        // Fórmula de cuota fija: R = P * [ i * (1+i)^n ] / [ (1+i)^n - 1 ]
        if ($monthlyRate > 0) {
            $payment = $balance * ($monthlyRate * pow(1 + $monthlyRate, $loan->termMonths)) / (pow(1 + $monthlyRate, $loan->termMonths) - 1);
        } else {
            $payment = $balance / $loan->termMonths;
        }

        $totalInterest = 0;

        for ($i = 1; $i <= $loan->termMonths; $i++) {
            $interest = $balance * $monthlyRate;
            $principal = $payment - $interest;
            $balance -= $principal;

            // Ajuste final por redondeo
            if ($balance < 0) $balance = 0;

            $schedule[] = [
                'month' => $i,
                'payment' => $payment,
                'interest' => $interest,
                'principal' => $principal,
                'balance' => $balance
            ];

            $totalInterest += $interest;
        }

        return [
            'schedule' => $schedule,
            'summary' => [
                'total_payment' => $payment * $loan->termMonths,
                'total_interest' => $totalInterest,
                'monthly_payment' => $payment
            ]
        ];
    }
}
