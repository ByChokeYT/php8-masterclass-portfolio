# DÍA 20: ENCUESTA VISUAL CON PERSISTENCIA

## 🛠 Consigna
Desarrollar un sistema de votación interactivo que persista los datos en un archivo de texto plano (`.txt`) y muestre los resultados mediante analíticas visuales (barras de progreso) en tiempo real. Este proyecto marca el cierre de la Fase 2, consolidando el manejo de archivos y la interactividad asíncrona.

---

## 🏛 Estructura del Proyecto
```bash
dia-20-encuesta-visual/
├── src/
│   └── SurveyManager.php # Lógica de persistencia y cálculos
├── votes.txt            # Almacenamiento plano (JSON format)
├── index.php            # Interfaz Industrial + AJAX logic
└── README.md            # Documentación técnica
```

---

## 🚀 Ingeniería de Persistencia
A diferencia de los proyectos anteriores que usaban la sesión, este módulo implementa una persistencia real y compartida:

- **SurveyManager.php:** Clase encargada de centralizar la lectura y escritura del archivo `votes.txt`.
- **Atomic Operations (flock):** Se utiliza el bloqueo de archivos (`LOCK_EX`) durante la escritura para evitar la corrupción de datos en caso de votos simultáneos.
- **Data Normalization:** Los votos se almacenan en formato JSON dentro del archivo para facilitar su posterior expansión a bases de datos relacionales en la Fase 3.

---

## 🎨 Analíticas y UX Industrial
- **Real-Time Progress:** Mediante `Fetch API`, el sistema actualiza los porcentajes y el ancho de las barras de progreso instantáneamente tras cada voto, sin recargar la página.
- **Aesthetic Premium:** 
  - **Identidad Visual:** Esquema de colores "Deep Dark" con acentos en violeta eléctrico (`#8b5cf6`).
  - **Micro-animaciones:** Las barras de progreso utilizan transiciones cúbicas de 1 segundo para un efecto fluido y profesional.
  - **Cards de Opción:** Botones con iconos técnicos y efectos de hover suaves que reaccionan al cursor.

---

## 💻 Stack Tecnológico
- **PHP 8.5+**: Manejo de buffers de archivo y tipado estricto.
- **JavaScript (Vanilla)**: Orquestación de peticiones AJAX y manipulación del DOM.
- **Tailwind CSS**: Estilización de componentes visuales de analítica.

---

## 📋 Instrucciones de Uso
1. Seleccionar un lenguaje de programación haciendo clic en su tarjeta.
2. Observar cómo el contador total y las barras de progreso se sincronizan automáticamente.
3. Puedes recargar la página y verificar que los votos se han persistido correctamente en el servidor.

---
**MASTERCLASS PHP 8.5 // BY CHOKE**
