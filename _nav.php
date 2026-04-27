<?php
/**
 * _nav.php — Barra de Navegación Global Titanium Masterclass
 * Inclúyela en cualquier proyecto con:
 *   require_once __DIR__ . '/_nav.php';
 *
 * @param string $dayLabel  Ej: "DÍA 01"
 * @param string $dayTitle  Ej: "Calculadora de Pureza"
 * @param string $prevUrl   URL al proyecto anterior (puede ser '')
 * @param string $nextUrl   URL al proyecto siguiente (puede ser '')
 */
?>
<style>
._nav-bar *{box-sizing:border-box;margin:0;padding:0;}
._nav-bar{
    position:fixed;top:0;left:0;right:0;z-index:9999;
    height:52px;
    background:rgba(8,8,10,.85);
    backdrop-filter:blur(20px);
    border-bottom:1px solid rgba(255,255,255,.06);
    display:flex;align-items:center;
    padding:0 1.5rem;gap:1rem;
    font-family:'Inter',system-ui,sans-serif;
}
._nav-back{
    display:flex;align-items:center;gap:.5rem;
    color:#94a3b8;font-size:.8rem;font-weight:600;
    text-decoration:none;
    padding:.35rem .85rem;
    border:1px solid rgba(255,255,255,.08);
    border-radius:100px;
    transition:all .2s;
    white-space:nowrap;
}
._nav-back:hover{color:#fff;border-color:rgba(255,255,255,.2);background:rgba(255,255,255,.04);}
._nav-divider{width:1px;height:20px;background:rgba(255,255,255,.08);}
._nav-label{
    font-family:'JetBrains Mono',monospace;
    font-size:.7rem;letter-spacing:1.5px;
    color:#6366f1;
    white-space:nowrap;
}
._nav-title{
    font-size:.85rem;font-weight:700;color:#e4e4f0;
    white-space:nowrap;overflow:hidden;text-overflow:ellipsis;
}
._nav-spacer{flex:1;}
._nav-pill-prev,._nav-pill-next{
    display:flex;align-items:center;gap:.4rem;
    color:#64748b;font-size:.75rem;font-weight:600;
    text-decoration:none;
    padding:.3rem .7rem;
    border:1px solid rgba(255,255,255,.06);
    border-radius:8px;
    transition:all .2s;
    white-space:nowrap;
}
._nav-pill-prev:hover,._nav-pill-next:hover{color:#fff;border-color:rgba(255,255,255,.15);}
._nav-pill-prev.disabled,._nav-pill-next.disabled{opacity:.25;pointer-events:none;}
body{padding-top:52px!important;}
</style>

<nav class="_nav-bar">
    <a href="/" class="_nav-back">
        ← VOLVER AL HUB
    </a>
    <div class="_nav-divider"></div>
    <span class="_nav-label"><?= $dayLabel ?? 'DÍA' ?></span>
    <span class="_nav-title"><?= htmlspecialchars($dayTitle ?? '') ?></span>
    <div class="_nav-spacer"></div>
    <?php if (!empty($prevUrl)): ?>
        <a href="<?= $prevUrl ?>" class="_nav-pill-prev">← Anterior</a>
    <?php else: ?>
        <span class="_nav-pill-prev disabled">← Anterior</span>
    <?php endif; ?>
    <?php if (!empty($nextUrl)): ?>
        <a href="<?= $nextUrl ?>" class="_nav-pill-next">Siguiente →</a>
    <?php else: ?>
        <span class="_nav-pill-next disabled">Siguiente →</span>
    <?php endif; ?>
</nav>
