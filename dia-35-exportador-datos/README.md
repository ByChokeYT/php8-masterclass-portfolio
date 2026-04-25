# DÍA 35 // DATA EXPORTER STUDIO 📊

Este proyecto aborda una de las necesidades más comunes en aplicaciones empresariales: la exportación de datos para análisis externo en herramientas como Microsoft Excel o Google Sheets.

## 🚀 Objetivo del Proyecto
Implementar un sistema de exportación robusto utilizando la librería **PhpSpreadsheet**, dominando la manipulación de cabeceras HTTP para la descarga de archivos binarios y tabulares.

## 🛠️ Tecnologías Aplicadas
- **PhpSpreadsheet v2.4**: La librería estándar para manipulación de hojas de cálculo en PHP.
- **Buffers de Salida**: Uso de `php://output` para transmitir datos directamente al navegador.
- **Multi-Format Export**: Soporte nativo para XLSX (Excel Moderno) y CSV (Valores separados por comas).
- **UTF-8 BOM**: Implementación de marcas de orden de bytes para asegurar la compatibilidad de caracteres especiales en Excel.

## 📂 Estructura de Carpetas
```text
dia-35-exportador-datos/
├── public/                 # Interfaz de previsualización
│   ├── assets/
│   │   └── css/
│   │       └── style.css   # Estilo Dark Industrial
│   └── index.php           # Vista de reporte y triggers
├── src/                    # Lógica de Exportación
│   └── Services/
│       └── ExportService.php # Motor de PhpSpreadsheet
├── vendor/                 # Dependencias externas
├── composer.json           # Dependencias
└── README.md
```

## ⚙️ Características
1. **Previsualización de Datos**: Tabla elegante que muestra los datos antes de ser exportados.
2. **Exportación XLSX**: Genera archivos Excel con estilos (negritas, auto-ajuste de columnas).
3. **Exportación CSV**: Genera archivos ligeros compatibles con cualquier sistema.
4. **Contexto Regional**: Reporte simulado de producción minera (Mina Huanuni, Colquiri, etc.).

## 🔧 Ejecución
1. Instalar dependencias:
   ```bash
   composer install
   ```
2. Iniciar servidor:
   ```bash
   php -S localhost:8035 -t public/
   ```

---
**Desarrollado por ByChoke**  
*Masterclass PHP 8.5 - Node 35 // Fase 4*
