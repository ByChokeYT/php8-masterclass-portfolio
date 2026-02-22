```
╔══════════════════════════════════════════════════════════════╗
║                                                              ║
║       📧  EMAIL VALIDATOR PRO  📧                           ║
║                                                              ║
║           [ SYSTEM ONLINE ]                                  ║
║           [ DNS CHECKING ENABLED ]                           ║
║                                                              ║
║           PHP 8.5 • Cyber Security Tool                      ║
║           Proyecto 09                                        ║
║                                                              ║
╚══════════════════════════════════════════════════════════════╝
```

# 09 Validador de Email | PHP 8.5

> **Herramienta de Verificación de Correo Electrónico**
> Valida sintaxis y registros DNS MX reales para confirmar la existencia del dominio.

## 🛡️ Descripción

El **Email Validator** es una herramienta técnica diseñada con estética "Cyber Security" para validar direcciones de correo electrónico en dos niveles:
1. **Validación de Sintaxis:** ¿Tiene el formato correcto? (RFC 822)
2. **Validación de Dominio (DNS):** ¿Tiene el dominio registros MX válidos?

---

## 🚀 Características

### Motor de Validación (`EmailValidator` Class)
- **Filtros Nativos:** Uso de `filter_var()` para validación robusta.
- **Check DNS:** Uso de `checkdnsrr()` para consultar servidores DNS reales.
- **Parsing:** Desglose del correo en usuario y dominio.

### Interfaz "Hacker"
- **Tema Terminal:** Estética de consola de comandos (Verde/Negro).
- **Tipografía Monospace:** `JetBrains Mono` para look de código.
- **Feedback Visual:**
  - ✅ **PASSED:** Sintaxis correcta y dominio activo.
  - ⚠️ **WARNING:** Formato válido pero dominio inactivo/sin correo.
  - ❌ **FAILED:** Formato incorrecto.

---

## ⚡ Cómo Usar

### Iniciar el servidor
```bash
cd 09_validador_email
php -S localhost:8086 -t public
```

### Acceder a la herramienta
Visita: **http://localhost:8086**

### Interpretación de Resultados
| Estado | Icono | Descripción |
|--------|-------|-------------|
| **Valid** | ✅ | Correo seguro para enviar. El dominio existe y recibe correos. |
| **Warning**| ⚠️ | El formato es correcto, pero el dominio no tiene registros MX. Probablemente rebotará. |
| **Invalid**| ❌ | El texto ingresado no es un correo electrónico. |

---

## 🛠️ Stack Tecnológico

- **PHP 8.5:** Types, `readonly` attributes (simulado), Strict Types.
- **DNS Functions:** `checkdnsrr($domain, 'MX')`.
- **Frontend:** CSS puro con diseño estilo Terminal.

---

## 📁 Estructura

```
09_validador_email/
├── public/
│   └── index.php           # Interfaz Web "Terminal Style"
├── src/
│   └── Classes/
│       └── EmailValidator.php  # Lógica de Validación
└── README.md
```

---

**php8-masterclass-portfolio • Proyecto 09**  
*Validación Técnica & Diseño Cyberpunk*
