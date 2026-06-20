<?php
declare(strict_types=1);

require_once __DIR__ . '/../src/TemplateEngine.php';

use App\TemplateEngine;

$engine = new TemplateEngine(__DIR__ . '/../templates');

$data = [
    'name' => 'José Luis Choquevillca',
    'role' => 'Lead Backend Engineer / Instructor PHP',
    'initials' => 'JC',
    'email' => 'choque151.jlc@gmail.com',
    'city' => 'Oruro, Bolivia'
];

$renderedHtml = $engine->render('profile.html', $data);

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Template Engine Demo</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100 p-6 font-sans">
    <div class="max-w-xl mx-auto">
        <div class="text-center mb-6">
            <h1 class="text-xl font-bold text-slate-800">Motor de Plantillas Simple</h1>
            <p class="text-xs text-slate-500">Renderizando plantilla HTML con sintaxis <code>{{ variable }}</code></p>
        </div>
        
        <!-- Rendered output -->
        <?= $renderedHtml ?>
    </div>
</body>
</html>
