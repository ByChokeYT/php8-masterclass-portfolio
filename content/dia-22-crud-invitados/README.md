# 📋 DÍA 22: CRUD de Lista de Invitados

En este segundo reto de la **Fase 3**, escalamos nuestra infraestructura PDO para construir un sistema de gestión completo: un **CRUD** (Create, Read, Update, Delete).

## 🎯 Objetivo de la Lección
Implementar una arquitectura de **Repositorio/Manager** en PHP 8.5 para manipular registros en una base de datos real (SQLite) mediante sentencias SQL preparadas, garantizando una interfaz de usuario fluida y profesional.

## 🏗️ Evolución Arquitectónica
A diferencia del Día 21 donde solo conectamos, hoy hemos separado las responsabilidades:
- **`DatabaseHost`**: Sigue encargado únicamente de la conexión.
- **`GuestManager`**: Encargado de la "lógica de persistencia" (los SQL `INSERT`, `SELECT`, etc.).
- **`index.php`**: Encargado de la "lógica de aplicación" (rutas, manejo de POST y renderizado).

## 🚀 Funcionalidades Incluidas
1.  **C (Create)**: Registro de nuevos asistentes con validación básica.
2.  **R (Read)**: Visualización en una tabla premium con orden cronológico inverso.
3.  **U (Update)**: Cambio de estado rápido (botón de confirmación).
4.  **D (Delete)**: Eliminación de registros con confirmación del lado del cliente.

## 📁 Estructura
```text
dia-22-crud-invitados/
├── data/
│   ├── schema.sql           # Estructura de la tabla
│   └── eventos_academia.sqlite # La base de datos (se crea sola)
├── public/
│   ├── assets/css/style.css # Estilos premium del dashboard
│   └── index.php            # Interfaz de usuario y control
└── src/
    ├── Config/
    │   └── DatabaseConfig.php
    ├── DatabaseHost.php
    └── GuestManager.php     # EL CORAZÓN DEL CRUD
```

## 🛠️ Cómo Ejecutar
1. Inicia el servidor:
   ```bash
   php -S localhost:8022 -t dia-22-crud-invitados/public
   ```
2. Accede a [http://localhost:8022](http://localhost:8022).

---
**MASTERCLASS PHP // BY CHOKE**
*Dominando el ciclo de vida de los datos.*
