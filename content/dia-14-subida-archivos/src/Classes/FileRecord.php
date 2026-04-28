<?php
declare(strict_types=1);

namespace App\Classes;

/**
 * FileRecord - Clase inmutable para el registro de archivos subidos.
 * Representa los metadatos de un archivo validado y almacenado.
 */
readonly class FileRecord {
    public function __construct(
        public string $originalName,
        public string $savedName,
        public int $size,
        public string $type,
        public string $timestamp
    ) {}

    /**
     * Formatea el tamaño del archivo a una unidad legible (KB, MB).
     */
    public function getFormattedSize(): string {
        if ($this->size < 1024) return $this->size . ' B';
        if ($this->size < 1048576) return round($this->size / 1024, 2) . ' KB';
        return round($this->size / 1048576, 2) . ' MB';
    }

    /**
     * Convierte el objeto a un array para serialización JSON.
     */
    public function toArray(): array {
        return [
            'originalName' => $this->originalName,
            'savedName' => $this->savedName,
            'size' => $this->size,
            'type' => $this->type,
            'timestamp' => $this->timestamp
        ];
    }
}
