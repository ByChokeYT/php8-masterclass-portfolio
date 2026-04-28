# DÍA 37 // URL SHORTY STUDIO 🔗

Este proyecto implementa un acortador de URLs propio, demostrando el uso de bases de datos embebidas (SQLite) y el manejo de redirecciones HTTP mediante cabeceras del servidor.

## 🚀 Objetivo del Proyecto
Crear un sistema funcional para transformar URLs largas en códigos cortos únicos, rastreando el número de clics y gestionando la redirección automática.

## 🛠️ Tecnologías Aplicadas
- **SQLite 3**: Base de datos ligera sin necesidad de servidor externo.
- **PDO (PHP Data Objects)**: Acceso seguro a datos con sentencias preparadas.
- **Función `header()`**: Redirección HTTP 302 para enviar al usuario a su destino final.
- **Hashing**: Generación de códigos únicos de 6 caracteres usando `md5` y `uniqid`.

## 📂 Estructura de Carpetas
```text
dia-37-acortador-url/
├── database/               # Almacenamiento de URLs
│   └── urls.db             # Archivo SQLite
├── public/                 # Interfaz de usuario
│   ├── assets/
│   │   └── css/
│   │       └── style.css   # Estilo Dark + PHP Colors
│   ├── index.php           # Generador de enlaces
│   └── go.php              # Script de redirección
├── src/                    # Lógica de Negocio
│   └── Services/
│       └── UrlService.php  # CRUD y lógica de acortamiento
├── vendor/                 # Autoloading
├── composer.json           # Configuración PSR-4
└── README.md
```

## ⚙️ Características
1. **Generación Instantánea**: Convierte cualquier URL válida en un código de 6 caracteres.
2. **Contador de Clics**: Incrementa automáticamente el contador cada vez que se usa un enlace corto.
3. **Persistencia**: Los enlaces no se pierden al reiniciar el servidor gracias a SQLite.
4. **Previsualización de Stats**: Lista de los últimos 5 enlaces generados con su tráfico.

## 🔧 Ejecución
1. Iniciar servidor:
   ```bash
   php -S localhost:8037 -t public/
   ```

---
**Desarrollado por ByChoke**  
*Masterclass PHP 8.5 - Node 37 // Fase 4*
