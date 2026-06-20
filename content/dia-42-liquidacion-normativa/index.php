<?php
declare(strict_types=1);

$dayNumber = 42;
$dayLabel = 'DÍA 42';
$dayTitle = 'Liquidación Laboral Normativa';
$dayDescription = 'Implementación de reglas de negocio complejas sobre deducciones, AFP y aportes de ley en PHP, persistiendo la información en una base de datos local SQLite.';

$learningObjectives = [
    [
        'title' => 'Lógica de Aportes de Ley',
        'desc' => 'Calcular de forma exacta descuentos de jubilación, aportes nacionales solidarios y cargas sociales.'
    ],
    [
        'title' => 'Persistencia con SQLite',
        'desc' => 'Almacenar y consultar históricos de liquidaciones mensuales usando una base de datos local ligera.'
    ],
    [
        'title' => 'Diseño de Base de Datos',
        'desc' => 'Creación de esquemas y tablas con llaves primarias, tipos correctos y marcas de tiempo.'
    ]
];

$professorNote = '
    <div class="space-y-4">
        <p>¡Hola! Las calculadoras de nómina y liquidación son proyectos Backend de alta demanda. Aquí no hay margen de error: un centavo de diferencia puede causar problemas legales.</p>
        <div class="bg-blue-100/50 p-4 rounded-lg border-l-4 border-blue-400 my-4">
            <strong class="text-blue-900 block mb-1">Dato de Precisión Numérica:</strong>
            <p>Nunca uses el tipo <code>float</code> para representar dinero o valores monetarios en bases de datos o cálculos críticos, ya que causan errores de redondeo de punto flotante. En su lugar, usa enteros (representando centavos) o campos de tipo <code>DECIMAL</code> en MySQL/PostgreSQL. En PHP, usa funciones matemáticas de alta precisión como <code>bcmath</code> si es necesario.</p>
        </div>
    </div>
';

$files = [
    'public/index.php' => ['path' => 'public/index.php', 'icon' => 'ph-browser'],
    'src/Database.php'  => ['path' => 'src/Database.php', 'icon' => 'ph-database'],
];

$executionMode = 'web';
$webAppUrl = '/content/dia-42-liquidacion-normativa/public/index.php';

require_once __DIR__ . '/../../templates/pedagogical_view.php';
