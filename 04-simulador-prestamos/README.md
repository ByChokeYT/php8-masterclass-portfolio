
![Simulador de Préstamos Banner](assets/banner_simulador_prestamos.png)

# 04 Simulador de Préstamos | php8-masterclass-portfolio

> **Tu Analista Financiero Personal**
> Calcula cuotas, intereses y tablas de amortización con precisión bancaria y diseño premium.

## 🏦 Descripción

El **Simulador de Préstamos** es una herramienta esencial en este portfolio. Utiliza el **Sistema Francés de Amortización** (cuotas fijas) para proyectar planes de pago. La interfaz está diseñada para ser altamente interactiva, permitiendo a los usuarios ajustar montos y plazos mediante deslizadores (sliders) y ver el impacto en sus cuotas en tiempo real.

Ideal para visualizar créditos personales, hipotecarios o vehiculares.

---

## 🚀 Características Clave

### 1. Motor de Cálculo Financiero
*   **Sistema Francés:** Implementación precisa de la fórmula de anualidades para cuotas constantes.
*   **Desglose Mensual:** Generación automática de tablas que separan capital, interés y saldo restante.
*   **Resumen Instantáneo:** Tarjetas con los totales clave (Cuota, Interés Total, Total a Pagar).

### 2. UI "Digital Banking"
*   **Sliders Interactivos:** Ajuste fluido de variables (Monto, Plazo, Tasa) sin recargar la página constantemente (vía JavaScript para previsualización).
*   **Diseño Metálico/Azul:** Una paleta de colores corporativa y seria, inspirada en las apps de banca moderna.
*   **Feedback Visual:** Colores semánticos para intereses (índigo) y capital (verde).

### 3. Arquitectura Limpia
*   **Clase `Loan`:** Objeto de transferencia de datos (DTO) con tipos estrictos de PHP 8.5.
*   **Servicio `AmortizationService`:** Lógica matemática encapsulada, fácil de probar y reutilizar.

---

## 🛠️ Tecnologías

*   **Lenguaje:** PHP 8.5
*   **Frontend:** HTML5, CSS3 (Grid, Custom Range Inputs)
*   **Fuentes:** Google Fonts 'Outfit'
*   **Iconos:** Phosphor Icons

---

## 📦 Estructura

```
04_simulador_prestamos/
├── assets/
│   └── banner_simulador_prestamos.png
├── public/
│   ├── css/
│   │   └── style.css      # Estilos "Banking"
│   └── index.php          # Interfaz Principal
├── src/
│   ├── Classes/
│   │   └── Loan.php       # Modelo de Datos
│   └── Services/
│       └── AmortizationService.php # Lógica Financiera
└── README.md
```

---

## ⚡ Cómo Usar

1. Ejecuta el servidor desde la carpeta `public`:
```bash
php -S localhost:8081
```
2. Accede a `http://localhost:8081`.
3. Ajusta los sliders para simular tu préstamo ideal.

---

**php8-masterclass-portfolio • Proyecto 04**
