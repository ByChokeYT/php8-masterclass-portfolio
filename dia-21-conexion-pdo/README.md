# 🛠️ DÍA 21: Clase de Conexión PDO Inmutable

¡Bienvenidos a la **Fase 3: Persistencia de Datos**! En este reto, abandonamos los datos volátiles y entramos en el mundo de las bases de datos relacionales utilizando **PDO (PHP Data Objects)**.

El objetivo de este ejercicio es construir una base arquitectónica ultra-segura utilizando las capacidades más avanzadas de **PHP 8.5**.

## 🎯 Objetivo de la Lección
Aprender a gestionar credenciales de base de datos de forma profesional, garantizando que la configuración sea inalterable post-instanciación y que los datos sensibles no se filtren en logs de errores.

## 🏗️ Estructura del Proyecto

```text
dia-21-conexion-pdo/
├── data/               # Almacenamiento físico de la DB (SQLite)
├── public/             # Punto de entrada web (Assets + index.php)
│   ├── assets/css/     # Estilos Premium (Glassmorphism)
│   └── index.php       # Dashboard de prueba
└── src/                # Lógica de Negocio (Backend)
    ├── Config/
    │   └── DatabaseConfig.php  # Clase Readonly de configuración
    └── DatabaseHost.php        # Gestor de conexión PDO
```

## 🔐 Conceptos de "Máxima Seguridad" Aplicados

### 1. Inmutabilidad con `readonly class`
En PHP moderno, declarar una clase como `readonly` asegura que todas sus propiedades sean inmutables. 
```php
readonly class DatabaseConfig { ... }
```
**Para el alumno:** Esto evita que cualquier parte del código intente cambiar el host o el password de la base de datos después de haber sido configurada.

### 2. Protección de Datos con `#[\SensitiveParameter]`
Hemos marcado `$username` y `$password` con este atributo de PHP.
**¿Por qué?** Si tu código falla y se muestra un error en pantalla (stack trace), PHP **redactará automáticamente** estos valores. Verás algo como `SensitiveParameterValue object` en lugar de tu contraseña real. ¡Seguridad de nivel bancario!

### 3. Patrón de Diseño para Conexiones
La clase `DatabaseHost` se encarga de:
- Construir el **DSN** (Data Source Name) correcto.
- Manejar excepciones de `PDOException` para no exponer detalles internos del servidor.
- Verificar el estado del túnel de datos.

## 🚀 Cómo Ejecutarlo
1. Asegúrate de tener **PHP 8.5.2+** instalado.
2. Navega a la carpeta raíz del proyecto.
3. Inicia el servidor:
   ```bash
   php -S localhost:8021 -t dia-21-conexion-pdo/public
   ```
4. Abre [http://localhost:8021](http://localhost:8021) en tu navegador.

---
**MASTERCLASS PHP // BY CHOKE**
*Transformando programadores en arquitectos de software.*
