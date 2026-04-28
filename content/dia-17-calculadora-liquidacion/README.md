# DÍA 17: CALCULADORA WEB DE LIQUIDACIÓN

## 🛠 Consigna
Evolucionar la lógica de cálculo de minerales del Día 1 (basada en CLI) a una herramienta web visual de alta fidelidad. El proyecto demuestra la capacidad de portar lógica de negocio compleja a una interfaz amigable y profesional utilizando Tailwind CSS y PHP 8.5.

---

## 🏛 Estructura del Proyecto
```bash
dia-17-calculadora-liquidacion/
├── index.php        # Interfaz unificada + Lógica de Liquidación
└── README.md        # Documentación técnica del módulo
```

---

## 🚀 Características Técnicas
- **Lógica de Dominio:** Implementación de Enums y Classes Inmutables (readonly) para asegurar la integridad de los cálculos.
- **Match Expression:** Uso avanzado de `match()` de PHP 8 para determinar tasas y descuentos específicos por mineral.
- **Validación Robusta:** Sistema de captura de excepciones para asegurar que los cálculos solo se realicen con parámetros físicos reales (Peso > 0, Pureza <= 100%).
- **Persistencia Visual:** La calculadora mantiene los datos ingresados incluso después de procesar, permitiendo ajustes rápidos.

---

## 🎨 Diseño "Industrial-Grid"
- **Grid Predictivo:** Fondo con rejilla industrial consistente con el Master Hub.
- **Ticket Digital:** Generación de un recibo visual con identificadores únicos (REF_ID) y firmas de autenticidad simuladas.
- **Interactividad:** Tarjetas de selección de mineral con feedback visual instantáneo.

---

## 💻 Stack Tecnológico
- **PHP 8.5+**: Motor de cálculo y manejo de tipos.
- **Tailwind CSS**: Engine de diseño para la estética premium.
- **Phosphor Icons**: Iconografía técnica y consistente.

---

## 📋 Instrucciones de Uso
1. Seleccionar el mineral (Estaño, Zinc o Plata).
2. Ingresar el Peso Bruto en Kilogramos.
3. Especificar la Pureza o Ley (porcentaje).
4. Indicar la cotización actual del mercado en USD/Kg.
5. Presionar **"Calcular Liquidación"** para generar el certificado digital.

---
**MASTERCLASS PHP 8.5 // BY CHOKE**
