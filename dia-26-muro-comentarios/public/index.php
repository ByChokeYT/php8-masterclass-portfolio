<?php

declare(strict_types=1);

session_start();

spl_autoload_register(function ($class) {
    if (str_starts_with($class, 'App\\')) {
        $file = __DIR__ . '/../src/' . str_replace(['App\\', '\\'], ['', '/'], $class) . '.php';
        if (file_exists($file)) require $file;
    }
});

use App\Config\DatabaseConfig;
use App\DatabaseHost;
use App\CommentManager;

$config = new DatabaseConfig(driver: 'sqlite', database: 'muro_deseos.sqlite');
$manager = new CommentManager(new DatabaseHost($config));

$notification = null;
if (isset($_SESSION['notification'])) {
    $notification = $_SESSION['notification'];
    unset($_SESSION['notification']);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $author = $_POST['author'] ?? '';
        $content = $_POST['content'] ?? '';

        if ($manager->addComment($author, $content)) {
            $_SESSION['notification'] = ['type' => 'success', 'msg' => '¡Tu mensaje ha sido publicado en el muro!'];
        }
    } catch (Exception $e) {
        $_SESSION['notification'] = ['type' => 'error', 'msg' => $e->getMessage()];
    }

    header('Location: index.php');
    exit;
}

$comments = $manager->getComments();

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>DÍA 26 // MURO DE DESEOS // Masterclass PHP</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;700;900&family=JetBrains+Mono:wght@400;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <link rel="stylesheet" href="assets/css/style.css?v=<?= time() ?>">
</head>
<body>
    <div class="industrial-grid"></div>

    <div class="container">
        <header class="header">
            <div>
                <span class="tech-label">Fase 3: Muro Público de Persistencia</span>
                <h1>Tablero de Deseos</h1>
            </div>
            <a href="http://localhost:8000" class="tech-label" style="text-decoration: none; opacity: 0.6;">
                <i class="ph ph-arrow-left"></i> Volver al Portal
            </a>
        </header>

        <?php if ($notification): ?>
            <div class="alert alert-<?= $notification['type'] ?>">
                <?= htmlspecialchars($notification['msg']) ?>
            </div>
        <?php endif; ?>

        <section class="panel">
            <form method="POST">
                <div class="form-group">
                    <label>Tu Nombre / Alias</label>
                    <input type="text" name="author" placeholder="Ej. El Minero Anonimo" required>
                </div>
                <div class="form-group">
                    <label>Tu Mensaje o Deseo</label>
                    <textarea name="content" placeholder="Escribe algo inspirador..." required maxlength="500"></textarea>
                </div>
                <button type="submit" class="btn-submit">Publicar en el Muro</button>
            </form>
        </section>

        <main class="wall-grid">
            <?php if (empty($comments)): ?>
                <div style="grid-column: 1 / -1; text-align: center; padding: 4rem; opacity: 0.3;">
                    <i class="ph ph-chat-centered-dots" style="font-size: 3rem; margin-bottom: 1rem; display: block;"></i>
                    El muro está vacío. Sé el primero en dejar un mensaje.
                </div>
            <?php endif; ?>

            <?php foreach ($comments as $c): ?>
                <article class="comment-card">
                    <div class="comment-header">
                        <span class="author-name"><?= htmlspecialchars($c['author']) ?></span>
                        <span class="comment-date"><?= $c['local_date'] ?></span>
                    </div>
                    <p class="comment-content">
                        <?= nl2br(htmlspecialchars($c['content'])) ?>
                    </p>
                </article>
            <?php endforeach; ?>
        </main>
    </div>
</body>
</html>
