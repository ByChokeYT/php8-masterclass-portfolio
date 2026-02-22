# 08 Neon Guess | PHP 8.5 (Arcade Edition)

> **Juego de Adivinar el Número - Estilo Cyberpunk**
> Una experiencia visual interactiva donde adivinas un número secreto con feedback en tiempo real.

## 🕹️ Descripción

**Neon Guess** reinventa el clásico juego de "Adivina el Número" con una estética **Cyberpunk/Arcade**.
En lugar de solo texto, utiliza una **Barra de Rango Visual** que se reduce dinámicamente mostrándote dónde se encuentra el número secreto.

---

## 🚀 Características Visuales

- **Barra de Rango Dinámica:** Una barra de neón que se encoge visualmente para mostrar el rango de números posibles.
- **Estética Cyberpunk:** Colores neón (Cyan/Purple), tipografía `Rajdhani` y efectos de brillo (glow).
- **Feedback Inmersivo:** Mensajes claros con indicadores visuales de "Mayor" o "Menor".
- **Diseño Mobile-First:** Optimizado para jugar en cualquier dispositivo sin scroll.

---

## ⚡ Cómo Jugar

1. El sistema elige un número secreto (1-100).
2. Ingresa tu predicción en el campo central.
3. Observa la **barra visual**:
   - Se reducirá para mostrarte el nuevo rango posible.
   - Si tu número es bajo, el límite izquierdo sube.
   - Si tu número es alto, el límite derecho baja.
4. ¡Intenta acorralar al número secreto!

---

## 🛠️ Tecnologías

### PHP 8.5
- Gestión de Sesiones para mantener el estado del juego.
- `random_int()` criptográficamente seguro.
- Lógica de reducción de rangos (`min()`, `max()`).
- Patrón PRG (Post-Redirect-Get) para evitar reenvíos del formulario.

### Frontend
- **CSS Variables:** Para la paleta de colores neón.
- **CSS Grid/Flexbox:** Para el centrado perfecto.
- **Animaciones:** Transiciones suaves en la barra de rango.
- **Fuentes:** Google Fonts `Rajdhani` para el look sci-fi.

---

## 📁 Estructura

```
08_adivina_numero/
├── public/
│   └── index.php    # Juego completo (Lógica + UI Neon)
└── README.md
```

---

## 👾 Ejecución

```bash
cd 08_adivina_numero
php -S localhost:8085 -t public
```

Visita: **http://localhost:8085**
