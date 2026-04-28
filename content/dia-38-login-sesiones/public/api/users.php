<?php
declare(strict_types=1);

require_once file_exists(__DIR__ . '/../../../vendor/autoload.php') ? __DIR__ . '/../../../vendor/autoload.php' : __DIR__ . '/../../../../vendor/autoload.php';

use App\Services\AuthService;

header('Content-Type: application/json');

$auth = new AuthService();

if (!$auth->isApiAuthorized()) {
    http_response_code(401);
    echo json_encode(['error' => 'No autorizado. Debes iniciar sesión.']);
    exit;
}

try {
    $users = $auth->getAllUsers();
    echo json_encode([
        'status' => 'success',
        'data' => $users,
        'meta' => [
            'count' => count($users),
            'timestamp' => date('Y-m-d H:i:s'),
            'api_version' => '1.0'
        ]
    ]);
} catch (\Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Error interno del servidor.']);
}
