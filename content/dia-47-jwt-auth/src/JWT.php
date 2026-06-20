<?php
declare(strict_types=1);

namespace App;

class JWT
{
    private string $secret;

    public function __construct(string $secret)
    {
        $this->secret = $secret;
    }

    public function generate(array $payload): string
    {
        $header = json_encode(['alg' => 'HS256', 'typ' => 'JWT']);
        
        $base64UrlHeader = $this->base64UrlEncode($header);
        $base64UrlPayload = $this->base64UrlEncode(json_encode($payload));
        
        $signature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, $this->secret, true);
        $base64UrlSignature = $this->base64UrlEncode($signature);
        
        return $base64UrlHeader . "." . $base64UrlPayload . "." . $base64UrlSignature;
    }

    public function validate(string $token): ?array
    {
        $parts = explode('.', $token);
        if (count($parts) !== 3) {
            return null;
        }

        list($header, $payload, $signature) = $parts;

        // Verificar firma
        $expectedSignature = hash_hmac('sha256', $header . "." . $payload, $this->secret, true);
        if (!hash_equals($this->base64UrlEncode($expectedSignature), $signature)) {
            return null; // Firma inválida
        }

        $decodedPayload = json_decode($this->base64UrlDecode($payload), true);

        // Verificar expiración si está definida
        if (isset($decodedPayload['exp']) && $decodedPayload['exp'] < time()) {
            return null; // Token expirado
        }

        return $decodedPayload;
    }

    private function base64UrlEncode(string $data): string
    {
        return str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($data));
    }

    private function base64UrlDecode(string $data): string
    {
        $remainder = strlen($data) % 4;
        if ($remainder) {
            $data .= str_repeat('=', 4 - $remainder);
        }
        return base64_decode(str_replace(['-', '_'], ['+', '/'], $data));
    }
}
