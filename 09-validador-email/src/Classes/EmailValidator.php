<?php
declare(strict_types=1);

namespace App\Classes;

class EmailValidator {
    public function __construct(
        private string $email
    ) {}

    public function isValidSyntax(): bool {
        return filter_var($this->email, FILTER_VALIDATE_EMAIL) !== false;
    }

    public function getDomain(): ?string {
        if (!$this->isValidSyntax()) {
            return null;
        }
        $parts = explode('@', $this->email);
        return array_pop($parts);
    }

    public function hasMXRecords(): bool {
        $domain = $this->getDomain();
        if (!$domain) {
            return false;
        }
        // checkdnsrr devuelve true si encuentra registros MX
        return checkdnsrr($domain, 'MX');
    }

    public function analyze(): array {
        $syntax = $this->isValidSyntax();
        $domain = $this->getDomain();
        $mx = $syntax ? $this->hasMXRecords() : false;

        $status = 'invalid';
        $message = 'Formato inválido';
        $icon = '❌';

        if ($syntax) {
            if ($mx) {
                $status = 'valid';
                $message = 'Correo Válido y Dominio Activo';
                $icon = '✅';
            } else {
                $status = 'warning';
                $message = 'Formato válido pero dominio sin MX';
                $icon = '⚠️';
            }
        }

        return [
            'email' => $this->email,
            'user' => $syntax ? explode('@', $this->email)[0] : null,
            'domain' => $domain,
            'syntax_valid' => $syntax,
            'mx_records' => $mx,
            'status' => $status,
            'message' => $message,
            'icon' => $icon
        ];
    }
}
