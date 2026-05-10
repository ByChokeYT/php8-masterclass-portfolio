<?php
/**
 * _nav.php — Barra de Navegación Global para los Manuales Pedagógicos
 * Se incluye en cada día del curso (dia-1 al dia-N).
 *
 * @param int    $dayNumber Número del día (ej: 1)
 * @param string $dayLabel  Ej: "DÍA 01"
 * @param string $dayTitle  Ej: "Calculadora de Minerales"
 * @param string $prevUrl   URL al proyecto anterior (puede ser '')
 * @param string $nextUrl   URL al proyecto siguiente (puede ser '')
 */
?>
<!-- Fuentes y Phosphor Icons (por si la plantilla pedagógica los necesita también en el nav) -->
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;700&display=swap" rel="stylesheet">
<script src="https://unpkg.com/@phosphor-icons/web" defer></script>

<!-- Navbar Principal del Curso -->
<nav class="fixed top-0 left-0 right-0 z-[9999] h-14 bg-slate-900/95 backdrop-blur-md border-b border-white/10 flex items-center justify-between px-4 sm:px-6 shadow-lg">
    
    <!-- Izquierda: Logo + Volver al Hub -->
    <div class="flex items-center gap-3">
        <!-- Logo ByChoke -->
        <a href="/" class="flex items-center gap-2.5 group shrink-0">
            <div class="w-8 h-8 rounded-lg overflow-hidden border border-white/20 group-hover:border-indigo-400/50 transition-all bg-white/5">
                <img src="/assets/img/logo.gif" alt="ByChoke" class="w-full h-full object-cover" style="filter: brightness(0) invert(1);">
            </div>
            <span class="hidden sm:block text-white font-black text-sm tracking-tight">
                ByChoke<span class="text-indigo-400">Studios</span>
            </span>
        </a>

        <div class="w-px h-6 bg-white/10 hidden sm:block mx-1"></div>

        <!-- Label del Día actual -->
        <div class="flex items-center gap-2.5">
            <span class="px-2 py-0.5 rounded bg-indigo-500/20 text-indigo-300 font-mono text-[10px] font-bold tracking-widest border border-indigo-500/30">
                <?= $dayLabel ?? 'ACADEMIA' ?>
            </span>
            <span class="text-sm font-bold text-slate-200 truncate max-w-[130px] sm:max-w-xs">
                <?= htmlspecialchars($dayTitle ?? 'PHP Masterclass') ?>
            </span>
        </div>
    </div>
    
    <!-- Derecha: Navegación Anterior / Siguiente -->
    <div class="flex items-center gap-2">
        <?php if (!empty($prevUrl)): ?>
            <a href="<?= $prevUrl ?>" class="group flex items-center gap-1.5 px-3 py-1.5 rounded-lg border border-white/10 bg-white/5 text-slate-400 hover:border-indigo-400/40 hover:text-indigo-300 hover:bg-indigo-500/10 transition-all text-xs font-bold">
                <i class="ph-bold ph-caret-left group-hover:-translate-x-0.5 transition-transform"></i>
                <span class="hidden sm:inline">Anterior</span>
            </a>
        <?php else: ?>
            <span class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg border border-white/5 text-slate-600 cursor-not-allowed text-xs font-bold opacity-40">
                <i class="ph-bold ph-caret-left"></i>
                <span class="hidden sm:inline">Anterior</span>
            </span>
        <?php endif; ?>
        
        <?php if (!empty($nextUrl)): ?>
            <a href="<?= $nextUrl ?>" class="group flex items-center gap-1.5 px-3 py-1.5 rounded-lg border border-white/10 bg-white/5 text-slate-400 hover:border-indigo-400/40 hover:text-indigo-300 hover:bg-indigo-500/10 transition-all text-xs font-bold">
                <span class="hidden sm:inline">Siguiente</span>
                <i class="ph-bold ph-caret-right group-hover:translate-x-0.5 transition-transform"></i>
            </a>
        <?php else: ?>
            <span class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg border border-white/5 text-slate-600 cursor-not-allowed text-xs font-bold opacity-40">
                <span class="hidden sm:inline">Siguiente</span>
                <i class="ph-bold ph-caret-right"></i>
            </span>
        <?php endif; ?>

        <!-- GitHub -->
        <a href="https://github.com/ByChokeYT/php8-masterclass-portfolio" target="_blank"
           class="ml-1 w-8 h-8 rounded-lg border border-white/10 bg-white/5 flex items-center justify-center text-slate-400 hover:text-white hover:border-white/20 transition-all">
            <i class="ph-bold ph-github-logo text-base"></i>
        </a>
    </div>
</nav>

<!-- Espaciador fantasma para compensar el navbar fijo -->
<div class="h-14 w-full"></div>
