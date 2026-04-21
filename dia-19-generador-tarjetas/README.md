# DÍA 19: GENERADOR DE TARJETAS DE PRESENTACIÓN

## 🛠 Consigna
Desarrollar un generador dinámico de tarjetas de presentación (Business Cards) con una estética industrial premium. El sistema debe permitir la edición en tiempo real (Live Preview) y asegurar que el modelo de datos sea robusto y tipado, utilizando las capacidades de PHP 8.5.

---

## 🏛 Estructura del Proyecto
```bash
dia-19-generador-tarjetas/
├── index.php        # Controlador central + UI + Lógica AJAX
└── README.md        # Documentación técnica del módulo
```

---

## 🚀 Ingeniería de Datos (PHP 8.5 Core)
Para este proyecto, hemos implementado una arquitectura basada en **Data Transfer Objects (DTO)** inmutables:

- **Clase `BusinessProfile`:** Una clase `readonly` que encapsula toda la identidad del usuario. Esto asegura que una vez que se procesan los datos del formulario, la información no pueda ser alterada durante el ciclo de renderizado.
- **Lógica de Iniciales:** El sistema incluye un método dinámico para extraer las iniciales del nombre de forma inteligente, asegurando que la marca personal sea siempre visible en el avatar de la tarjeta.
- **Selector de Color Dinámico:** El usuario puede elegir un "Tono de Acento" que se propaga a través de la tarjeta (bordes, iconos, sombras y luces), permitiendo una personalización total sin perder la estética industrial.

---

## 🎨 Interfaz de Usuario (UX/UI Premium)
- **Live Rendering Buffer:** Utilizando la técnica de AJAX/Fetch, la tarjeta se redibuja en milisegundos en el lado derecho mientras el usuario completa el formulario a la izquierda.
- **Efecto Holográfico:** La tarjeta cuenta con un efecto de "brillo" (`shine`) que se activa al pasar el ratón, simulando un material físico premium.
- **Modo de Impresión:** Se han implementado reglas de CSS `@media print` para ocultar los controles de edición y permitir imprimir solo la tarjeta en alta calidad sobre fondo blanco.

---

## 💻 Stack Tecnológico
- **PHP 8.5+**: Manejo de clases inmutables y procesamiento de strings multibyte.
- **Tailwind CSS**: Core de diseño para la rejilla industrial y efectos de cristal.
- **Phosphor Icons**: Librería de iconos vectoriales para los campos de contacto.

---

## 📋 Instrucciones de Uso
1. Completar los campos de **Identidad** y **Contacto** en el panel de edición.
2. Seleccionar un **Tono de Acento** para personalizar la marca.
3. Observar la tarjeta generada en el buffer lateral.
4. Presionar **"Generar Versión Impresa"** para obtener un archivo listo para producción.

---
**MASTERCLASS PHP 8.5 // BY CHOKE**
