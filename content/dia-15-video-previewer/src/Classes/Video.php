<?php
declare(strict_types=1);

namespace App\Classes;

/**
 * Video - Clase inmutable para la gestión de nodos multimedia.
 */
readonly class Video {
    public function __construct(
        public string $id,
        public string $title,
        public string $url,
        public string $thumbnail,
        public string $duration,
        public array $techSpecs
    ) {}
}
