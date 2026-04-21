<?php
declare(strict_types=1);

require_once __DIR__ . '/src/Models/BusinessProfile.php';
require_once __DIR__ . '/src/Services/CardRenderer.php';

use App\Models\BusinessProfile;
use App\Services\CardRenderer;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 1. Procesar la foto si existe
    $photoBase64 = $_POST['current_photo'] ?? ''; // Mantener foto anterior si no se sube una nueva
    
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        $type = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
        $data = file_get_contents($_FILES['photo']['tmp_name']);
        $photoBase64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
    }

    // 2. Crear el Modelo
    $profile = new BusinessProfile(
        name:    $_POST['name']    ?: 'NOMBRE APELLIDO',
        role:    $_POST['role']    ?: 'CARGO / POSICIÓN',
        company: $_POST['company'] ?: 'EMPRESA TECNOLÓGICA',
        email:   $_POST['email']   ?: 'correo@ejemplo.com',
        phone:   $_POST['phone']   ?: '+00 000 000 000',
        website: $_POST['website'] ?: 'www.tusitio.com',
        photo:   $photoBase64,
        accentColor: $_POST['color'] ?: '#10b981'
    );

    // 3. Renderizar
    $renderer = new CardRenderer();
    echo $renderer->render($profile);
}
