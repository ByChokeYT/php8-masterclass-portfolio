# 🐘 PHP Masterclass — ByChoke Studios

![PHP](https://img.shields.io/badge/PHP-8.5-4F5B93?style=for-the-badge&logo=php&logoColor=white)
![Vue.js](https://img.shields.io/badge/Vue.js-3.x-4FC08D?style=for-the-badge&logo=vue.js&logoColor=white)
![Tailwind CSS](https://img.shields.io/badge/Tailwind-CSS-38B2AC?style=for-the-badge&logo=tailwind-css)
![Progreso](https://img.shields.io/badge/Proyectos-50%20%2F%2050-6366f1?style=for-the-badge)

> **"De Coder a Arquitecto Backend — sin teoría de relleno, puro código real."**
>
> Plataforma académica interactiva desarrollada por **José Luis Choquevillca (ByChoke Studios)**. Cada proyecto incluye su propio **Manual Pedagógico Interactivo** con árbol de carpetas, explorador de código fuente y simulación de ejecución.

---

## 🚀 Inicio Rápido

```bash
# 1. Clonar el repositorio
git clone https://github.com/ByChokeYT/php8-masterclass-portfolio.git
cd php8-masterclass-portfolio

# 2. Instalar dependencias (opcional, para Composer)
composer install

# 3. Levantar el servidor local con el router incluido
php -S localhost:8000 router.php

# 4. Abrir en el navegador
# 👉 http://localhost:8000
```

> **Requisito:** PHP 8.2 o superior. Verificar con `php -v`.

---

## 🏗️ Arquitectura del Proyecto

```
php8-masterclass-portfolio/
│
├── content/                    # 38 proyectos del curso (cada uno autocontenido)
│   ├── dia-1-calculadora-minerales/
│   │   ├── index.php           ← Manual Pedagógico Interactivo
│   │   ├── main.php            ← Punto de entrada CLI
│   │   └── src/
│   │       ├── Enums/
│   │       ├── DTO/
│   │       └── Services/
│   └── dia-N-.../
│
├── public/                     # Front Controller y assets
│   ├── index.php               ← Enrutador principal (Front Controller)
│   └── assets/
│       └── img/
│           ├── logo.gif
│           └── hero_elephant.png
│
├── src/                        # Núcleo del Hub
│   ├── Core/
│   │   ├── ProjectScanner.php  ← Escanea los 38 proyectos dinámicamente
│   │   └── Performance.php     ← Métricas de carga
│   └── Data/
│       └── ProjectRepository.php ← Metadatos y configuración de fases
│
├── views/                      # Capa de presentación del Hub
│   ├── layout.php              ← HTML base con design system
│   ├── main.php                ← Orquestador de secciones
│   └── sections/
│       ├── hero.php            ← Sección principal
│       ├── projects_grid.php   ← Grid Vue.js filtrable (38 proyectos)
│       ├── mentor.php          ← Sección del instructor
│       └── footer.php          ← Pie de página
│
├── templates/
│   └── pedagogical_view.php    ← Plantilla base para los Manuales Pedagógicos
│
├── _nav.php                    ← Navbar global para los proyectos del curso
├── router.php                  ← Router para PHP Built-in Server
├── index.php                   ← Fallback al Front Controller
├── .htaccess                   ← Rewrite rules para Apache
└── composer.json
```

---

## 📚 Plan de Estudios (5 Fases)

### 🟢 Fase 1 — Fundamentos y Sintaxis (Días 01–10)
> Lógica CLI, Tipado Estricto, OOP básica, Enums, DTOs, Sesiones y Excepciones.

| Día | Proyecto | Conceptos Clave |
|:---:|:---------|:----------------|
| 01 | Calculadora de Minerales | `Strict_Types`, `Enums`, `Readonly DTOs`, `match` |
| 02 | Calculadora IMC (CLI) | `Interfaces`, Aritmética entera, `mb_string` |
| 03 | Gestor de Gastos | `$_SESSION`, Patrón PRG, `BudgetManager` Service |
| 04 | Simulador de Préstamos | Amortización Francesa, algoritmos financieros |
| 05 | Calculadora IMC Pro | `try-catch`, `filter_input`, manejo de excepciones |
| 06 | Reloj en Tiempo Real | `DateTime`, `DateTimeZone`, PHP → JS handoff |
| 07 | Analizador de Texto | `array_count_values`, `arsort`, `mb_strlen` |
| 08 | Adivina el Número | Game Loop en HTTP stateless, `$_SESSION` |
| 09 | Validador de Email | `FILTER_VALIDATE_EMAIL`, `checkdnsrr`, DNS MX |
| 10 | Simulador de Cajero ATM | Lógica transaccional, excepciones de negocio |

### 🔵 Fase 2 — UI/UX y Formularios (Días 11–20)
> Tailwind CSS, `$_POST`/`$_GET`, formularios dinámicos, sesiones avanzadas.

| Día | Proyecto | Conceptos Clave |
|:---:|:---------|:----------------|
| 11 | Landing Page | Tailwind CSS, HTML semántico |
| 12 | Formulario de Cotización | Validación POST, arrays dinámicos |
| 13 | Recepción RSVP | Confirmaciones, sanitización |
| 14 | Subida de Archivos | `move_uploaded_file`, seguridad |
| 15 | Video Previewer | Galería dinámica por ID |
| 16 | Login en Memoria | `$_SESSION`, seguridad básica |
| 17 | Calculadora de Liquidación | Dashboard web profesional |
| 18 | Markdown to HTML | Parseo y renderizado de contenido |
| 19 | Generador de Tarjetas | Exportación de identidad visual |
| 20 | Encuesta Visual | Persistencia `.txt`, AJAX básico |

### 🟡 Fase 3 — Persistencia y SQL (Días 21–30)
> MySQL, PDO, CRUD completo, seguridad con hashing, transacciones.

| Día | Proyecto | Conceptos Clave |
|:---:|:---------|:----------------|
| 21 | Conexión PDO | Patrón Singleton, prepared statements |
| 22 | CRUD de Invitados | SQLite, operaciones completas |
| 23 | Inventario de Minerales | SQL avanzado, filtros y reportes |
| 24 | Registro Seguro | `password_hash`, `password_verify` |
| 25 | Gestor QR | Persistencia de URLs con metadata |
| 26 | Muro de Comentarios | Interacción pública con BD |
| 27 | Catálogo de Servicios | Renderizado dinámico desde SQL |
| 28 | Buscador de Contactos | `LIKE`, filtros avanzados |
| 29 | Registro de Gastos | Categorización y reportes |
| 30 | Dashboard Admin | Métricas agregadas |

### 🔴 Fase 4 — Arquitectura Moderna (Días 31–40)
> APIs REST, Composer, librerías externas, PDFs, XML/RSS.

| Día | Proyecto | Conceptos Clave |
|:---:|:---------|:----------------|
| 31 | Generador QR | Composer, librerías externas |
| 32 | Scraper del Clima | HTTP requests, scraping ético |
| 33 | Consumo API Metales | REST API, JSON decoding |
| 34 | Generador PDF | Dompdf, exportación documental |
| 35 | Exportador CSV | `fputcsv`, formatos de intercambio |
| 36 | Envío de Correos | `PHPMailer`, SMTP, Composer |
| 37 | Acortador de URL | Redirecciones, manejo de slugs |
| 38 | Login con Sesiones | Auth completa, RBAC básico |
| 39 | Lector RSS | Parsing XML, feeds externos |
| 40 | Backup de BD | Copias de seguridad de BD en PHP |

### 🟣 Fase 5 — Ecosistema Real-World (Días 41–50)
> Seguridad avanzada, Deploy, APIs en producción.

| Día | Proyecto | Conceptos Clave |
|:---:|:---------|:----------------|
| 41 | Enrutador MVC Básico | `MVC, Front Controller, Routing` |
| 42 | Liquidación Normativa | `Business Logic, SQLite, SQL` |
| 43 | Control de Acceso (RBAC) | `RBAC, Security, Role Management` |
| 44 | Dashboard Analítico | `Chart.js, JSON, Data Visualization` |
| 45 | Monitor de Servidores | `Network Ping, fsockopen, Status` |
| 46 | Template Engine | `RegEx, Parser, Layout Separation` |
| 47 | Autenticación con JWT | `JWT, Token-based Auth, APIs` |
| 48 | Portafolio de Agencia | `CMS, CRUD, Custom Dashboard` |
| 49 | Log de Auditoría | `Audit Trails, Security logging` |
| 50 | El Ecosistema Integrado | `Full-stack, MVC, PDF, Auth` |

---

## 🛠️ Stack Tecnológico

| Capa | Tecnología | Uso |
|:-----|:-----------|:----|
| **Backend** | PHP 8.5 | Lógica, enrutamiento, manejo de proyectos |
| **Frontend Hub** | Vue.js 3 (CDN) | Grid interactivo y filtrado de proyectos |
| **Estilos** | Tailwind CSS (CDN) | Design system consistente |
| **Íconos** | Phosphor Icons | Iconografía técnica |
| **Dev Icons** | Devicon | Logos de tecnologías en las cards |
| **Animaciones** | AOS.js | Scroll reveal animations |
| **Fuentes** | Inter + JetBrains Mono | Tipografía profesional |
| **Síntaxis** | Prism.js | Resaltado de código en Manuales |

---

## 🎓 ¿Qué es el Manual Pedagógico?

Cada proyecto tiene una página de aprendizaje interactiva (`index.php` en la raíz de cada día) que incluye:

1. **Árbol de Carpetas Interactivo** — haz clic en cualquier archivo para verlo
2. **Explorador de Código** — con resaltado de sintaxis PHP (Prism.js)
3. **Objetivos de Aprendizaje** — qué conceptos se dominan en ese día
4. **Nota del Profesor** — el porqué de las decisiones de arquitectura
5. **Terminal Simulada** — muestra la salida esperada del programa

---

## 👨‍🏫 El Instructor

**José Luis Choquevillca** — Software Engineer & Mentor con 10+ años de experiencia en desarrollo backend con PHP, MySQL y arquitecturas de software empresarial.

- 🌐 [Portafolio](https://bychokeportafolio.netlify.app/)
- 💼 [LinkedIn](https://www.linkedin.com/in/jose-luis-choquevillca/)
- 📧 choque151.jlc@gmail.com
- 💬 WhatsApp: +591 62793829

---

## 📄 Licencia

MIT License — © 2025 ByChoke Studios / José Luis Choquevillca.

*"Construyendo el futuro del desarrollo PHP, línea a línea."*
