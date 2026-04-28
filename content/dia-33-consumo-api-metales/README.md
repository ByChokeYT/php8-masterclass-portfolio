# DÍA 33 // METAL MARKET TERMINAL 📈

Este proyecto es la continuación de la **Fase 4** (APIs y Arquitectura Moderna). Hemos construido una terminal financiera que monitorea la cotización de metales preciosos e industriales, con un enfoque especial en los metales de exportación de Oruro (Estaño y Zinc).

## 🚀 Objetivo del Proyecto
Implementar un sistema de monitoreo de datos volátiles usando el patrón **Service Provider**. Se simula la integración con una API financiera real, demostrando cómo manejar datos en tiempo real y presentarlos en una interfaz tipo "Trading Terminal".

## 🛠️ Tecnologías Aplicadas
- **Pattern Service Provider**: Desacoplamiento total entre la fuente de datos (API) y la interfaz.
- **PHP 8.5 Dynamic Logic**: Simulación de fluctuaciones de mercado mediante funciones anónimas y lógica matemática.
- **JetBrains Mono**: Tipografía diseñada para legibilidad técnica y de datos.
- **Neon-Trading UI**: Interfaz oscura con indicadores de tendencia (Bullish/Bearish).

## 📂 Estructura de Carpetas
```text
dia-33-consumo-api-metales/
├── public/                 # Punto de entrada
│   ├── assets/
│   │   └── css/
│   │       └── style.css   # Estilo Terminal Financiera
│   └── index.php           # Dashboard de Metales
├── src/                    # App Logic
│   └── Services/
│       └── MetalService.php # Abstracción de la API de Metales
├── composer.json           # Autoloading
└── README.md
```

## ⚙️ Características
1. **Cotizaciones en Vivo**: Datos de Oro (XAU), Plata (XAG), Estaño (TIN), Zinc (ZNC) y Cobre (CU).
2. **Tendencias Dinámicas**: Indicadores visuales de subida o bajada de precios.
3. **Unidades de Medida**: Conversión automática entre Onzas Troy y Toneladas Métricas.
4. **Arquitectura Escalable**: Preparado para conectar una API Key real con un cambio mínimo de código.

## 🔧 Ejecución
1. Generar autoload:
   ```bash
   composer dump-autoload
   ```
2. Iniciar servidor:
   ```bash
   php -S localhost:8033 -t public/
   ```

---
**Desarrollado por ByChoke**  
*Masterclass PHP 8.5 - Node 33 // Fase 4*
