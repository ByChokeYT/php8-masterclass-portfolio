# DÍA 38 // AUTH SYSTEM STUDIO 🔐

Este proyecto implementa un sistema de autenticación completo, demostrando la diferencia entre **Sesiones** (lado del servidor) y **Cookies** (lado del cliente).

## 🚀 Objetivo del Proyecto
Dominar el manejo de estados persistentes y seguros, integrando cifrado de contraseñas con BCRYPT y control de acceso a áreas protegidas.

## 🛠️ Tecnologías Aplicadas
- **Sessions PHP**: Almacenamiento seguro de datos del usuario en el servidor.
- **Cookies**: Persistencia del nombre de usuario en el navegador para mejorar la experiencia (UX).
- **BCRYPT Hashing**: Uso de `password_hash` y `password_verify` para manejar contraseñas de forma segura.
- **SQLite 3**: Almacenamiento de usuarios con manejo de integridad.

## 📂 Estructura de Carpetas
```text
dia-38-login-sesiones/
├── database/               # Seguridad de datos
│   └── auth.db             # Base de datos SQLite
├── public/                 # Vistas
│   ├── assets/
│   │   └── css/
│   │       └── style.css   # Estilo Dark Premium
│   ├── index.php           # Formulario de Login
│   ├── dashboard.php       # Área Protegida
│   └── logout.php          # Cierre de sesión
├── src/                    # Lógica de Autenticación
│   └── Services/
│       └── AuthService.php # Manejo de Auth y Sesiones
├── vendor/                 # Autoloading
├── composer.json           # Configuración PSR-4
└── README.md
```

## ⚙️ Características
1. **Acceso Protegido**: Si intentas entrar al dashboard sin loguearte, el sistema te redirigirá automáticamente al login.
2. **Encriptación de Contraseñas**: Las contraseñas nunca se guardan en texto plano.
3. **Persistencia de Cookies**: El sistema recuerda tu último nombre de usuario incluso después de cerrar el navegador.
4. **Manejo de Errores**: Feedback visual en tiempo real para credenciales incorrectas.

## 🔧 Credenciales por Defecto
- **Usuario**: `admin`
- **Contraseña**: `php85`

## 🔨 Ejecución
1. Iniciar servidor:
   ```bash
   php -S localhost:8038 -t public/
   ```

---
**Desarrollado por ByChoke**  
*Masterclass PHP 8.5 - Node 38 // Fase 4*
