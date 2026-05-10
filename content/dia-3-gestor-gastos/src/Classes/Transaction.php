<?php
declare(strict_types=1);

namespace App\Classes;

/**
 * Clase Entidad: Transaction (Transacción)
 * 
 * Representa una única operación financiera en el sistema.
 * Utiliza "Constructor Property Promotion" (PHP 8) para declarar
 * y asignar las propiedades directamente en los parámetros del constructor.
 */
class Transaction {
    public function __construct(
        public string $id,          // Identificador único (UUID simulado)
        public string $description, // Motivo del gasto/ingreso
        public float $amount,       // Monto de la transacción
        public string $category,    // Categoría (ej. Comida, Sueldo)
        public string $type,        // 'income' (Ingreso) o 'expense' (Gasto)
        public string $date         // Fecha de registro
    ) {}

    /**
     * Factory Method (Patrón de Diseño)
     * 
     * Método estático para instanciar una Transacción sin tener que
     * pasar manualmente el ID y la Fecha cada vez que creamos una.
     * 
     * @return self Retorna una nueva instancia de Transaction
     */
    public static function create(string $description, float $amount, string $category, string $type): self {
        return new self(
            uniqid(),
            $description,
            $amount,
            $category,
            $type,
            date('Y-m-d H:i:s')
        );
    }
}
