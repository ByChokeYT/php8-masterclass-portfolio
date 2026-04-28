<?php
declare(strict_types=1);

namespace App\Data;

class ProjectRepository
{
    /**
     * Definición oficial de las fases del aprendizaje con emojis del README.
     */
    public static function getPhases(): array
    {
        return [
            1 => [
                'title' => 'Fundamentos y Sintaxis',
                'desc' => 'Lógica CLI, tipos, arrays y control.',
                'color' => '#10b981', // Emerald
                'emoji' => '🟢',
                'difficulty' => 'Inicial',
                'icon' => 'ph-terminal-window'
            ],
            2 => [
                'title' => 'UI/UX y Formularios',
                'desc' => 'Tailwind CSS, $_POST/$_GET y Frontend.',
                'color' => '#06b6d4', // Cyan
                'emoji' => '🔵',
                'difficulty' => 'Intermedio',
                'icon' => 'ph-browser'
            ],
            3 => [
                'title' => 'Persistencia y SQL',
                'desc' => 'MySQL, PDO y Gestión de Datos.',
                'color' => '#f59e0b', // Amber
                'emoji' => '🟡',
                'difficulty' => 'Desafío',
                'icon' => 'ph-database'
            ],
            4 => [
                'title' => 'Arquitectura Moderna',
                'desc' => 'APIs REST, POO avanzada y Patrones.',
                'color' => '#f43f5e', // Rose
                'emoji' => '🔴',
                'difficulty' => 'Avanzado',
                'icon' => 'ph-tree-structure'
            ],
            5 => [
                'title' => 'Ecosistema Real-World',
                'desc' => 'Security, Deploy y Aplicaciones Pro.',
                'color' => '#8b5cf6', // Violet
                'emoji' => '🟣',
                'difficulty' => 'Experto',
                'icon' => 'ph-cloud-check'
            ]
        ];
    }

    /**
     * Metadatos específicos para cada reto.
     */
    public static function getMetadata(): array
    {
        return [
            1  => ['desc' => 'Lógica pura de procesamiento de minerales con tipos estrictos.', 'tags' => ['Math', 'Strict_Types'], 'icon' => 'devicon-php-plain'],
            2  => ['desc' => 'Cálculo de índices biométricos usando DTOs y validación.', 'tags' => ['DTO', 'Validation'], 'icon' => 'devicon-php-plain'],
            3  => ['desc' => 'Gestión de flujos financieros con persistencia en memoria.', 'tags' => ['Memory_Storage'], 'icon' => 'devicon-javascript-plain'],
            4  => ['desc' => 'Simulación de préstamos con lógica de amortización compleja.', 'tags' => ['Finance_Logic'], 'icon' => 'devicon-react-original'],
            5  => ['desc' => 'Segunda iteración de IMC con enfoque en interfaces.', 'tags' => ['Interfaces'], 'icon' => 'devicon-tailwindcss-plain'],
            21 => ['desc' => 'Capa de abstracción de datos usando el patrón Singleton y PDO.', 'tags' => ['PDO', 'Singleton'], 'icon' => 'devicon-mysql-plain'],
            22 => ['desc' => 'Sistema completo de gestión de invitados con SQLite.', 'tags' => ['CRUD', 'SQLite'], 'icon' => 'devicon-sqlite-plain'],
            23 => ['desc' => 'Inventariado técnico con filtrado avanzado en base de datos.', 'tags' => ['SQL_Expert'], 'icon' => 'devicon-mysql-plain'],
            24 => ['desc' => 'Seguridad perimetral: registro con hashing industrial.', 'tags' => ['Security', 'Hashing'], 'icon' => 'devicon-php-plain'],
            31 => ['desc' => 'Integración de librerías externas mediante Composer y PSR-4.', 'tags' => ['Composer', 'PSR-4'], 'icon' => 'devicon-composer-line'],
            34 => ['desc' => 'Generación de reportes PDF dinámicos para entornos corporativos.', 'tags' => ['PDF_Engine'], 'icon' => 'devicon-php-plain'],
            38 => ['desc' => 'Arquitectura de autenticación con sesiones seguras y RBAC.', 'tags' => ['Auth', 'Sessions'], 'icon' => 'devicon-php-plain'],
            39 => ['desc' => 'Parsing de flujos RSS externos con manejo de errores robusto.', 'tags' => ['XML', 'RSS'], 'icon' => 'devicon-php-plain']
        ];
    }
}
