<?php

require_once __DIR__ . '/../includes/rss_service.php';

$category = $_GET['cat'] ?? 'tech';
if (!in_array($category, ['tech', 'mining'])) {
    $category = 'tech';
}

$reader = new RSSReader();
$news = $reader->getNews($category);

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DÍA 39 // LECTOR RSS // Masterclass PHP</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <div class="container">
        <header>
            <h1>News Pulse</h1>
            <p>Mantente al día con lo último en <?= $category === 'tech' ? 'Tecnología' : 'Minería' ?></p>
        </header>

        <nav class="category-nav">
            <a href="?cat=tech" class="nav-btn tech <?= $category === 'tech' ? 'active' : '' ?>">
                🚀 Tecnología
            </a>
            <a href="?cat=mining" class="nav-btn mining <?= $category === 'mining' ? 'active' : '' ?>">
                ⛏️ Minería
            </a>
        </nav>

        <main class="news-grid">
            <?php if (empty($news)): ?>
                <div class="error-msg">
                    <p>No se pudieron cargar las noticias. Por favor, intenta de nuevo más tarde.</p>
                </div>
            <?php else: ?>
                <?php foreach ($news as $index => $item): ?>
                    <article class="news-card <?= $category === 'mining' ? 'mining-card' : '' ?>" style="animation-delay: <?= $index * 0.1 ?>s">
                        <span class="date">
                            <?= $item['source'] ?> • <?= date('d M, Y H:i', $item['timestamp']) ?>
                        </span>
                        <h2><?= htmlspecialchars($item['title']) ?></h2>
                        <p><?= htmlspecialchars($item['description']) ?></p>
                        <a href="<?= $item['link'] ?>" target="_blank" class="read-more">
                            Leer artículo completo →
                        </a>
                    </article>
                <?php endforeach; ?>
            <?php endif; ?>
        </main>
    </div>

</body>
</html>
