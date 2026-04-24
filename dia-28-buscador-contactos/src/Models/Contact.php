<?php

declare(strict_types=1);

namespace App\Models;

readonly class Contact
{
    public function __construct(
        public int $id,
        public string $name,
        public string $email,
        public ?string $phone,
        public ?string $company,
        public ?string $role
    ) {}
}
