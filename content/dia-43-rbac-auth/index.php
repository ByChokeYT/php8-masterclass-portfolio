<?php
declare(strict_types=1);

$dayNumber = 43;
$dayLabel = 'DÍA 43';
$dayTitle = 'Control de Acceso basado en Roles (RBAC)';
$dayDescription = 'Implementación de un sistema de autorización granular (Role-Based Access Control) para proteger vistas y acciones según el rol del usuario (Admin o Cliente).';

$learningObjectives = [
    [
        'title' => 'Autenticación vs Autorización',
        'desc' => 'Diferenciar entre quién es el usuario (Auth) y qué tiene permitido hacer (Roles).'
    ],
    [
        'title' => 'Roles & Permisos',
        'desc' => 'Mapear roles (Admin, Manager, User) a un conjunto de permisos específicos en una matriz.'
    ],
    [
        'title' => 'Interceptores / Middleware',
        'desc' => 'Diseñar middlewares de autorización que verifiquen los permisos del usuario antes de ejecutar la lógica.'
    ]
];

$professorNote = '
    <div class="space-y-4">
        <p>¡Hola! Un error clásico de seguridad consiste en ocultar botones en el frontend (como ocultar el botón "Eliminar" a usuarios comunes) sin proteger la acción correspondiente en el backend. ¡Nunca confíes únicamente en la interfaz visual!</p>
        <div class="bg-blue-100/50 p-4 rounded-lg border-l-4 border-blue-400 my-4">
            <strong class="text-blue-900 block mb-1">Dato de Ciberseguridad:</strong>
            <p>Siempre implementa controles de autorización a nivel de servidor (backend) en cada endpoint o petición POST. Si un usuario malintencionado adivina la URL de la acción de eliminar y realiza un POST manual, el servidor debe rechazar la solicitud si su rol no lo autoriza.</p>
        </div>
    </div>
';

$files = [
    'public/index.php' => ['path' => 'public/index.php', 'icon' => 'ph-browser'],
    'src/RBAC.php'      => ['path' => 'src/RBAC.php', 'icon' => 'ph-shield-check'],
];

$executionMode = 'web';
$webAppUrl = '/content/dia-43-rbac-auth/public/index.php';

require_once __DIR__ . '/../../templates/pedagogical_view.php';
