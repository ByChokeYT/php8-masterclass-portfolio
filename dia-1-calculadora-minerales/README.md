# Día 01 - Calculadora de Minerales

Este es el **Proyecto 1** de la serie de 50 proyectos en PHP (Fase 1 adaptada a GUI). Consiste en una calculadora moderna para liquidar el pago de minerales como Estaño, Zinc y Plata, tomando en cuenta factores reales de mercado como el peso bruto, la cotización y la **pureza o ley** del mineral.

## ✨ Características (PHP 8.5.3)

*   **Tipado Estricto:** Declaración `declare(strict_types=1);` en todos los archivos.
*   **Enums (PHP 8.1+):** Uso de una enumeración `MineralType` para listar los minerales permitidos, devolviendo strings, emojis y símbolos químicos con `match()`.
*   **Readonly Classes (PHP 8.2+):** Data Transfer Object (`Liquidacion`) inmutable para asegurar la integridad de los datos en memoria.
*   **Expresión Match (PHP 8.0+):** Lógica de cálculo centralizada manejando condiciones complejas o descuentos por impurezas según el mineral elegido.
*   **Diseño Premium UI/UX:** Interfaz web *Glassmorphism* usando variables CSS modernas y el patrón de diseño PRG (Post/Redirect/Get) junto con variables de sesión Flash para manejar de manera limpia el recargo de páginas en PHP.

## 📂 Estructura del Proyecto (PSR)

```text
01-calculadora-minerales/
├── public/                 # Document Root para el servidor web
│   ├── css/
│   │   └── style.css       # Hoja de estilos premium Glassmorphism
│   └── index.php           # Front Controller y Vista HTML (Formulario)
├── src/                    # Lógica del negocio (Backend puro)
│   ├── DTO/
│   │   └── Liquidacion.php # Clase inmutable (readonly) que porta datos
│   ├── Enums/
│   │   └── MineralType.php # Constantes tipadas de minerales
│   └── Services/
│       └── CalculatorService.php # Servicio matemático para liquidar totales
├── calculadora.php         # (Opcional) Script versión CLI que creamos antes
└── README.md               # Esta documentación
```

## 🚀 Cómo Ejecutar (Servidor Local)

Para ver la aplicación web funcionando con todo su diseño, levanta el servidor integrado de PHP apuntando a la carpeta `public` en el puerto `8001`:

```bash
cd 01-calculadora-minerales
php -S localhost:8001 -t public/
```

Luego, abre tu navegador y visita: [http://localhost:8001](http://localhost:8001)
