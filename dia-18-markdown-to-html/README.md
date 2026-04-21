# DÍA 18: CONVERTIDOR DE MARKDOWN A HTML

## 🛠 Consigna
Implementar un motor de renderizado de Markdown a HTML utilizando PHP 8.5 puro. El objetivo es procesar sintaxis técnica y mostrarla en una interfaz de previsualización en tiempo real (Live Preview) sin sacrificar la velocidad ni la seguridad.

---

## 🏛 Estructura del Proyecto
```bash
dia-18-markdown-to-html/
├── MarkdownParser.php # Motor lógico (Regex Engine)
├── index.php         # Interfaz Split-View + AJAX
└── README.md         # Documentación técnica
```

---

## 🚀 Ingeniería del Motor (Regex Engine)
A diferencia de usar librerías de terceros (como Parsedown), este proyecto implementa un parser propio basado en expresiones regulares (`preg_replace`) para optimizar el rendimiento y entender el core del procesamiento de texto:

- **Estructuras Soportadas:**
  - `Header 1-3`: `#`, `##`, `###`.
  - `Enfasis`: Negritas (`**`) y Cursivas (`*`).
  - `Code Blocks`: Soporte para bloques multilinea con ``` y código inline con `.
  - `Hipervínculos`: `[Texto](URL)`.
  - `Listas`: Generación automática de `<ul>` y `<li>`.
- **Seguridad (XSS Mitigation):** El parser escapa todo el HTML del usuario antes de aplicar las reglas de transformación, asegurando que solo los tags generados por nuestro sistema sean renderizados por el navegador.

---

## 🎨 Interfaz de Usuario (UX/UI)
- **Split-View / Side-by-Side:** Inspirado en editores de código modernos, permite ver el resultado mientras se redacta.
- **Debounced AJAX:** El sistema espera 150ms después de que el usuario deja de escribir para enviar la petición al servidor, ahorrando recursos y ofreciendo una experiencia fluida.
- **Tipografía Técnica:** 
  - **Editor:** `JetBrains Mono` para mayor claridad en el código.
  - **Preview:** `Outfit` con estilos "Doc-Mode" (bordes sutiles, espaciado generoso, colores curados).

---

## 💻 Stack Tecnológico
- **PHP 8.5+**: Clases *readonly*, tipado estricto y manejo de buffers.
- **JavaScript (Fetch API)**: Manejo de asincronía para el renderizado vivo.
- **Tailwind CSS**: Estilización industrial y responsiva.

---

## 📋 Instrucciones de Uso
1. Escribir sintaxis Markdown en el panel de la izquierda.
2. Observar el renderizado automático a la derecha.
3. Puedes probar tablas, listas y bloques de código complejos.

---
**MASTERCLASS PHP 8.5 // BY CHOKE**
