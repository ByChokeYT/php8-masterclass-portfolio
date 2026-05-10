<?php
/**
 * router.php — Router para PHP Built-in Server
 * Maneja assets estáticos y enruta el resto al front controller.
 */

$uri = $_SERVER['REQUEST_URI'];
$parsed = parse_url($uri, PHP_URL_PATH);

// Servir archivos estáticos si existen en /public/
$publicFile = __DIR__ . '/public' . $parsed;
if (is_file($publicFile)) {
    // Detectar MIME type
    $ext = strtolower(pathinfo($publicFile, PATHINFO_EXTENSION));
    $mimes = [
        'png' => 'image/png', 'jpg' => 'image/jpeg', 'jpeg' => 'image/jpeg',
        'gif' => 'image/gif', 'svg' => 'image/svg+xml', 'ico' => 'image/x-icon',
        'css' => 'text/css', 'js' => 'application/javascript',
        'woff' => 'font/woff', 'woff2' => 'font/woff2', 'ttf' => 'font/ttf',
    ];
    if (isset($mimes[$ext])) header('Content-Type: ' . $mimes[$ext]);
    readfile($publicFile);
    return true;
}


// Todo lo demás va al front controller
require __DIR__ . '/public/index.php';
