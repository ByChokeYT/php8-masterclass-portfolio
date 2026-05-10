<?php
declare(strict_types=1);

/**
 * FRONT CONTROLLER - Portfolio V2
 * Punto de entrada único para la aplicación.
 */

require_once __DIR__ . '/../src/Core/Performance.php';
require_once __DIR__ . '/../src/Core/ProjectScanner.php';
require_once __DIR__ . '/../src/Data/ProjectRepository.php';

use App\Core\Performance;
use App\Core\ProjectScanner;
use App\Data\ProjectRepository;

// Iniciar métricas de rendimiento
$perf = new Performance();

// Enrutador básico para acceder a los proyectos individuales
$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
if (str_starts_with($requestUri, '/content/')) {
    $targetFile = realpath(__DIR__ . '/..' . $requestUri);
    // Verificación de seguridad para evitar path traversal
    if ($targetFile && str_starts_with($targetFile, realpath(__DIR__ . '/../content/')) && is_file($targetFile)) {
        require $targetFile;
        exit;
    }
}

// Escanear proyectos para la página principal
$scanner = new ProjectScanner(__DIR__ . '/../content');
$projects = $scanner->getProjects();
$phases = ProjectRepository::getPhases();

// Definir vista principal
$viewPath = __DIR__ . '/../views/main.php';

// Obtener métricas finales
$metrics = $perf->getMetrics();

// Renderizar Layout
include __DIR__ . '/../views/layout.php';
