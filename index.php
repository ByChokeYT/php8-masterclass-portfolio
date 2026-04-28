<?php
/**
 * REDIRECCIÓN AL FRONT CONTROLLER
 * Este archivo asegura que cualquier petición a la raíz sea enviada a /public
 */
header("Location: /public/index.php");
exit;
