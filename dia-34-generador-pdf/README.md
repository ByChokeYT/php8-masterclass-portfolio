# DÍA 34 // PDF INVOICE STUDIO 📄

Este proyecto implementa un motor de generación de documentos PDF profesionales, una habilidad crítica para cualquier desarrollador backend que trabaje con sistemas de gestión, e-commerce o facturación.

## 🚀 Objetivo del Proyecto
Dominar la librería **Dompdf** para convertir plantillas HTML5 y CSS en documentos PDF de alta calidad, listos para impresión y cumplimiento legal.

## 🛠️ Tecnologías Aplicadas
- **Dompdf v3.0**: Motor de renderizado líder para PHP.
- **HTML5 & Inline CSS**: Técnicas de maquetación optimizadas para conversores PDF.
- **Service Layer Pattern**: Lógica de generación encapsulada en `InvoiceService.php`.
- **Composer Automation**: Gestión de dependencias y fuentes.

## 📂 Estructura de Carpetas
```text
dia-34-generador-pdf/
├── public/                 # Interfaz de usuario
│   ├── assets/
│   │   └── css/
│   │       └── style.css   # Estilos del Dashboard
│   └── index.php           # Formulario y Trigger de PDF
├── src/                    # Lógica de Negocio
│   └── Services/
│       └── InvoiceService.php # Motor de renderizado PDF
├── vendor/                 # Librerías (Dompdf, etc.)
├── composer.json           # Dependencias
└── README.md
```

## ⚙️ Características
1. **Formulario Dinámico**: Ingreso de datos del cliente y detalles de productos.
2. **Plantilla Profesional**: Diseño de factura limpia con cabecera, tabla de ítems, cálculo de IVA (13%) y totales.
3. **Stream Directo**: El PDF se genera al vuelo y se envía al navegador sin necesidad de guardar archivos temporales en el servidor.
4. **Validación de Datos**: Procesamiento seguro de los inputs de formulario.

## 🔧 Ejecución
1. Instalar dependencias:
   ```bash
   composer install
   ```
2. Iniciar servidor:
   ```bash
   php -S localhost:8034 -t public/
   ```

---
**Desarrollado por ByChoke**  
*Masterclass PHP 8.5 - Node 34 // Fase 4*
