# 11 Landing Page de Agencia | PHP 8.5
> **Renderizado Dinámico & UI Premium (Glassmorphism)**
> Una One-Page minimalista generada de forma completamente dinámica a través de arrays asociativos y clases DTO de PHP.

## 🚀 Descripción

Iniciando la **Fase 2 (UI/UX, Tailwind y Formularios)** del roadmap, este proyecto abandona la interfaz de consola para centrarse fuertemente en estructurar información de backend para pintarla en el frontend con estilo moderno.

Toda la información visible (Hero section, Servicios, Testimonios y Estadísticas) fluye desde código PHP en el servidor puro, demostrando cómo construir plantillas sin depender inicialmente de un motor visual (como Blade o Twig) o base de datos.

---

## 🎨 Características Visuales

- **Tema "Cyber Agency":** Colores Slate oscuros combinados con Sky Blue / Cyan y tonos púrpuras.
- **Glassmorphism Inteligente:** Paneles semi-transparentes con blur (`backdrop-filter`) para dar profundidad a las tarjetas de servicio.
- **Tipografía Moderna:** Mezcla de `Outfit` (Headings) e `Inter` (Cuerpo) vía Google Fonts.
- **Iconografía:** Phosphor Icons integrados limpiamente.
- **Animaciones sutiles:** Keyframes personalizados (`animate-float-up`) combinados con delay utilitario de Tailwind.

---

## 🛠️ Conceptos de PHP 8.5

En este proyecto aplicamos **Patrones DTO (Data Transfer Objects)** ligeros apoyándonos en las últimas ventajas del lenguaje:

- `readonly class`: Asegura que las propiedades de una entidad (`Service`, `Testimonial`, `Stat`) no puedan ser modificadas después de su instanciación.
- **Constructor Property Promotion:** Menos código boilerplate. Declaramos visibilidad (`public`) y tipos directamente en el `__construct()`.
- **Tipado estricto:** `declare(strict_types=1);` activo.

### Ejemplo de código:
```php
readonly class Service {
    public function __construct(
        public string $id,
        public string $title,
        public string $description,
        public string $icon,
        public string $colorClass,
        public string $bgClass
    ) {}
}
```

---

## 📁 Estructura

```
dia-11-landing-page/
├── public/
│   └── index.php       # Controlador y Vista unificada (Single File Demo)
└── README.md           # Documentación
```

---

## ⚡ Cómo Ejecutar

Navega a la carpeta y levanta el servidor web nativo de PHP apuntando a la carpeta `/public`:

```bash
cd dia-11-landing-page
php -S localhost:8011 -t public
```

Visita: **http://localhost:8011**

---

**php8-masterclass-portfolio • Proyecto 11**
