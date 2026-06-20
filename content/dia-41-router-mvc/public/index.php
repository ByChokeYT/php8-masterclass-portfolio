<?php
declare(strict_types=1);

require_once __DIR__ . '/../src/Router.php';

use App\Router;

$router = new Router();

$router->add('/', function() {
    renderPage("Inicio", "¡Bienvenido a la página principal del enrutador MVC!", "Esta ruta se resuelve en '/' dinámicamente.");
});

$router->add('/nosotros', function() {
    renderPage("Nosotros", "Acerca de ByChoke Studios", "Esta ruta se resuelve en '/nosotros'.");
});

$router->add('/servicios', function() {
    renderPage("Servicios", "Nuestros Servicios Backend", "Esta ruta se resuelve en '/servicios'.");
});

function renderPage(string $title, string $header, string $body): void
{
    $currentUri = $_SERVER['REQUEST_URI'];
    ?>
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <title><?= $title ?> // Router MVC</title>
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body class="bg-slate-100 p-6 font-sans">
        <div class="max-w-md mx-auto bg-white rounded-xl shadow-md overflow-hidden md:max-w-2xl border border-slate-200">
            <div class="p-8">
                <div class="uppercase tracking-wide text-xs text-indigo-500 font-semibold mb-2">Simulador de Enrutador MVC</div>
                <h1 class="block mt-1 text-2xl leading-tight font-bold text-black"><?= $header ?></h1>
                <p class="mt-4 text-slate-500"><?= $body ?></p>
                
                <div class="mt-6 border-t border-slate-100 pt-4">
                    <span class="text-xs font-mono text-slate-400">URI Actual: <?= htmlspecialchars($currentUri) ?></span>
                </div>

                <div class="mt-6 flex gap-3">
                    <a href="?route=/" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold rounded-lg transition-colors">Inicio (/)</a>
                    <a href="?route=/nosotros" class="px-4 py-2 bg-slate-200 hover:bg-slate-300 text-slate-700 text-xs font-bold rounded-lg transition-colors">Nosotros (/nosotros)</a>
                    <a href="?route=/servicios" class="px-4 py-2 bg-slate-200 hover:bg-slate-300 text-slate-700 text-xs font-bold rounded-lg transition-colors">Servicios (/servicios)</a>
                </div>
            </div>
        </div>
    </body>
    </html>
    <?php
}

// Para facilidad de simulación dentro de un iframe sin reescritura de Apache en el puerto local,
// permitimos pasar la ruta simulada vía query param `?route=/nosotros`
$routeToDispatch = $_GET['route'] ?? $_SERVER['REQUEST_URI'];
$router->dispatch($routeToDispatch);
