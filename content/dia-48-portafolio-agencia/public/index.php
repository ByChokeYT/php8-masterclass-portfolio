<?php
declare(strict_types=1);

require_once __DIR__ . '/../src/ProjectManager.php';

use App\ProjectManager;

$pm = new ProjectManager();

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $category = trim($_POST['category'] ?? '');
    $desc = trim($_POST['description'] ?? '');

    if ($title !== '' && $category !== '' && $desc !== '') {
        $pm->addProject($title, $category, $desc);
        $message = "¡Proyecto '{$title}' agregado con éxito!";
    } else {
        $message = "Error: Rellene todos los campos.";
    }
}

$projects = $pm->getProjects();

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>CMS Portafolio Agencia</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100 p-6 font-sans">
    <div class="max-w-5xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-6">
        
        <!-- Formulario (Izquierda) -->
        <div class="md:col-span-1 bg-white p-6 rounded-xl shadow-md border border-slate-200 h-fit">
            <h2 class="text-lg font-bold text-slate-800 mb-4">Agregar Proyecto</h2>
            
            <?php if ($message): ?>
                <div class="mb-4 p-3 rounded text-xs <?= str_contains($message, 'Error') ? 'bg-red-100 text-red-700' : 'bg-emerald-100 text-emerald-700' ?>">
                    <?= htmlspecialchars($message) ?>
                </div>
            <?php endif; ?>

            <form method="POST">
                <div class="mb-4">
                    <label class="block text-slate-700 text-xs font-bold mb-2">Título del Proyecto</label>
                    <input type="text" name="title" required class="shadow border rounded w-full py-2 px-3 text-slate-700 text-xs focus:outline-none">
                </div>
                <div class="mb-4">
                    <label class="block text-slate-700 text-xs font-bold mb-2">Categoría</label>
                    <input type="text" name="category" required class="shadow border rounded w-full py-2 px-3 text-slate-700 text-xs focus:outline-none">
                </div>
                <div class="mb-4">
                    <label class="block text-slate-700 text-xs font-bold mb-2">Descripción</label>
                    <textarea name="description" required class="shadow border rounded w-full py-2 px-3 text-slate-700 text-xs focus:outline-none h-20 resize-none"></textarea>
                </div>
                <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 rounded text-xs transition-colors">
                    Guardar Proyecto
                </button>
            </form>
        </div>

        <!-- Grid de Proyectos (Derecha) -->
        <div class="md:col-span-2 bg-white p-6 rounded-xl shadow-md border border-slate-200">
            <h2 class="text-lg font-bold text-slate-800 mb-4">Proyectos Publicados</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <?php foreach ($projects as $project): ?>
                    <div class="p-4 bg-slate-50 border border-slate-200 rounded-lg flex flex-col justify-between">
                        <div>
                            <span class="px-2 py-0.5 text-[9px] font-black uppercase bg-indigo-100 text-indigo-700 rounded-full">
                                <?= htmlspecialchars($project['category']) ?>
                            </span>
                            <h3 class="font-bold text-slate-800 text-sm mt-2"><?= htmlspecialchars($project['title']) ?></h3>
                            <p class="text-xs text-slate-500 mt-2 leading-relaxed"><?= htmlspecialchars($project['description']) ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

    </div>
</body>
</html>
