# DÍA 32 // ORURO WEATHER SCRAPER 🌦️

Bienvenido al proyecto del **Día 32** de la Masterclass PHP 8.5. En este reto, hemos construido un scraper/consumidor de API robusto para obtener el clima de la ciudad de Oruro, Bolivia, aplicando técnicas modernas de desarrollo backend y un diseño frontend de alto nivel.

## 🚀 Objetivo del Proyecto
Aprender a consumir servicios REST externos utilizando la librería **cURL** de PHP, manejar respuestas JSON de forma segura y estructurar el código siguiendo el estándar **PSR-4** para carga automática de clases.

## 🛠️ Tecnologías Aplicadas
- **PHP 8.5.3**: Uso de clases `readonly`, tipado estricto (`declare(strict_types=1)`) y constantes de enumeración implícitas.
- **cURL**: Motor de peticiones HTTP para comunicación con servidores externos.
- **Open-Meteo API**: Proveedor de datos meteorológicos de código abierto (sin necesidad de API Key).
- **Composer**: Gestión de dependencias y Autoloading.
- **Glassmorphism UI**: Diseño basado en transparencias, desenfoques y gradientes modernos.

## 📂 Estructura de Carpetas
```text
dia-32-scraper-clima-oruro/
├── public/                 # Punto de entrada web
│   ├── assets/
│   │   └── css/
│   │       └── style.css   # Estilos premium (Glassmorphism)
│   └── index.php           # Controlador frontal y renderizado
├── src/                    # Código fuente (App Namespace)
│   └── Services/
│       └── WeatherService.php # Lógica de conexión con la API
├── vendor/                 # Autocarga de Composer (Generado)
├── composer.json           # Definición de PSR-4 Autoload
└── README.md               # Documentación del proyecto
```

## ⚙️ Características Técnicas
1. **WeatherService.php**:
   - Clase `readonly` para inmutabilidad.
   - Manejo de excepciones en caso de fallo de conexión.
   - Mapeo de códigos WMO (World Meteorological Organization) a etiquetas amigables e íconos de Phosphor.
2. **Frontend**:
   - Diseño responsivo adaptado a móviles.
   - Íconos dinámicos según el estado del cielo (Sol, Nubes, Lluvia, etc.).
   - Visualización de datos clave: Temperatura, Humedad, Velocidad del Viento, Nubes y Presión Atmosférica.

## 🔧 Instalación y Ejecución
Si deseas correr este proyecto localmente:

1. Asegúrate de tener Composer instalado.
2. Genera el autoload:
   ```bash
   composer dump-autoload
   ```
3. Inicia el servidor de PHP:
   ```bash
   php -S localhost:8032 -t public/
   ```
4. Abre tu navegador en: `http://localhost:8032`

---
**Desarrollado por ByChoke**  
*Masterclass PHP 8.5 - Node 32 // Fase 4*
