
![Gestor de Gastos Banner](assets/banner_gestor_gastos.png)

# 03 Gestor de Gastos | php8-masterclass-portfolio

> **Dashboard Financiero Personal**
> Una aplicación web moderna para controlar ingresos y gastos con una interfaz premium de alto impacto.

## 💼 Descripción

El **Gestor de Gastos** es la tercera entrega de este portfolio de herramientas en PHP. Diseñado con una estética "Dark Glassmorphism", este sistema permite a los usuarios registrar sus movimientos financieros diarios en una interfaz que simula una aplicación nativa o un dashboard bancario de alta gama.

El enfoque principal ha sido la **Experiencia de Usuario (UX)**, implementando formularios intuitivos, feedback visual inmediato y un diseño responsivo que funciona perfectamente en escritorio y móvil.

---

## 🚀 Características Premium

### 1. Interfaz "Split Dashboard"
*   **Layout Balanceado:** El formulario de entrada se sitúa a la derecha para un acceso rápido, mientras que los datos vitales (balance, lista) permanecen a la izquierda.
*   **Efecto Glassmorphism:** Paneles translúcidos con desenfoque de fondo que crean profundidad y jerarquía visual.
*   **Iconografía Inteligente:** Cada categoría de gasto (Comida, Transporte, etc.) se asigna automáticamente a un icono específico de *Phosphor Icons*.

### 2. Formulario Interactivo
*   **Inputs con Iconos:** Campos de entrada enriquecidos visualmente para reducir la carga cognitiva.
*   **Toggle Deslizante:** Selector de "Ingreso/Gasto" animado y claro.
*   **Botones con Gradiente:** Llamadas a la acción (CTA) vibrantes que invitan a la interacción.

### 3. Gestión de Estado (PHP Session)
*   **Persistencia:** Los datos se guardan en la sesión del usuario, permitiendo un flujo de trabajo continuo sin base de datos compleja.
*   **Arquitectura de Servicios:** Lógica separada en `BudgetManager` y `Transaction` classes.

---

## 🛠️ Tecnologías

*   **Backend:** PHP 8.5 (Strict Types, Classes)
*   **Frontend:** HTML5, CSS3 (Grid/Flexbox, Variables, Animations)
*   **Fuentes:** Google Fonts 'Outfit'
*   **Iconos:** Phosphor Icons (Script CDN)

---

## 📦 Estructura del Proyecto

```
03_gestor_gastos/
├── assets/
│   └── banner_gestor_gastos.png # Banner del Proyecto
├── public/
│   ├── css/
│   │   └── style.css      # Estilos Premium (Glass/Dark)
│   └── index.php          # Dashboard Principal
├── src/
│   ├── Classes/
│   │   └── Transaction.php # DTO de Transacción
│   └── Services/
│       └── BudgetManager.php # Lógica de Negocio
└── README.md              # Documentación
```

---

## ⚡ Cómo Ejecutar

1. Inicia el servidor interno de PHP en la carpeta `public`:
```bash
php -S localhost:8080 -t public
```
2. Abre `http://localhost:8080` en tu navegador.
3. ¡Empieza a registrar tus finanzas!

---

## 📸 Capturas

*Dashboard con diseño responsivo y modo oscuro por defecto.*

---

**Desarrollado con ❤️ y PHP 8.5**
