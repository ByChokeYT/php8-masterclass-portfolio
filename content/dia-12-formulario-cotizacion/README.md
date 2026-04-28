# 12 Formulario de Cotización Dinámico | PHP 8.5
> **Cálculos en Tiempo Real & Inmutabilidad (DTOs)**

Este proyecto cierra el reto de los **12 días** enfocándose en la interacción avanzada entre el usuario y el servidor. Implementamos un simulador de cotizaciones industriales que calcula precios dinámicamente según materiales, dimensiones y complejidad.

## 🚀 Características
- **Cálculo Live:** Precios que se actualizan sin recargar la página gracias a JavaScript coordinado con una estructura de datos PHP.
- **Validación Estricta:** Uso de tipos de PHP 8.5 para asegurar que los datos de la cotización sean válidos desde el constructor.
- **UI Industrial:** Diseño basado en "Metal Dark" con Glassmorphism, siguiendo la línea visual del portafolio.

## 🛠️ Conceptos de PHP 8.5
- `readonly class`: Para crear DTOs (Data Transfer Objects) que representan el presupuesto.
- **Typed Properties & Enums**: Manejo seguro de materiales (Acero, Bronce, Aluminio).
- `match` expression: Lógica de cálculo de precios elegante y legible.

## 📁 Estructura
```
dia-12-formulario-cotizacion/
├── public/
│   └── index.php       # Frontend y controlador de cálculo
└── README.md           # Documentación
```

## ⚡ Cómo Ejecutar
```bash
cd dia-12-formulario-cotizacion
php -S localhost:8012 -t public
```
Visita: **http://localhost:8012**

---
**php8-masterclass-portfolio • Proyecto 12**
