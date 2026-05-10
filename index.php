<?php
/**
 * FRONT CONTROLLER FALLBACK
 * Si no se usa un servidor con .htaccess, el tráfico cae aquí e inyectamos public/index.php
 * Esto mantiene la URL limpia (sin /public/ visible al usuario).
 */
require __DIR__ . '/public/index.php';
