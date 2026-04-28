# ⛏️ DÍA 23: Inventario de Minerales Transaccional

En este reto de la **Fase 3**, dejamos de simplemente "guardar datos" y empezamos a hablar de **Integridad Atómica**. Implementamos un sistema de logística minera para Estaño, Zinc y Plata.

## 🎯 Objetivo de la Lección
Dominar las **Transacciones SQL** en PDO para asegurar que los cambios complejos en la base de datos se realicen de forma "todo o nada".

## 🛠️ ¿Qué es una Transacción?
En este proyecto, cuando registras una salida de mineral ocurren dos cosas:
1. Se resta la cantidad del stock en la tabla `minerals`.
2. Se inserta un registro en `inventory_logs`.

**El problema:** Si el paso 1 funciona pero el 2 falla, habremos perdido mineral "fantasma".
**La solución:** Usamos `beginTransaction()`, `commit()` y `rollBack()`. Si cualquier paso falla, PHP deshace todos los cambios realizados desde el inicio de la transacción.

## 🏗️ Características Técnicas
- **ACID Básico**: Aplicando atomicidad y consistencia.
- **Validación de Stock**: El sistema impide registros de salida que resulten en stock negativo, lanzando una excepción y revirtiendo la transacción mediante un Rollback.
- **Dashboard Industrial**: Interfaz premium diseñada con temática minera, separando el estado actual (Stock) de la auditoría historial.

## 📁 Estructura
```text
dia-23-inventario-minerales/
├── data/
│   ├── schema.sql           # Tablas y semillas (Sn, Zn, Ag)
│   └── mineria_transaccional.sqlite
├── public/
│   ├── assets/css/style.css # Diseño Industrial/Premium
│   └── index.php            # Dashboard y Controlador
└── src/
    ├── Config/
    │   └── DatabaseConfig.php
    ├── DatabaseHost.php
    └── InventoryManager.php # LÓGICA TRANSACCIONAL ATÓMICA
```

## 🚀 Cómo Ejecutar
1. Inicia el servidor:
   ```bash
   php -S localhost:8023 -t dia-23-inventario-minerales/public
   ```
2. Accede a [http://localhost:8023](http://localhost:8023) o a través del **Portal Masterclass** en [http://localhost:8000](http://localhost:8000).

---
**MASTERCLASS PHP // BY CHOKE**
*Garantizando la integridad de cada gramo de datos.*
