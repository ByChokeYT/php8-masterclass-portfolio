<?php

declare(strict_types=1);

namespace App;

use PDO;
use Exception;
use PDOException;

class AuthManager
{
    private PDO $db;

    public function __construct(DatabaseHost $dbHost)
    {
        $this->db = $dbHost->connect();
        $this->initialize();
    }

    private function initialize(): void
    {
        $sql = file_get_contents(__DIR__ . '/../data/schema.sql');
        if ($sql !== false) {
            $this->db->exec($sql);
        }
    }

    /**
     * Registra un nuevo usuario hasheando su contraseña mediante Bcrypt.
     */
    public function register(string $email, string $password): bool
    {
        $email = filter_var(trim($email), FILTER_SANITIZE_EMAIL);
        
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Formato de correo electrónico inválido.");
        }

        if (strlen($password) < 8) {
            throw new Exception("La contraseña debe tener al menos 8 caracteres.");
        }

        // HASH de contraseña - El núcleo de la seguridad del Día 24
        $hash = password_hash($password, PASSWORD_DEFAULT);

        try {
            $stmt = $this->db->prepare("INSERT INTO users (email, password_hash) VALUES (:email, :hash)");
            return $stmt->execute([
                ':email' => $email,
                ':hash' => $hash
            ]);
        } catch (PDOException $e) {
            // El código 23000 es violación de integridad (UNIQUE en este caso)
            if ($e->getCode() === '23000') {
                throw new Exception("El correo electrónico ya está registrado en el sistema.");
            }
            throw new Exception("Error al procesar el registro.");
        }
    }

    /**
     * Autentica a un usuario y verifica si el password coincide con el hash en BD.
     */
    public function login(string $email, string $password): array|false
    {
        $stmt = $this->db->prepare("SELECT id, email, password_hash FROM users WHERE email = :email");
        $stmt->execute([':email' => $email]);
        
        $user = $stmt->fetch();

        // Si el usuario existe y el password_verify confirma que la contraseña es correcta
        if ($user && password_verify($password, $user['password_hash'])) {
            // Nunca devolver el hash en el array final por seguridad
            unset($user['password_hash']);
            return $user;
        }

        // Devolvemos false usando el mismo mensaje para no dar indicios si el que falla es el correo o la password.
        return false;
    }
}
