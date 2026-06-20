<?php
declare(strict_types=1);

namespace App\Services;

class Mailer
{
    private string $host;
    private int $port;
    private string $username;

    public function __construct(string $host, int $port, string $username)
    {
        $this->host = $host;
        $this->port = $port;
        $this->username = $username;
    }

    public function send(string $to, string $subject, string $body): bool
    {
        // Validación básica
        if (!filter_var($to, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException("Email de destino inválido.");
        }

        echo "[SMTP] Conectando a {$this->host}:{$this->port}...\n";
        usleep(200000); // Simular delay de red
        echo "[SMTP] Autenticación de usuario ({$this->username}) exitosa.\n";
        usleep(200000);
        echo "[SMTP] Enviando cuerpo HTML (Multipart)...\n";
        usleep(300000);
        
        return true;
    }
}
