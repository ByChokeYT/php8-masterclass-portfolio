# Día 24: Sistema de Registro Seguro (Criptografía Básica en PHP)

Este proyecto forma parte de la **Fase 3** del Roadmap de 50 Días de PHP (Manejo de Formularios y Bases de Datos). Introduce los conceptos fundamentales de seguridad web y almacenamiento criptográfico utilizando la API nativa de PHP.

## 🎯 Objetivos de Aprendizaje

- **Almacenamiento Criptográfico Inquebrantable**: Uso de `password_hash()` con los algoritmos modernos nativos (Bcrypt) y gestión automática del Salt.
- **Validación Anti-Timing Attacks**: Uso seguro de `password_verify()` para cotejar cadenas sin exponer datos críticos en tiempos de procesador.
- **Flujo Bi-Direccional (PRG)**: Mantener el estado de la UI (Dual Login/Registro) con persistencia temporal vía `$_SESSION` y el patrón *Post/Redirect/Get* para evitar reenvíos de formulario y registros fantasma.
- **Diseño Glassmorphism Dual**: Implementación UI Premium usando variables CSS, desenfoque de fondo y un grid dinámico adaptable.

## 🛠️ Stack Tecnológico

- **Backend**: PHP 8.2+
- **Database**: SQLite (vía PDO)
- **Frontend**: HTML5 Semántico + Vanilla CSS 3
- **Estructura**: OOP (Object-Oriented Programming) separando la lógica en `AuthManager.php`.

## 🚀 Cómo Ejecutar el Proyecto

1. Asegúrate de estar en el directorio raíz del proyecto 24:
   ```bash
   cd dia-24-registro-seguro
   ```
2. Levanta el servidor local de PHP apuntando a la carpeta `public`:
   ```bash
   php -S localhost:8024 -t public
   ```
3. Visita [http://localhost:8024](http://localhost:8024) en tu navegador.
   *(La base de datos SQLite se generará automáticamente en la carpeta `data/` al primer arranque)*.

## 🛡️ Detalles de Seguridad

- ¡Ninguna contraseña toca la base de datos en texto plano!
- Durante el registro, las claves cortas o correos inválidos se filtran con validación estricta usando `filter_var()`.
- Los fallos en el Login lanzan un mensaje genérico *"Credenciales incorrectas"*, sin aclarar al atacante si atinó el mail o la contraseña en sus intentos.
