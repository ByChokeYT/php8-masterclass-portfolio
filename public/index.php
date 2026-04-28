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

// Escanear proyectos
$scanner = new ProjectScanner(__DIR__ . '/../content');
$projects = $scanner->getProjects();
$phases = ProjectRepository::getPhases();

// Definir vista principal
$viewPath = __DIR__ . '/../views/main.php';

// Obtener métricas finales
$metrics = $perf->getMetrics();

// Renderizar Layout
include __DIR__ . '/../views/layout.php';
