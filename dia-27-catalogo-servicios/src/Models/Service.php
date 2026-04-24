<?php

declare(strict_types=1);

namespace App\Models;

/**
 * PHP 8.5: Readonly Service DTO
 */
readonly class Service
{
    public function __construct(
        public int $id,
        public string $title,
        public string $description,
        public float $price,
        public string $imagePath
    ) {}

    public function getFormattedPrice(): string
    {
        return '$' . number_format($this->price, 2);
    }
}
