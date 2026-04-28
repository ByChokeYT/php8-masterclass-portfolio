<?php
declare(strict_types=1);

namespace App\Classes;

use InvalidArgumentException;

readonly class RSVP {
    /**
     * @param string $name
     * @param string $email
     * @param int $guests
     * @param string $message
     * @param string $timestamp
     */
    public function __construct(
        public string $name,
        public string $email,
        public int $guests,
        public string $message,
        public string $timestamp
    ) {
        $this->validate();
    }

    private function validate(): void {
        if (empty(trim($this->name))) {
            throw new InvalidArgumentException("El nombre no puede estar vacío.");
        }

        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException("El correo electrónico no es válido.");
        }

        if ($this->guests < 1 || $this->guests > 10) {
            throw new InvalidArgumentException("El número de invitados debe estar entre 1 y 10.");
        }
    }

    public function toArray(): array {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'guests' => $this->guests,
            'message' => $this->message,
            'timestamp' => $this->timestamp
        ];
    }
}
