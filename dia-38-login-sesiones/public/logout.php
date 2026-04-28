<?php
declare(strict_types=1);

require_once file_exists(__DIR__ . '/../vendor/autoload.php') ? __DIR__ . '/../vendor/autoload.php' : __DIR__ . '/../../vendor/autoload.php';

use App\Services\AuthService;

$auth = new AuthService();
$auth->logout();
