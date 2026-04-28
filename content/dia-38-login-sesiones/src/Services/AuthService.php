<?php
declare(strict_types=1);

namespace App\Services;

use PDO;

class AuthService {
    private PDO $db;

    public function __construct() {
        $dbPath = __DIR__ . '/../../database/auth.db';
        $this->db = new PDO("sqlite:$dbPath");
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->init();
    }

    private function init(): void {
        $this->db->exec("CREATE TABLE IF NOT EXISTS users (
            id INTEGER PRIMARY KEY AUTOINCREMENT, 
            username TEXT UNIQUE NOT NULL, 
            password TEXT NOT NULL,
            full_name TEXT,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        );");

        // Crear usuario por defecto si no existe (admin / php85)
        $stmt = $this->db->query("SELECT COUNT(*) FROM users");
        if ($stmt->fetchColumn() == 0) {
            $hashed = password_hash('php85', PASSWORD_DEFAULT);
            $stmt = $this->db->prepare("INSERT INTO users (username, password, full_name) VALUES (?, ?, ?)");
            $stmt->execute(['admin', $hashed, 'ByChoke Master']);
        }
    }

    public function login(string $username, string $password): bool {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            // Iniciar Sesión
            if (session_status() === PHP_SESSION_NONE) session_start();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['full_name'] = $user['full_name'];
            $_SESSION['last_login'] = date('H:i:s');
            
            // Opcional: Cookie de "Recordar" (Persistencia 30 días)
            setcookie('last_user', $username, time() + (86400 * 30), "/");
            
            return true;
        }
        return false;
    }

    public function checkAuth(): void {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php");
            exit;
        }
    }

    public function isApiAuthorized(): bool {
        if (session_status() === PHP_SESSION_NONE) session_start();
        return isset($_SESSION['user_id']);
    }

    public function getAllUsers(): array {
        $stmt = $this->db->query("SELECT id, username, full_name, created_at FROM users ORDER BY id DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function logout(): void {
        if (session_status() === PHP_SESSION_NONE) session_start();
        session_unset();
        session_destroy();
        header("Location: index.php");
        exit;
    }
}
