```
╔══════════════════════════════════════════════════════════════╗
║                                                              ║
║     █████╗ ███╗   ██╗ █████╗ ██╗     ██╗███████╗ █████╗    ║
║    ██╔══██╗████╗  ██║██╔══██╗██║     ██║╚══███╔╝██╔══██╗   ║
║    ███████║██╔██╗ ██║███████║██║     ██║  ███╔╝ ███████║   ║
║    ██╔══██║██║╚██╗██║██╔══██║██║     ██║ ███╔╝  ██╔══██║   ║
║    ██║  ██║██║ ╚████║██║  ██║███████╗██║███████╗██║  ██║   ║
║    ╚═╝  ╚═╝╚═╝  ╚═══╝╚═╝  ╚═╝╚══════╝╚═╝╚══════╝╚═╝  ╚═╝   ║
║                                                              ║
║              📊 ANALIZADOR DE TEXTO • PHP 8.5                ║
║           Análisis en Tiempo Real • Proyecto 07              ║
║                                                              ║
╚══════════════════════════════════════════════════════════════╝
```

# 07 Analizador de Texto | PHP 8.5

> **Análisis Completo de Texto en Tiempo Real**
> Cuenta palabras, caracteres, oraciones y más con actualización instantánea mientras escribes.

## 📝 Descripción

El **Analizador de Texto** es una herramienta web profesional que proporciona estadísticas detalladas sobre cualquier texto ingresado. Combina JavaScript para análisis en tiempo real con PHP para procesamiento del lado del servidor.

Ideal para:
- ✍️ Escritores que necesitan control de longitud
- 📚 Estudiantes trabajando en ensayos con límites de palabras
- 📊 Profesionales creando contenido optimizado
- 🎯 Cualquiera que necesite estadísticas precisas de texto

---

## 🚀 Características

### 📊 Métricas Analizadas

1. **Palabras Totales**
   - Conteo preciso usando `str_word_count()`
   - Actualización en tiempo real

2. **Caracteres**
   - Con espacios incluidos
   - Sin espacios (solo letras)
   - Útil para límites de redes sociales

3. **Oraciones**
   - Detectadas por puntuación (. ! ?)
   - Análisis con expresiones regulares

4. **Párrafos**
   - Separados por líneas en blanco
   - Conteo automático de bloques de texto

5. **Promedio de Longitud**
   - Letras por palabra
   - Métrica de complejidad del texto

### 🎨 Diseño UX/UI

- **Layout Compacto:** Todo visible en una sola pantalla (100vh)
- **Grid 2 Columnas:** Textarea grande + estadísticas en grid 2x2
- **Colores PHP Oficiales:** Paleta ElePHPant (azul #4F5B93)
- **Iconos Phosphor:** Cada métrica con icono distintivo
- **Responsive:** Se adapta a móviles automáticamente
- **Animaciones Suaves:** Hover effects en tarjetas

### ⚡ Tecnología

**Frontend:**
- HTML5 semántico
- CSS3 Grid & Flexbox
- JavaScript vanilla (sin dependencias)
- Actualización en tiempo real con `oninput`

**Backend (Clase PHP):**
```php
class TextAnalyzer {
    - countWords(): int
    - countCharacters(bool $withSpaces): int
    - countSentences(): int
    - countParagraphs(): int
    - averageWordLength(): float
    - getAnalysis(): array
}
```

**Características PHP 8.5:**
- `declare(strict_types=1)`
- Constructor Property Promotion
- Typed properties
- Return type declarations

---

## 📁 Estructura del Proyecto

```
07_analizador_texto/
├── public/
│   └── index.php          # Interfaz web con análisis JS
├── src/
│   └── Classes/
│       └── TextAnalyzer.php  # Clase PHP de análisis
└── README.md
```

---

## ⚡ Cómo Usar

### Iniciar el servidor
```bash
cd 07_analizador_texto
php -S localhost:8084 -t public
```

### Acceder a la aplicación
Visita: **http://localhost:8084**

### Usar el analizador
1. Escribe o pega texto en el área de texto
2. Las estadísticas se actualizan automáticamente
3. Observa las 6 métricas en tiempo real

---

## 💡 Casos de Uso

### Para Escritores
- Control de longitud de artículos
- Verificar límites de palabras
- Analizar complejidad del texto

### Para Redes Sociales
- Twitter: límite de 280 caracteres
- LinkedIn: posts óptimos de 1,300 caracteres
- Instagram: captions hasta 2,200 caracteres

### Para Estudiantes
- Ensayos con requisitos de palabras
- Verificar extensión de trabajos
- Analizar estructura de párrafos

---

## 🔧 Métodos de la Clase TextAnalyzer

| Método | Retorno | Descripción |
|--------|---------|-------------|
| `countWords()` | `int` | Total de palabras |
| `countCharacters(true)` | `int` | Caracteres con espacios |
| `countCharacters(false)` | `int` | Caracteres sin espacios |
| `countSentences()` | `int` | Oraciones detectadas |
| `countParagraphs()` | `int` | Párrafos separados |
| `averageWordLength()` | `float` | Promedio letras/palabra |
| `getAnalysis()` | `array` | Todas las métricas |

---

## 🎯 Próximas Mejoras

- [ ] Detección de idioma
- [ ] Tiempo estimado de lectura
- [ ] Análisis de legibilidad (Flesch-Kincaid)
- [ ] Exportar estadísticas a PDF
- [ ] Historial de análisis

---

**php8-masterclass-portfolio • Proyecto 07**  
*Parte de la serie de proyectos PHP 8.5*
