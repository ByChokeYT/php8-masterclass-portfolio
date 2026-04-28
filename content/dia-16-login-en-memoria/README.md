# DÍA 16: LOGIN EN MEMORIA (STATEFUL AUTH)

## 🛠 Consigna
Implementación de un sistema de autenticación basado puramente en el estado de sesión de PHP (`$_SESSION`), prescindiendo de bases de datos externas. El objetivo es dominar la persistencia de datos en memoria y la protección de rutas mediante lógica de servidor.

---

## 🏛 Estructura del Proyecto
```bash
dia-16-login-en-memoria/
├── index.php        # Lógica central (Login, Logout, Dashboard y UI)
└── README.md        # Documentación técnica del proyecto
```

---

## 🚀 Lógica Funcional
- **Persistencia Nativa:** Utiliza el manejador de sesiones de PHP para identificar al cliente de forma única durante su navegación.
- **Seguridad en Memoria:**
  - `session_start()`: Inicialización del buffer de memoria.
  - `session_regenerate_id()`: Mitigación de ataques de fijación de sesión.
  - `session_destroy()`: Limpieza total de huella en el servidor.
- **Credenciales Hardcoded:** Autenticación directa mediante constantes para simular una verificación de identidad rápida.

---

## 🎨 Diseño Industrial (Micro-Surgical UI)
Fiel a la estética del **Terminal Hub**, este módulo presenta:
- **Formato Ultra-Compacto:** Interfaz optimizada para pantallas pequeñas (280px), enfocada en la eficiencia visual.
- **Glassmorphism Industrial:** Paneles translúcidos con desenfoque de fondo y bordes quirúrgicos.
- **Micro-Animaciones:** Secuencia de arranque (System Boot) y estados de carga animados con Tailwind CSS.
- **Iconografía Phosphor:** Iconos vectoriales para una experiencia táctil y profesional.

---

## 💻 Stack Tecnológico
- **PHP 8.5+**: Tipado estricto (`strict_types=1`) y lógica de servidor.
- **Tailwind CSS**: Framework de utilidades para el diseño premium.
- **Phosphor Icons**: Librería de iconos industriales.

---

## 📋 Instrucciones de Uso
1. Acceder a `/dia-16-login-en-memoria/index.php`.
2. Ingresar las credenciales de prueba:
   - **Usuario:** `admin`
   - **Password:** `master85`
3. Explorar el **Panel de Control** para verificar la persistencia y los metadatos de sesión.
4. Cerrar sesión para limpiar la memoria del servidor.

---
**MASTERCLASS PHP 8.5 // BY CHOKE**
