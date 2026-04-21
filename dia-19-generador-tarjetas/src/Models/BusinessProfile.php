<?php
declare(strict_types=1);

namespace App\Models;

/**
 * Entidad Inmutable para el Perfil Profesional
 */
readonly class BusinessProfile {
    public function __construct(
        public string $name,
        public string $role,
        public string $company,
        public string $email,
        public string $phone,
        public string $website,
        public string $photo = '',
        public string $accentColor = '#10b981'
    ) {}

    public function getInitials(): string {
        if (!empty($this->photo)) return ''; // Si hay foto, no necesitamos iniciales
        
        $words = explode(' ', trim($this->name));
        $initials = '';
        foreach (array_slice($words, 0, 2) as $w) {
            if ($w) $initials .= mb_substr($w, 0, 1);
        }
        return mb_strtoupper($initials) ?: 'ID';
    }
}
