
![Conversor Divisas Banner](assets/banner_conversor_divisas.png)

# 02 Conversor de Divisas | PHP 8.5 Engineering

> **Professional Fintech Edition**
> Un widget de conversión de divisas de alto rendimiento con diseño "Trading Card" y arquitectura limpia.

## 💼 Descripción del Proyecto

Este proyecto es una herramienta de conversión de divisas moderna y profesional. A diferencia de un conversor estándar, este sistema emula la experiencia de un **Widget Financiero (Trading Widget)**, con soporte para múltiples monedas, tasas de cambio en tiempo real (simuladas) y un historial de transacciones.

Diseñado con los colores oficiales de **PHP** (Violeta/Azul) integrados en una estética "Dark Mode Glassmorphism", demostrando que PHP puede impulsar interfaces de usuario vibrantes y modernas.

---

## 🚀 Características Premium

### 1. Interfaz "Trading Card" Compacta
*   **Diseño Widget:** Estructura vertical optimizada para ocupar poco espacio, ideal para barras laterales o dashboards móviles.
*   **Tipografía Ticker:** Uso de fuentes *Monospace* para los números, simulando los paneles de la bolsa de valores.
*   **Botón Swap:** Funcionalidad rápida para invertir las divisas de origen y destino con un solo clic.

### 2. Arquitectura Sólida (PHP 8.5)
*   **Enums Tipados:** Uso de `enum Currency` para gestionar divisas, banderas y símbolos de forma segura y estricta.
*   **Servicio Desacoplado:** La lógica de conversión reside en `ConverterService`, separada de la vista.
*   **Patrón PRG:** Implementación de *Post-Redirect-Get* para evitar reenvíos de formularios y mantener la experiencia fluida.

### 3. Historial de Transacciones
*   **Log de Operaciones:** Registro de las últimas conversiones realizadas.
*   **Persistencia de Sesión:** El historial se mantiene mientras el navegador esté abierto.
*   **Gestión:** Opción para limpiar el historial con un solo clic.

---

## 🛠️ Tecnologías

*   **Core:** PHP 8.5 (Strict Types, Enums)
*   **Frontend:** HTML5, CSS3 (Glassmorphism, Grid/Flexbox)
*   **Fuentes:** Google Fonts 'Outfit' (UI) & Monospace (Cifras)
*   **Iconos:** Phosphor Icons (Estilo Duotone & Bold)

---

## 📦 Estructura del Proyecto

```
02_conversor_divisas/
├── bin/
│   └── cli.php            # Interfaz de Línea de Comandos (Testing)
├── public/
│   ├── css/
│   │   └── style.css      # Estilos "Fintech Emerald/PHP"
│   └── index.php          # Web App (Trading Widget)
├── src/
│   ├── Enums/
│   │   └── Currency.php   # Definición de Monedas (Enums)
│   └── Services/
│       └── ConverterService.php # Lógica de Negocio
└── README.md              # Documentación
```

---

## ⚡ Cómo Ejecutar

### Web Interface
Inicia el servidor interno de PHP:
```bash
php -S localhost:8000 -t public
```
Visita `http://localhost:8000` en tu navegador.

### CLI Testing
Prueba conversiones rápidas desde la terminal:
```bash
# Formato: php bin/cli.php [CANTIDAD] [ORIGEN] [DESTINO]
php bin/cli.php 100 USD EUR
```

---

## 📸 Capturas

*Diseño "Trading Card" con efecto Glassmorphism y paleta oficial de PHP.*

---

**Desarrollado con ❤️ y PHP 8.5**
