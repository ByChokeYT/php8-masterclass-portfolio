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
            5  => ['desc' => 'Calculadora de IMC Pro conectada a interfaz y manejo de excepciones.', 'tags' => ['Exceptions', 'Web'], 'icon' => 'devicon-php-plain'],
            6  => ['desc' => 'Construcción de un reloj atómico manejando Zonas Horarias y el objeto DateTime.', 'tags' => ['DateTime', 'Timezones'], 'icon' => 'devicon-javascript-plain'],
            7  => ['desc' => 'Procesamiento de strings y algoritmos de frecuencia de palabras (Analizador SEO).', 'tags' => ['mb_string', 'Arrays'], 'icon' => 'devicon-php-plain'],
            8  => ['desc' => 'Game Loop persistente basado en Sesiones para adivinar números.', 'tags' => ['Sessions', 'PRG'], 'icon' => 'devicon-php-plain'],
            9  => ['desc' => 'Validación segura de emails y resolución activa de registros DNS (MX).', 'tags' => ['DNS', 'Security'], 'icon' => 'devicon-php-plain'],
            10 => ['desc' => 'Simulador bancario transaccional integrando clases, sesiones y excepciones.', 'tags' => ['Transactions', 'OOP'], 'icon' => 'devicon-mysql-plain'],
            
            // Fase 2
            11 => ['desc' => 'Landing Page responsiva de agencia con renderizado dinámico de servicios.', 'tags' => ['Tailwind', 'HTML5'], 'icon' => 'devicon-html5-plain'],
            12 => ['desc' => 'Formulario de cotización dinámico con planes adaptables y cálculo en vivo.', 'tags' => ['$_POST', 'Validation'], 'icon' => 'devicon-php-plain'],
            13 => ['desc' => 'Recepción RSVP con validación de invitados, sanitización y confirmaciones.', 'tags' => ['Form', 'Sanitization'], 'icon' => 'devicon-php-plain'],
            14 => ['desc' => 'Subida segura de archivos validando MIME types, tamaño y extensiones.', 'tags' => ['Security', 'Upload'], 'icon' => 'devicon-php-plain'],
            15 => ['desc' => 'Previsualizador interactivo de tarjetas de video según ID de la URL.', 'tags' => ['$_GET', 'Media'], 'icon' => 'devicon-html5-plain'],
            16 => ['desc' => 'Inicio de sesión básico gestionado en memoria con sesiones PHP.', 'tags' => ['$_SESSION', 'Auth'], 'icon' => 'devicon-php-plain'],
            17 => ['desc' => 'Calculadora de liquidaciones laborales en una interfaz limpia con Tailwind.', 'tags' => ['Tailwind', 'Math'], 'icon' => 'devicon-php-plain'],
            18 => ['desc' => 'Parser simple de Markdown para convertir notas técnicas a HTML.', 'tags' => ['Parser', 'Markdown'], 'icon' => 'devicon-php-plain'],
            19 => ['desc' => 'Generador dinámico de tarjetas de presentación estilizadas con CSS.', 'tags' => ['CSS3', 'Dynamic'], 'icon' => 'devicon-css3-plain'],
            20 => ['desc' => 'Encuesta de votación visual con persistencia local en archivo de texto.', 'tags' => ['Txt_DB', 'AOS'], 'icon' => 'devicon-javascript-plain'],
            
            // Fase 3
            21 => ['desc' => 'Capa de abstracción de datos usando el patrón Singleton y PDO.', 'tags' => ['PDO', 'Singleton'], 'icon' => 'devicon-mysql-plain'],
            22 => ['desc' => 'Sistema completo de gestión de invitados con SQLite.', 'tags' => ['CRUD', 'SQLite'], 'icon' => 'devicon-sqlite-plain'],
            23 => ['desc' => 'Inventariado técnico con filtrado avanzado en base de datos.', 'tags' => ['SQL_Expert'], 'icon' => 'devicon-mysql-plain'],
            24 => ['desc' => 'Seguridad perimetral: registro con hashing industrial.', 'tags' => ['Security', 'Hashing'], 'icon' => 'devicon-php-plain'],
            25 => ['desc' => 'Gestor de enlaces QR con almacenamiento de metadatos en SQLite.', 'tags' => ['SQLite', 'Metadata'], 'icon' => 'devicon-sqlite-plain'],
            26 => ['desc' => 'Muro público de comentarios con prevención de inyección SQL e XSS.', 'tags' => ['MySQL', 'Security'], 'icon' => 'devicon-mysql-plain'],
            27 => ['desc' => 'Catálogo dinámico de servicios alimentado directamente desde la BD.', 'tags' => ['SQL', 'Dynamic'], 'icon' => 'devicon-mysql-plain'],
            28 => ['desc' => 'Buscador avanzado de contactos con filtros dinámicos LIKE y WHERE.', 'tags' => ['SQL', 'LIKE'], 'icon' => 'devicon-mysql-plain'],
            29 => ['desc' => 'Registro de ingresos y gastos diarios categorizados por fecha.', 'tags' => ['SQL', 'Categories'], 'icon' => 'devicon-mysql-plain'],
            30 => ['desc' => 'Dashboard administrativo con indicadores y contadores del sistema.', 'tags' => ['SQL', 'Metrics'], 'icon' => 'devicon-mysql-plain'],
            
            // Fase 4
            31 => ['desc' => 'Integración de librerías externas mediante Composer y PSR-4.', 'tags' => ['Composer', 'PSR-4'], 'icon' => 'devicon-composer-line'],
            32 => ['desc' => 'Scraper del clima en Oruro consumiendo recursos de API pública.', 'tags' => ['cURL', 'Scraping'], 'icon' => 'devicon-php-plain'],
            33 => ['desc' => 'Consumo de API de metales para cotizaciones en tiempo real.', 'tags' => ['JSON', 'API'], 'icon' => 'devicon-php-plain'],
            34 => ['desc' => 'Generación de reportes PDF dinámicos para entornos corporativos.', 'tags' => ['PDF_Engine'], 'icon' => 'devicon-composer-line'],
            35 => ['desc' => 'Exportador de datos en formato CSV para reportes contables.', 'tags' => ['fputcsv', 'Export'], 'icon' => 'devicon-php-plain'],
            36 => ['desc' => 'Envío automatizado de correos con PHPMailer y SMTP seguro.', 'tags' => ['SMTP', 'PHPMailer'], 'icon' => 'devicon-composer-line'],
            37 => ['desc' => 'Acortador de enlaces con mapeo en base de datos y redirección limpia.', 'tags' => ['Redirects', 'Slugs'], 'icon' => 'devicon-php-plain'],
            38 => ['desc' => 'Arquitectura de autenticación con sesiones seguras y RBAC.', 'tags' => ['Auth', 'Sessions'], 'icon' => 'devicon-php-plain'],
            39 => ['desc' => 'Parsing de flujos RSS externos con manejo de errores robusto.', 'tags' => ['XML', 'RSS'], 'icon' => 'devicon-php-plain'],
            40 => ['desc' => 'Script automatizado para generar copias de seguridad de la base de datos.', 'tags' => ['Backup', 'System'], 'icon' => 'devicon-php-plain'],
            
            // Fase 5
            41 => ['desc' => 'Enrutador limpio de peticiones web para arquitectura MVC.', 'tags' => ['MVC', 'Router'], 'icon' => 'devicon-php-plain'],
            42 => ['desc' => 'Sistema de liquidación laboral aplicando normativa vigente y persistencia SQL.', 'tags' => ['Business_Logic', 'SQLite'], 'icon' => 'devicon-sqlite-plain'],
            43 => ['desc' => 'Control de acceso basado en roles para protección de rutas críticas.', 'tags' => ['RBAC', 'Security'], 'icon' => 'devicon-php-plain'],
            44 => ['desc' => 'Dashboard analítico con gráficos interactivos usando Chart.js y PHP.', 'tags' => ['ChartJS', 'JSON'], 'icon' => 'devicon-javascript-plain'],
            45 => ['desc' => 'Monitor de disponibilidad de servidores de red mediante pings activos.', 'tags' => ['Network', 'Ping'], 'icon' => 'devicon-php-plain'],
            46 => ['desc' => 'Motor de plantillas personalizado para separar vistas HTML de PHP.', 'tags' => ['Template', 'Parser'], 'icon' => 'devicon-php-plain'],
            47 => ['desc' => 'Autenticación stateless mediante generación y validación de tokens JWT.', 'tags' => ['JWT', 'API_Security'], 'icon' => 'devicon-php-plain'],
            48 => ['desc' => 'CMS dinámico autoadministrable para portafolio de agencias.', 'tags' => ['CMS', 'Dynamic'], 'icon' => 'devicon-php-plain'],
            49 => ['desc' => 'Sistema de registro de auditoría para la trazabilidad de acciones críticas.', 'tags' => ['Audit', 'Security'], 'icon' => 'devicon-mysql-plain'],
            50 => ['desc' => 'Aplicación empresarial integrada con MVC, CRUD, PDF y sesión segura.', 'tags' => ['MVC', 'Full_Stack'], 'icon' => 'devicon-php-plain'],
        ];
    }
}
