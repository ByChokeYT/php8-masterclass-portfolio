# Día 01 — Calculadora de Minerales CLI
## Masterclass PHP 8.5 | Fase 1: Dominio de la Terminal

Este es el proyecto inicial de la serie de 50 retos. Aquí sentamos las bases de la **Arquitectura Inmutable** y el manejo de tipos estrictos en PHP moderno.

---

## 🛠️ Tecnologías Aplicadas
- **PHP 8.5** (Readonly Classes y Enums respaldados).
- **Tipado Estricto** (`declare(strict_types=1)`).
- **Aritmética Entera** (Prevención de errores de punto flotante).
- **ANSI Colors** (Interfaz profesional en terminal).

---

## 📂 Estructura del Proyecto
```bash
dia-01-calculadora-minerales/
├── main.php                    # Punto de entrada (Menú Interactivo)
├── src/
│   ├── Enums/MineralType.php   # Tipos seguros de minerales
│   ├── DTO/Liquidacion.php     # Contenedor de datos inmutable
│   └── Services/Calculator.php  # Lógica de cálculo industrial
└── soluciones/                 # Repositorio de retos resueltos
```

---

## 🚀 Cómo Ejecutar
1. Abre tu terminal (Laragon Terminal o PowerShell).
2. Navega hasta esta carpeta: `cd dia-01-calculadora-minerales`
3. Ejecuta el script principal:
   ```bash
   php main.php
   ```

---

## 🏆 Desafíos y Soluciones
Si quieres subir de nivel, dentro de la carpeta `soluciones/` encontrarás la implementación oficial de los retos propuestos:

1.  **Nivel 1 - Básico (`soluciones/nivel-1-basico`)**: 
    - Se añade el mineral **ORO** al sistema.
    - Implementación de primas de mercado (+5%).
2.  **Nivel 2 - Intermedio (`soluciones/nivel-2-intermedio`)**: 
    - Implementación de bucle `while` para realizar múltiples cálculos sin reiniciar.
3.  **Nivel 3 - Avanzado (`soluciones/nivel-3-avanzado`)**: 
    - **Historial de Sesión**: Se guardan los resultados en un array.
    - **Reporte Final**: Al salir, se muestra un resumen con el total de USD acumulado.

---

## 🧠 Conceptos que aprenderás
- **DTO (Data Transfer Object)**: Por qué proteger la integridad de los datos.
- **Enums**: Cómo eliminar los "magic strings" y centralizar la lógica de tipos.
- **Match Expression**: La alternativa moderna y potente al `switch`.
- **intdiv() & round()**: Por qué el dinero se calcula en centavos (enteros).

---
*Diseñado para la Masterclass de PHP 8.5 — Ingeniería de Software desde el Día 01.*
