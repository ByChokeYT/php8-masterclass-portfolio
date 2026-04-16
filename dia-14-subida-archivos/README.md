# 🏁 Proyecto 14: Terminal de Carga Segura
> **Integrity_Guard v14 | Validación MIME Real & PHP 8.5 Inmutable**

![Demo del Proyecto](./public/img/demo.png)

## 🏗️ Concepto
Este proyecto implementa una terminal de seguridad para la carga de archivos, diseñada bajo una estética **Ultra Compacta**. A diferencia de los sistemas de carga convencionales, esta herramienta realiza un análisis de integridad a nivel de servidor para garantizar que solo archivos legítimos entren en la red de almacenamiento.

## 🚀 Características Técnicas
- **Análisis de Integridad MIME**: Uso de la extensión `finfo` de PHP para verificar el tipo real de contenido, ignorando extensiones de archivo manipuladas.
- **Protocolo de Sanitización**: Renombrado automático mediante hashes criptográficos (`random_bytes`) para neutralizar ataques de inyección de rutas.
- **Control de Cuota Estricto**: Filtros de tamaño máximo (2MB) procesados en el pre-vuelo de carga.
- **Manifiesto de Nodo**: Registro persistente en JSON (`manifest.json`) para la gestión ligera de metadatos de la galería.

## 🐘 PHP 8.5 Masterclass Features
- ✅ `readonly class`: Para encapsular la metadata de `FileRecord` de forma inmutable.
- ✅ **Match Expression**: Gestión elegante y declarativa de los códigos de error del protocolo `$_FILES`.
- ✅ **Strict Types**: Garantía de integridad en el flujo de datos del `SecurityService`.
- ✅ **Constructor Promotion**: Código minimalista y técnico alineado con estándares modernos.

## 🎨 Filosofía de Diseño: "Pocket Industrial"
- **Formato 100vh**: Interfaz optimizada para resoluciones estándar sin necesidad de scroll.
- **Dropzone con Escaneo**: Zona interactiva que utiliza una línea de escaneo láser animada para denotar procesos de validación.
- **Estética PHP Premium**: Paleta oficial de PHP con efectos de Glassmorphism industrial y tipografía técnica.

## 🛠️ Cómo Ejecutar
1. Navega a la carpeta del proyecto:
   ```bash
   cd dia-14-subida-archivos
   ```
2. Inicia el servidor de desarrollo:
   ```bash
   php -S localhost:8014 -t public
   ```
3. Accede a: `http://localhost:8014`

---
**php8-masterclass-portfolio** • *Blindando la infraestructura paso a paso.*
