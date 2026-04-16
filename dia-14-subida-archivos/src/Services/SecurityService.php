<?php
declare(strict_types=1);

namespace App\Services;

use App\Classes\FileRecord;
use InvalidArgumentException;
use RuntimeException;

/**
 * SecurityService - Operador de seguridad industrial para archivos.
 * Encargado de la integridad y sanitización de los datos.
 */
class SecurityService {
    private const ALLOWED_MIMES = [
        'image/jpeg',
        'image/png',
        'image/webp'
    ];
    private const MAX_SIZE = 2 * 1024 * 1024; // 2MB

    /**
     * Valida y almacena un archivo proveniente de $_FILES.
     */
    public function processUpload(array $file, string $uploadDir): FileRecord {
        if ($file['error'] !== UPLOAD_ERR_OK) {
            throw new InvalidArgumentException($this->getErrorMessage($file['error']));
        }

        // 1. Validar Tamaño
        if ($file['size'] > self::MAX_SIZE) {
            throw new InvalidArgumentException("Archivo excede el límite de 2MB permitidos.");
        }

        // 2. Validar MIME real (no confiar en $_FILES['type'])
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);

        if (!in_array($mime, self::ALLOWED_MIMES)) {
            throw new InvalidArgumentException("Tipo de archivo no permitido ($mime). Use solo JPG, PNG o WEBP.");
        }

        // 3. Sanitizar nombre y generar uno único
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $newName = bin2hex(random_bytes(16)) . '.' . $extension;
        $destination = rtrim($uploadDir, '/') . '/' . $newName;

        // 4. Mover archivo
        if (!move_uploaded_file($file['tmp_name'], $destination)) {
            throw new RuntimeException("Error fatal al sincronizar archivo con el disco.");
        }

        return new FileRecord(
            $file['name'],
            $newName,
            (int)$file['size'],
            $mime,
            date('Y-m-d H:i:s')
        );
    }

    private function getErrorMessage(int $code): string {
        return match ($code) {
            UPLOAD_ERR_INI_SIZE, UPLOAD_ERR_FORM_SIZE => "El archivo es demasiado grande para el sistema.",
            UPLOAD_ERR_PARTIAL => "La subida se interrumpió abruptamente.",
            UPLOAD_ERR_NO_FILE => "No se detectó ningún archivo para procesar.",
            default => "Error desconocido en el protocolo de carga."
        };
    }
}
