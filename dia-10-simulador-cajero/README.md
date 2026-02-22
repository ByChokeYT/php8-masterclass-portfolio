# 10 Simulador de Cajero ATM | PHP 8.5 Bank
> **Interfaz Glassmorphism Premium & Manejo de Sesiones**
> Un simulador completo de cajero automático (ATM) con una UI moderna y lógica de transacciones segura.

## 🏦 Descripción

El **Simulador de Cajero ATM** es el proyecto final (Proyecto 10) que consolida los conocimientos adquiridos. Lo que comenzó como un simple script de consola (CLI), ha evolucionado a una aplicación web completa "Single Page" que simula un cajero automático interactivo de la red "ByBank".

El diseño utiliza un estilo "Dark Glassmorphism" con animaciones suaves, destellos neón y una paleta de colores profesional centrada en Cyan y Blue. Toda la experiencia de usuario ocurre sin recargar la página visiblemente, manteniendo la persistencia de datos mediante sesiones de PHP.

---

## 🚀 Características Premium

### 1. Interfaz de Cajero Realista
- **Card Layout:** El contenedor principal simula la pantalla física de un cajero.
- **Iconografía Minimalista:** Reemplazo de emojis básicos por iconos vectoriales (Heroicons) integrados limpiamente.
- **Feedback Visual Inmediato:** Alertas de colores para depósitos exitosos (verde), errores (rojo) o cierres de sesión (azul).

### 2. Lógica Financiera Robusta
- **Protección de Saldo:** No permite retirar más dinero del disponible.
- **Validación Estricta:** Manejo de excepciones (Exceptions) nativas de PHP ante montos negativos o caracteres inválidos.
- **Persistencia Temporal:** El saldo persiste mientras la "tarjeta esté insertada" (sesión activa).

### 3. Experiencia "Single Page" Adaptada
- **Insertar/Retirar Tarjeta:** Una vez finalizas tus operaciones, la pantalla del cajero se "apaga" simulando que has retirado tu tarjeta. Te presenta un botón para reiniciar la sesión sin salir de `index.php`.

---

## 🛠️ Tecnologías

### Backend (PHP 8.5)
- `declare(strict_types=1)`
- Programación Orientada a Objetos (POO).
- Manejo de Sesiones (`$_SESSION`).
- Bloques `try-catch` para captura de errores.

### Frontend
- **Framework CSS:** TailwindCSS (vía CDN) configurado al vuelo.
- **Estética:** Glassmorphism, CSS Variables, SVG Icons.
- **Fuentes:** Google Fonts 'Inter' y 'Outfit'.

---

## 📁 Estructura del Proyecto

```
10_simulador_cajero/
├── cajero.php             # Versión original en Consola (CLI)
├── public/
│   ├── favicon.ico        # Icono PHP Oficial
│   └── index.php          # Interfaz Web Principal (Glassmorphism)
├── src/
│   └── Classes/
│       └── CajeroAutomatico.php # Lógica de Negocio y Validaciones
└── README.md              # Documentación Actual
```

---

## ⚡ Cómo Ejecutar

### Versión Web Premium (Recomendada)
1. Navega a la carpeta y levanta el servidor en `public`:
```bash
cd 10_simulador_cajero
php -S localhost:8010 -t public
```
2. Visita: **http://localhost:8010**

### Versión Consola (Legado)
Si prefieres ver la estructura original en la terminal:
```bash
php cajero.php
```

---

**php8-masterclass-portfolio • Proyecto 10**
