# 🐘 php8-masterclass-portfolio

> **Colección de proyectos educativos usando las últimas características de PHP**
> Desde calculadoras hasta aplicaciones web completas, todos con diseño premium y código moderno.

---

## 📚 Proyectos Completados

### Nivel 1: Fundamentos

#### [Día 01 - Calculadora de Minerales](./dia-1-calculadora-minerales)
**Concepto:** Introducción a PHP básico  
**Tecnologías:** Enums, Clases, Sesiones, PRG Pattern  
**UI:** Glassmorphism, Gradientes, Fintech Theme  
🚀 Puerto: `8000`

#### [Día 02 - Conversor de Divisas](./dia-2-conversor-divisas)
**Concepto:** Enums y servicios  
**Tecnologías:** Currency Enum, ConverterService, Historial  
**UI:** Trading Card Layout, Monospace Typography  
🚀 Puerto: `8000`

#### [Día 03 - Gestor de Gastos](./dia-3-gestor-gastos)
**Concepto:** DTOs y gestión de sesiones  
**Tecnologías:** Transaction DTO, BudgetManager, Session Persistence  
**UI:** Dashboard Financiero, Sidebar Layout  
🚀 Puerto: `8080`

#### [Día 04 - Simulador de Préstamos](./dia-4-simulador-prestamos)
**Concepto:** Cálculos matemáticos complejos  
**Tecnologías:** Amortización Francesa, Sliders Interactivos  
**UI:** Bank Fintech Theme, Tabla de Amortización  
🚀 Puerto: `8081`

#### [Día 05 - Calculadora de IMC](./dia-5-calculadora-imc)
**Concepto:** Tipos de datos y validación estricta  
**Tecnologías:** `match` expressions, Constructor Promotion, `readonly`  
**UI:** HealthTech Theme, Escala Visual de Colores  
🚀 Puerto: `8082`

#### [Día 06 - Reloj en Tiempo Real](./dia-6-reloj-tiempo-real)
**Concepto:** Bucles y actualización continua  
**Tecnologías:** `while(true)`, ANSI codes, JavaScript `setInterval()`  
**UI:** Reloj Digital + Clima de Oruro (API Open-Meteo)  
🚀 Puerto: `8083` | CLI: `php reloj.php`

#### [Día 07 - Analizador de Texto](./dia-7-analizador-texto)
**Concepto:** Procesamiento de strings y regex  
**Tecnologías:** `str_word_count()`, `mb_strlen()`, `preg_match_all()`  
**UI:** Grid 2 Columnas, Análisis en Tiempo Real  
🚀 Puerto: `8084`

---

## 🛠️ Tecnologías Utilizadas

### PHP 8.5 Features
- ✅ `declare(strict_types=1)`
- ✅ Constructor Property Promotion
- ✅ `readonly` properties
- ✅ `match` expressions
- ✅ Enums
- ✅ Union Types
- ✅ Typed Properties & Return Types

### Frontend
- HTML5 Semántico
- CSS Grid & Flexbox
- Custom Properties (CSS Variables)
- Glassmorphism & Gradientes
- Animaciones CSS
- JavaScript Vanilla

### Patrones de Diseño
- Post/Redirect/Get (PRG)
- Data Transfer Objects (DTOs)
- Service Layer Pattern
- Session Management
- Real-time Updates

### Recursos Externos
- [Phosphor Icons](https://phosphoricons.com/) - Iconografía
- [Google Fonts](https://fonts.google.com/) - Tipografías (Outfit, Orbitron)
- [Open-Meteo API](https://open-meteo.com/) - Datos del clima
- PHP Official Favicon

---

## 🎨 Filosofía de Diseño

Todos los proyectos siguen estos principios:

1. **Paleta PHP Oficial:** ElePHPant Blue (#4F5B93, #8892BF)
2. **Single-Page Layout:** Todo visible sin scroll (100vh)
3. **Premium Look:** Glassmorphism, gradientes, sombras
4. **Responsive:** Adaptable a móviles
5. **Animaciones Suaves:** Hover effects, transiciones

---

## 🚀 Inicio Rápido

### Requisitos
- PHP 8.5+
- Navegador moderno
- Terminal

### Ejecutar un proyecto

```bash
# Ejemplo: Proyecto 07
cd dia-7-analizador-texto
php -S localhost:8084 -t public
```

Luego visita: `http://localhost:8084`

---

## 📖 Roadmap

Ver [ROADMAP.md](./ROADMAP.md) para la lista completa de proyectos planificados.

**Próximos proyectos:**
- 08: Generador de Contraseñas
- 09: Calculadora Científica
- 10: Piedra, Papel o Tijera
- 11: Landing Page con Formulario
- 12: Sistema de Login
- 13: CRUD de Tareas

---

## 📝 Estructura de Cada Proyecto

```
XX_nombre_proyecto/
├── public/
│   ├── index.php       # Punto de entrada
│   └── css/
│       └── style.css   # Estilos (si aplica)
├── src/
│   ├── Classes/        # DTOs y modelos
│   └── Services/       # Lógica de negocio
└── README.md           # Documentación específica
```

---

## 🤝 Contribuciones

Este es un proyecto educativo personal. Si encuentras mejoras o bugs, siéntete libre de sugerir cambios.

---

## 📄 Licencia

MIT License - Libre para uso educativo y personal.

---

**Desarrollado con 💙 usando PHP 8.5**  
*php8-masterclass-portfolio • 2026*
