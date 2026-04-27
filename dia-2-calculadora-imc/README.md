# Día 02 — Calculadora de IMC CLI
## Masterclass PHP 8.5 | Fase 1: Dominio de la Terminal

---

## ¿Qué vas a construir?

Una calculadora de **Índice de Masa Corporal** que corre en la terminal.  
El programa pide peso y altura, calcula el IMC y muestra el resultado con su clasificación médica, recomendación y un indicador visual.

Al terminar este día vas a entender:

- Cómo usar **interfaces** para definir contratos entre clases
- Cómo trabajar con **múltiples Enums** que se relacionan entre sí
- Cómo separar **validación, cálculo y presentación** en capas distintas
- Cómo crear una **barra de progreso visual** en la terminal con PHP puro
- Cómo manejar **dos sistemas de medición** (métrico e imperial) con el mismo código

---

## Conceptos clave antes de empezar

### ¿Qué es una Interface?
Una interface es un **contrato**. Le dice a una clase "si implementas esta interface, obligatoriamente debes tener estos métodos".

```php
// El contrato dice: toda calculadora DEBE tener calcular()
interface CalculadoraInterface {
    public function calcular(): float;
}

// Esta clase FIRMA el contrato — si no implementa calcular(), PHP da error
class ImcCalculator implements CalculadoraInterface {
    public function calcular(): float { ... }
}
```

### ¿Por qué separar validación de cálculo?
```php
// ❌ Mal — todo mezclado en un solo lugar
function calcularImc($peso, $altura) {
    if ($peso <= 0) die("Error");       // validación
    $imc = $peso / ($altura ** 2);      // cálculo
    echo "Tu IMC es: $imc";             // presentación
}

// ✅ Bien — cada cosa en su lugar
// Liquidacion.php    → valida los datos
// CalculatorService  → hace el cálculo
// main.php           → muestra los resultados
```

### ¿Qué es el IMC?
El Índice de Masa Corporal es una fórmula simple para estimar si el peso de una persona es saludable en relación a su altura.

```
IMC = peso (kg) / altura² (m)

Ejemplo: 70 kg / (1.75 × 1.75) = 22.86
```

---

## Estructura del proyecto

```
dia-02-calculadora-imc/
├── main.php                        ← Menú CLI y presentación
└── src/
    ├── Contracts/
    │   └── CalculadoraInterface.php ← Contrato que deben cumplir las calculadoras
    ├── Enums/
    │   ├── SistemaUnidad.php        ← Métrico o Imperial
    │   └── ClasificacionImc.php     ← Bajo peso, Normal, Sobrepeso, etc.
    ├── DTO/
    │   └── MedicionCorporal.php     ← Datos del usuario (peso + altura)
    └── Services/
        └── ImcCalculatorService.php ← Lógica de cálculo
```

---

## Paso 1 — Prepara la carpeta

```bash
mkdir dia-02-calculadora-imc
cd dia-02-calculadora-imc
mkdir src src/Contracts src/Enums src/DTO src/Services
```

---

## Paso 2 — Crea los archivos

### `src/Contracts/CalculadoraInterface.php`

```php
<?php

declare(strict_types=1);

namespace App\Contracts;

/**
 * Contrato para cualquier calculadora del sistema.
 *
 * Ventaja: si mañana creas ImcCalculatorV2 o una calculadora distinta,
 * PHP te obliga a implementar estos métodos. No puedes olvidarlos.
 */
interface CalculadoraInterface
{
    /**
     * Ejecuta el cálculo principal y devuelve el resultado.
     */
    public function calcular(): float;

    /**
     * Devuelve un array con todos los detalles del resultado.
     *
     * @return array<string, mixed>
     */
    public function getResultado(): array;
}
```

**¿Qué aprendes aquí?**
- Las interfaces solo declaran métodos — nunca tienen código dentro
- Sirven para garantizar que distintas clases tengan la misma "forma"
- El `@return array<string, mixed>` es un docblock tipado — buena práctica profesional

---

### `src/Enums/SistemaUnidad.php`

```php
<?php

declare(strict_types=1);

namespace App\Enums;

/**
 * Sistema de medición del usuario.
 * Métrico  → kg y metros (estándar internacional)
 * Imperial → libras y pies (usado en USA)
 */
enum SistemaUnidad: string
{
    case METRICO   = 'Métrico';
    case IMPERIAL  = 'Imperial';

    public function getUnidadPeso(): string
    {
        return match($this) {
            self::METRICO  => 'kg',
            self::IMPERIAL => 'lbs',
        };
    }

    public function getUnidadAltura(): string
    {
        return match($this) {
            self::METRICO  => 'm',
            self::IMPERIAL => 'ft',
        };
    }

    public function getDescripcion(): string
    {
        return match($this) {
            self::METRICO  => 'Kilogramos y metros',
            self::IMPERIAL => 'Libras y pies',
        };
    }

    /**
     * Convierte el peso a kg independientemente del sistema.
     * Si ya está en kg, no hace nada. Si está en lbs, convierte.
     * 1 libra = 0.453592 kg
     */
    public function convertirPesoAKg(float $peso): float
    {
        return match($this) {
            self::METRICO  => $peso,
            self::IMPERIAL => $peso * 0.453592,
        };
    }

    /**
     * Convierte la altura a metros independientemente del sistema.
     * 1 pie = 0.3048 metros
     */
    public function convertirAlturaAMetros(float $altura): float
    {
        return match($this) {
            self::METRICO  => $altura,
            self::IMPERIAL => $altura * 0.3048,
        };
    }
}
```

**¿Qué aprendes aquí?**
- Un Enum puede tener métodos que hacen cálculos reales, no solo devolver strings
- Centralizar la conversión de unidades en el Enum evita tener esa lógica dispersa por el código
- Si mañana agregas el sistema `JAPONES` (usa otras unidades), solo añades un case aquí

---

### `src/Enums/ClasificacionImc.php`

```php
<?php

declare(strict_types=1);

namespace App\Enums;

/**
 * Clasificación médica del IMC según la OMS.
 *
 * Nota: este Enum NO está respaldado por string ni int porque
 * los cases se determinan por rangos numéricos, no por un valor fijo.
 * Lo instanciamos con el método estático fromImc().
 */
enum ClasificacionImc
{
    case BAJO_PESO;
    case NORMAL;
    case SOBREPESO;
    case OBESIDAD_I;
    case OBESIDAD_II;
    case OBESIDAD_III;

    /**
     * Factory method — crea el Enum correcto a partir de un valor IMC.
     * Usamos match(true) para evaluar rangos numéricos.
     */
    public static function fromImc(float $imc): self
    {
        return match(true) {
            $imc < 18.5          => self::BAJO_PESO,
            $imc < 25.0          => self::NORMAL,
            $imc < 30.0          => self::SOBREPESO,
            $imc < 35.0          => self::OBESIDAD_I,
            $imc < 40.0          => self::OBESIDAD_II,
            default              => self::OBESIDAD_III,
        };
    }

    /** Etiqueta para mostrar al usuario */
    public function getLabel(): string
    {
        return match($this) {
            self::BAJO_PESO    => 'Bajo peso',
            self::NORMAL       => 'Normal',
            self::SOBREPESO    => 'Sobrepeso',
            self::OBESIDAD_I   => 'Obesidad grado I',
            self::OBESIDAD_II  => 'Obesidad grado II',
            self::OBESIDAD_III => 'Obesidad grado III',
        };
    }

    /** Color ANSI para la terminal */
    public function getColor(): string
    {
        return match($this) {
            self::BAJO_PESO    => '1;34',
            self::NORMAL       => '1;32',
            self::SOBREPESO    => '1;33',
            self::OBESIDAD_I   => '0;33',
            self::OBESIDAD_II  => '1;31',
            self::OBESIDAD_III => '0;31',
        };
    }

    /** Recomendación médica básica */
    public function getRecomendacion(): string
    {
        return match($this) {
            self::BAJO_PESO    => 'Consulta un nutricionista para un plan de alimentación.',
            self::NORMAL       => 'Mantén tus hábitos. ¡Vas por buen camino!',
            self::SOBREPESO    => 'Considera ajustar dieta y aumentar actividad física.',
            self::OBESIDAD_I   => 'Recomendable consultar con un médico especialista.',
            self::OBESIDAD_II  => 'Importante iniciar tratamiento médico supervisado.',
            self::OBESIDAD_III => 'Busca atención médica especializada a la brevedad.',
        };
    }

    /**
     * Posición en la barra visual (0-100).
     * Usamos esto para dibujar el indicador en pantalla.
     */
    public function getPosicionBarra(): int
    {
        return match($this) {
            self::BAJO_PESO    => 10,
            self::NORMAL       => 30,
            self::SOBREPESO    => 52,
            self::OBESIDAD_I   => 65,
            self::OBESIDAD_II  => 78,
            self::OBESIDAD_III => 92,
        };
    }
}
```

**¿Qué aprendes aquí?**
- Un Enum sin tipo (`enum ClasificacionImc` sin `: string`) — los cases no tienen valor asociado
- `static fromImc()` — método factory: crea la instancia correcta según los datos
- Cada Enum agrupa TODA la información de esa clasificación en un solo lugar

---

### `src/DTO/MedicionCorporal.php`

```php
<?php

declare(strict_types=1);

namespace App\DTO;

use App\Enums\SistemaUnidad;

/**
 * DTO inmutable que representa los datos físicos de una persona.
 *
 * Internamente siempre trabaja en el sistema métrico (kg, metros)
 * sin importar en qué sistema ingresó el usuario.
 * Los valores se almacenan como enteros (× 1000) para evitar float.
 */
readonly class MedicionCorporal
{
    /** Peso en gramos (evitamos float) */
    public int $pesoGramos;

    /** Altura en milímetros (evitamos float) */
    public int $alturaMillimetros;

    public function __construct(
        public SistemaUnidad $sistema,
        float $peso,
        float $altura,
        public string $nombre = 'Paciente'
    ) {
        if ($peso <= 0.0) {
            throw new \ValueError('El peso debe ser mayor a 0.');
        }

        if ($altura <= 0.0) {
            throw new \ValueError('La altura debe ser mayor a 0.');
        }

        // Convertimos al sistema métrico antes de guardar
        $pesoKg      = $sistema->convertirPesoAKg($peso);
        $alturaMetros = $sistema->convertirAlturaAMetros($altura);

        // Validaciones de rango (ya en sistema métrico)
        if ($pesoKg < 1.0 || $pesoKg > 500.0) {
            throw new \ValueError('El peso debe estar entre 1 y 500 kg.');
        }

        if ($alturaMetros < 0.5 || $alturaMetros > 3.0) {
            throw new \ValueError('La altura debe estar entre 0.5 y 3.0 metros.');
        }

        // Guardamos como enteros — adiós punto flotante
        $this->pesoGramos        = (int) round($pesoKg * 1000);
        $this->alturaMillimetros = (int) round($alturaMetros * 1000);
    }

    /** Peso en kg para mostrar al usuario */
    public function getPesoKg(): float
    {
        return $this->pesoGramos / 1000;
    }

    /** Altura en metros para mostrar al usuario */
    public function getAlturaMetros(): float
    {
        return $this->alturaMillimetros / 1000;
    }

    /**
     * Altura al cuadrado en mm² (entero).
     * La usamos para el cálculo del IMC sin decimales intermedios.
     */
    public function getAlturaAlCuadradoMm2(): int
    {
        return $this->alturaMillimetros * $this->alturaMillimetros;
    }
}
```

**¿Qué aprendes aquí?**
- El DTO hace la conversión de unidades en el constructor — el resto del código siempre recibe kg y metros
- `public string $nombre = 'Paciente'` — parámetro con valor por defecto (constructor promotion)
- Validamos primero que sea positivo, luego convertimos, luego validamos el rango — el orden importa

---

### `src/Services/ImcCalculatorService.php`

```php
<?php

declare(strict_types=1);

namespace App\Services;

use App\Contracts\CalculadoraInterface;
use App\DTO\MedicionCorporal;
use App\Enums\ClasificacionImc;

/**
 * Servicio de cálculo de IMC.
 * Implementa CalculadoraInterface — PHP verifica que tenga calcular() y getResultado().
 *
 * Fórmula: IMC = peso(kg) / altura²(m)
 *
 * Cálculo en enteros:
 *   imcX100 = (pesoGramos × 1000 × 100) / alturaAlCuadradoMm2
 *   ÷ 1000 para pasar gramos → kg
 *   × 100  para conservar 2 decimales en entero
 */
class ImcCalculatorService implements CalculadoraInterface
{
    private ?float $imcCalculado = null;

    public function __construct(
        private readonly MedicionCorporal $medicion
    ) {}

    /**
     * Calcula el IMC y lo almacena para no recalcularlo.
     * Patrón: lazy calculation (calcular solo cuando se necesita).
     */
    public function calcular(): float
    {
        if ($this->imcCalculado !== null) {
            return $this->imcCalculado;
        }

        // Cálculo en enteros × 100 para conservar 2 decimales
        $imcX100 = intdiv(
            $this->medicion->pesoGramos * 1000 * 100,
            $this->medicion->getAlturaAlCuadradoMm2()
        );

        $this->imcCalculado = $imcX100 / 100;

        return $this->imcCalculado;
    }

    /**
     * Devuelve todos los datos del resultado listos para mostrar.
     *
     * @return array<string, mixed>
     */
    public function getResultado(): array
    {
        $imc            = $this->calcular();
        $clasificacion  = ClasificacionImc::fromImc($imc);

        return [
            'imc'              => $imc,
            'imcFormateado'    => number_format($imc, 2),
            'clasificacion'    => $clasificacion,
            'label'            => $clasificacion->getLabel(),
            'color'            => $clasificacion->getColor(),
            'recomendacion'    => $clasificacion->getRecomendacion(),
            'posicionBarra'    => $clasificacion->getPosicionBarra(),
            'pesoKg'           => $this->medicion->getPesoKg(),
            'alturaMetros'     => $this->medicion->getAlturaMetros(),
            'nombre'           => $this->medicion->nombre,
        ];
    }

    /**
     * Calcula cuánto peso falta ganar o perder para estar en rango normal.
     * Rango normal: IMC entre 18.5 y 24.9
     *
     * Devuelve array con:
     * - 'diferencia'  → kg a ganar (positivo) o perder (negativo)
     * - 'enRango'     → true si ya está en rango normal
     */
    public function getPesoIdeal(): array
    {
        $imc           = $this->calcular();
        $alturaM       = $this->medicion->getAlturaMetros();
        $pesoActualKg  = $this->medicion->getPesoKg();

        // Peso mínimo para IMC 18.5 y máximo para IMC 24.9
        $pesoMinKg = 18.5 * ($alturaM ** 2);
        $pesoMaxKg = 24.9 * ($alturaM ** 2);

        $enRango = $imc >= 18.5 && $imc < 25.0;

        $diferencia = match(true) {
            $pesoActualKg < $pesoMinKg => $pesoMinKg - $pesoActualKg,    // debe ganar
            $pesoActualKg > $pesoMaxKg => $pesoMaxKg - $pesoActualKg,    // debe perder (negativo)
            default                    => 0.0,
        };

        return [
            'enRango'    => $enRango,
            'pesoMinKg'  => round($pesoMinKg, 1),
            'pesoMaxKg'  => round($pesoMaxKg, 1),
            'diferencia' => round($diferencia, 1),
        ];
    }
}
```

**¿Qué aprendes aquí?**
- `implements CalculadoraInterface` — la clase firma el contrato de la interface
- `private readonly MedicionCorporal $medicion` en el constructor — inyección de dependencias
- Lazy calculation — el IMC se calcula solo la primera vez y se reutiliza
- `getPesoIdeal()` — cálculo adicional útil que demuestra cómo extender el servicio

---

### `main.php`

```php
<?php

declare(strict_types=1);

require_once __DIR__ . '/src/Contracts/CalculadoraInterface.php';
require_once __DIR__ . '/src/Enums/SistemaUnidad.php';
require_once __DIR__ . '/src/Enums/ClasificacionImc.php';
require_once __DIR__ . '/src/DTO/MedicionCorporal.php';
require_once __DIR__ . '/src/Services/ImcCalculatorService.php';

use App\Enums\SistemaUnidad;
use App\DTO\MedicionCorporal;
use App\Services\ImcCalculatorService;

// ── Funciones de utilidad ─────────────────────────────────────────────────────

function color(string $text, string $color = '37'): string
{
    return "\033[{$color}m{$text}\033[0m";
}

function clear(): void
{
    echo "\033[2J\033[H";
}

function input(string $prompt): string
{
    echo color($prompt, '1;36') . " ";
    return trim(fgets(STDIN));
}

/**
 * Dibuja una barra visual con un marcador en la posición indicada.
 *
 * Ejemplo de salida:
 * [====|====|====|====▲====|====|====]
 *  BP    N    SP   O1  O2   O3
 */
function dibujarBarra(int $posicion): void
{
    $ancho       = 40;
    $posPixel    = (int) round($posicion * $ancho / 100);

    // Colores de fondo de la barra por zonas
    $zonas = [
        ['inicio' => 0,  'fin' => 10, 'color' => '44'],  // azul   = bajo peso
        ['inicio' => 10, 'fin' => 28, 'color' => '42'],  // verde  = normal
        ['inicio' => 28, 'fin' => 44, 'color' => '43'],  // amarillo = sobrepeso
        ['inicio' => 44, 'fin' => 56, 'color' => '43'],  // amarillo oscuro
        ['inicio' => 56, 'fin' => 72, 'color' => '41'],  // rojo claro
        ['inicio' => 72, 'fin' => 40, 'color' => '41'],  // rojo
    ];

    echo "  ";
    for ($i = 0; $i < $ancho; $i++) {
        $char = ($i === $posPixel) ? '▲' : '─';
        // Color según zona
        $colorZona = match(true) {
            $i < 4  => '44',
            $i < 11 => '42',
            $i < 18 => '43',
            $i < 24 => '0;33',
            $i < 32 => '41',
            default => '1;41',
        };
        echo color($char, $colorZona);
    }
    echo "\n";
    echo color("  BP        N          SP       O-I   O-II  O-III\n", '90');
}

// ── Inicio del programa ───────────────────────────────────────────────────────

clear();

echo color("==============================================\n", '1;36');
echo color("   CALCULADORA DE IMC v1.0\n", '1;36');
echo color("   Masterclass PHP 8.5 — Día 02\n", '1;36');
echo color("==============================================\n\n", '1;36');

// Nombre del paciente
$nombre = input("¿Cuál es tu nombre?");
if (empty($nombre)) $nombre = 'Paciente';

// Selección del sistema de unidades
echo color("\nSistema de medición:\n", '37');
echo color("  [1] Métrico   — kg y metros\n", '32');
echo color("  [2] Imperial  — lbs y pies\n\n", '33');

$opcion = input("Selecciona el sistema (1-2):");

$sistema = match($opcion) {
    '1' => SistemaUnidad::METRICO,
    '2' => SistemaUnidad::IMPERIAL,
    default => null,
};

if ($sistema === null) {
    echo color("\n❌ Opción inválida. Saliendo...\n\n", '1;31');
    exit(1);
}

// Captura de datos
$unidadPeso   = $sistema->getUnidadPeso();
$unidadAltura = $sistema->getUnidadAltura();

$peso  = (float) input("Peso ({$unidadPeso}):");
$altura = (float) input("Altura ({$unidadAltura}):");

// Cálculo y resultado
try {
    $medicion  = new MedicionCorporal($sistema, $peso, $altura, $nombre);
    $servicio  = new ImcCalculatorService($medicion);
    $resultado = $servicio->getResultado();
    $ideal     = $servicio->getPesoIdeal();

    clear();

    echo color("==============================================\n", '1;36');
    echo color("   RESULTADO — {$nombre}\n", '1;36');
    echo color("==============================================\n\n", '1;36');

    // Datos ingresados
    echo color("  DATOS\n", '37');
    echo color("  ──────────────────────────────────────\n", '90');
    echo color("  Peso    : ", '37') . color(number_format($medicion->getPesoKg(), 1) . " kg", '1;37') . "\n";
    echo color("  Altura  : ", '37') . color(number_format($medicion->getAlturaMetros(), 2) . " m", '1;37') . "\n";
    echo color("  Sistema : ", '37') . color($sistema->value, '1;37') . "\n";

    // Resultado IMC
    echo color("\n  RESULTADO\n", '37');
    echo color("  ──────────────────────────────────────\n", '90');
    echo color("  IMC     : ", '37') . color($resultado['imcFormateado'], '1;37') . "\n";
    echo color("  Estado  : ", '37') . color($resultado['label'], $resultado['color']) . "\n\n";

    // Barra visual
    dibujarBarra($resultado['posicionBarra']);

    // Peso ideal
    echo color("\n  RANGO SALUDABLE\n", '37');
    echo color("  ──────────────────────────────────────\n", '90');
    echo color("  Rango ideal : ", '37') . color(
        $ideal['pesoMinKg'] . " — " . $ideal['pesoMaxKg'] . " kg",
        '1;37'
    ) . "\n";

    if ($ideal['enRango']) {
        echo color("  Peso        : ", '37') . color("✓ Estás en rango saludable", '1;32') . "\n";
    } else {
        $diferencia = $ideal['diferencia'];
        $accion     = $diferencia > 0 ? "ganar" : "perder";
        echo color("  Acción      : ", '37') . color(
            abs($diferencia) . " kg por " . $accion,
            $diferencia < 0 ? '1;33' : '1;34'
        ) . "\n";
    }

    // Recomendación
    echo color("\n  ══════════════════════════════════════\n", $resultado['color']);
    echo color("  " . $resultado['recomendacion'] . "\n", $resultado['color']);
    echo color("  ══════════════════════════════════════\n\n", $resultado['color']);

} catch (\ValueError $e) {
    echo color("\n❌ Error: " . $e->getMessage() . "\n\n", '1;31');
    exit(1);
}
```

---

## Paso 3 — Ejecuta el programa

```bash
php main.php
```

---

## Ejemplo de ejecución

```
==============================================
   CALCULADORA DE IMC v1.0
   Masterclass PHP 8.5 — Día 02
==============================================

¿Cuál es tu nombre? Ana

Sistema de medición:
  [1] Métrico   — kg y metros
  [2] Imperial  — lbs y pies

Selecciona el sistema (1-2): 1
Peso (kg): 68
Altura (m): 1.65

==============================================
   RESULTADO — Ana
==============================================

  DATOS
  ──────────────────────────────────────
  Peso    : 68.0 kg
  Altura  : 1.65 m
  Sistema : Métrico

  RESULTADO
  ──────────────────────────────────────
  IMC     : 24.98
  Estado  : Sobrepeso

  ─────────▲──────────────────────────
  BP        N          SP       O-I   O-II  O-III

  RANGO SALUDABLE
  ──────────────────────────────────────
  Rango ideal : 50.4 — 67.8 kg
  Acción      : 0.2 kg por perder

  ══════════════════════════════════════
  Considera ajustar dieta y aumentar actividad física.
  ══════════════════════════════════════
```

---

## Retos para practicar

### Nivel 1 — Básico
- Agrega una clasificación nueva: `INFRA_PESO` para IMC menor a 16.0
- Dale su propio color, label y recomendación en `ClasificacionImc`

### Nivel 2 — Intermedio
- Agrega el sistema `JAPONÉS` al Enum `SistemaUnidad`
- En Japón se mide el peso en kg pero la altura en centímetros
- Implementa la conversión en `convertirAlturaAMetros()`

### Nivel 3 — Avanzado
- Permite calcular el IMC de varias personas en la misma sesión
- Al terminar muestra un ranking de menor a mayor IMC usando `usort()`
- Identifica quién está más cerca del rango normal

---

## Lo nuevo que aprendiste vs el Día 01

| Concepto nuevo | Dónde lo usaste | Por qué es importante |
|----------------|-----------------|----------------------|
| `interface` | `CalculadoraInterface.php` | Contratos entre clases — base de arquitecturas grandes |
| Enum sin tipo | `ClasificacionImc.php` | Cuando los cases no tienen valor fijo asociado |
| Factory method `fromImc()` | `ClasificacionImc.php` | Crear instancias con lógica, no solo `new` |
| Lazy calculation | `ImcCalculatorService.php` | Calcular solo cuando se necesita, no en el constructor |
| Inyección de dependencias | Constructor del Service | El service recibe sus datos, no los busca solo |
| Barra visual CLI | `main.php` | Presentación avanzada en terminal con caracteres ANSI |

---

## Resumen de todos los conceptos

| Concepto | Archivo | Para qué sirve |
|----------|---------|----------------|
| `enum` con métodos de conversión | `SistemaUnidad.php` | Encapsula lógica de negocio en el tipo |
| `enum` sin tipo + factory | `ClasificacionImc.php` | Determina el case correcto con lógica |
| `readonly class` DTO | `MedicionCorporal.php` | Datos inmutables con conversión automática |
| `interface` | `CalculadoraInterface.php` | Contrato obligatorio para las calculadoras |
| `implements` | `ImcCalculatorService.php` | Firma el contrato de la interface |
| `match(true)` con rangos | `ClasificacionImc.php` | Evaluar condiciones numéricas limpiamente |
| Aritmética entera | `ImcCalculatorService.php` | Cálculo sin errores de punto flotante |
| Lazy calculation | `ImcCalculatorService.php` | Eficiencia — no recalcular lo ya calculado |

---

*Masterclass PHP 8.5 — Fase 1: Dominio de la Terminal*
*Día 02 de 10*