# 06 Reloj en Tiempo Real | PHP 8.5 CLI App

> **Tu Reloj Personal en la Terminal**
> Un reloj digital que se actualiza cada segundo usando bucles `while` y control de terminal.

## ⏰ Descripción

El **Reloj en Tiempo Real** tiene dos versiones:
1. **CLI:** Aplicación de terminal con bucle `while(true)`
2. **Web:** Interfaz web con actualización JavaScript

Ambas versiones demuestran conceptos de actualización en tiempo real, pero usando diferentes enfoques técnicos.

---

## 🚀 Características

### 1. Actualización en Tiempo Real
- **Bucle Infinito:** Usa `while(true)` para mantener el reloj corriendo.
- **Sleep Controlado:** `sleep(1)` asegura actualizaciones cada segundo exacto.
- **Limpieza de Pantalla:** Códigos ANSI para refrescar la terminal sin parpadeos.

### 2. Diseño Terminal Elegante
- **Banner Decorativo:** Bordes Unicode para un look profesional.
- **Colores ANSI:** Cyan para el banner, amarillo para el reloj, blanco para la fecha.
- **Cursor Oculto:** Mejora la experiencia visual durante la ejecución.

### 3. Información Completa
- Hora actual (HH:MM:SS)
- Fecha completa en español
- Instrucciones de salida

---

## 🛠️ Tecnologías

- **Lenguaje:** PHP 8.5 (CLI)
- **Características:**
  - `declare(strict_types=1)`
  - Funciones tipadas
  - ANSI escape codes
  - Control de terminal

---

## ⚡ Cómo Usar

### Versión Web (Recomendada)
```bash
php -S localhost:8083 -t public
```
Luego visita: `http://localhost:8083`

### Versión CLI
```bash
./reloj.php
# o
php reloj.php
```

**Salir del reloj CLI:** Presiona `Ctrl+C`

---

## 📝 Conceptos Técnicos

### Bucle While Infinito
```php
while (true) {
    // Código que se ejecuta indefinidamente
    sleep(1); // Pausa de 1 segundo
}
```

### Códigos ANSI
- `\033[2J\033[H` - Limpia pantalla y mueve cursor al inicio
- `\033[1;36m` - Color cyan en negrita
- `\033[?25l` - Oculta el cursor
- `\033[?25h` - Muestra el cursor

---

**php8-masterclass-portfolio • Proyecto 06**
