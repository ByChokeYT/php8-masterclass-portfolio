<?php
$phaseId = 1;
$phase = $phases[$phaseId];
$phaseProjects = array_values(array_filter($projects, fn($p) => $p['phase_id'] === $phaseId));
$hasProjects = !empty($phaseProjects);
?>

<section class="stagger-item p-10 md:p-16 rounded-[3rem] bg-gradient-to-b from-white/[0.02] to-transparent border border-white/5 shadow-2xl relative overflow-hidden group/module mb-32 hover:border-white/10 transition-colors duration-700">
    <!-- Glow de fondo estático -->
    <div class="absolute top-0 right-0 w-96 h-96 bg-[<?= $phase['color'] ?>] opacity-[0.03] blur-[100px] pointer-events-none"></div>

    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center gap-8 mb-16 border-b border-white/5 pb-12 relative z-10">
        <div class="w-20 h-20 rounded-[1.5rem] flex items-center justify-center text-4xl shadow-xl border border-white/10 relative overflow-hidden group-hover/module:scale-105 transition-transform duration-500" style="background: <?= $phase['color'] ?>10; color: <?= $phase['color'] ?>;">
            <div class="absolute inset-0 bg-gradient-to-br from-white/10 to-transparent opacity-0 group-hover/module:opacity-100 transition-opacity"></div>
            <i class="ph-fill <?= $phase['icon'] ?> drop-shadow-[0_0_15px_rgba(255,255,255,0.3)]"></i>
        </div>
        <div class="flex-1">
            <div class="flex items-center gap-4 mb-3">
                <span class="text-[11px] font-black tech-mono uppercase tracking-[0.5em] text-white/30">Módulo_0<?= $phaseId ?></span>
                <span class="px-4 py-1 rounded-full border text-[9px] font-black uppercase tracking-widest shadow-[0_0_10px_<?= $phase['color'] ?>20]" style="border-color: <?= $phase['color'] ?>30; background: <?= $phase['color'] ?>10; color: <?= $phase['color'] ?>">
                    <?= $phase['difficulty'] ?>
                </span>
            </div>
            <h2 class="text-4xl md:text-5xl font-black text-transparent bg-clip-text bg-gradient-to-r from-white to-white/60 uppercase italic tracking-tighter drop-shadow-lg"><?= $phase['title'] ?></h2>
        </div>
    </div>

    <!-- Grid -->
    <?php if ($hasProjects): ?>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8 relative z-10">
            <?php foreach ($phaseProjects as $p): ?>
                <a href="<?= $p['path'] ?>" class="group relative p-8 rounded-[2rem] bg-[#0f111a]/80 backdrop-blur-md border border-white/5 hover:border-[<?= $phase['color'] ?>] transition-all duration-500 flex flex-col justify-between min-h-[260px] overflow-hidden hover:-translate-y-2 hover:shadow-[0_20px_40px_-15px_<?= $phase['color'] ?>40]">
                    <!-- Hover Gradient Background -->
                    <div class="absolute inset-0 bg-gradient-to-br from-[<?= $phase['color'] ?>]/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    
                    <div class="relative z-10">
                        <div class="flex justify-between items-center mb-8 pb-4 border-b border-white/5 group-hover:border-[<?= $phase['color'] ?>]/20 transition-colors">
                            <div class="flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full animate-pulse" style="background-color: <?= $phase['color'] ?>;"></span>
                                <span class="text-[10px] font-black text-slate-400 tech-mono uppercase tracking-[0.3em] group-hover:text-white transition-colors">Day_<?= str_pad((string)$p['day'], 2, '0', STR_PAD_LEFT) ?></span>
                            </div>
                            <div class="w-8 h-8 rounded-full bg-white/5 flex items-center justify-center group-hover:bg-[<?= $phase['color'] ?>] group-hover:text-obsidian transition-all">
                                <i class="ph-bold ph-arrow-up-right text-slate-500 group-hover:text-obsidian transition-colors"></i>
                            </div>
                        </div>
                        <h3 class="text-base font-black text-white mb-4 uppercase italic tracking-tight leading-tight group-hover:drop-shadow-[0_0_8px_rgba(255,255,255,0.3)] transition-all">
                            <i class="<?= $p['icon'] ?> text-2xl mr-2 align-middle opacity-80 group-hover:opacity-100 transition-opacity" style="color: <?= $phase['color'] ?>"></i><?= $p['title'] ?>
                        </h3>
                        <p class="text-[11px] text-slate-400 font-medium leading-relaxed line-clamp-3 mb-6 group-hover:text-slate-300 transition-colors"><?= $p['description'] ?></p>
                    </div>
                    <div class="relative z-10 flex flex-wrap gap-2 pt-5 border-t border-white/5">
                        <?php foreach (array_slice($p['tags'], 0, 3) as $tag): ?>
                            <span class="px-3 py-1.5 rounded-lg bg-white/5 text-[9px] font-black text-slate-400 tech-mono uppercase tracking-widest border border-white/5 group-hover:border-[<?= $phase['color'] ?>]/30 group-hover:text-[<?= $phase['color'] ?>] transition-all"><?= $tag ?></span>
                        <?php endforeach; ?>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="py-32 text-center opacity-30 flex flex-col items-center justify-center border-2 border-dashed border-white/10 rounded-[2rem] bg-white/[0.01]">
            <i class="ph-fill ph-lock-key text-6xl mb-6 text-slate-600"></i>
            <p class="text-[12px] font-bold tech-mono uppercase tracking-[0.4em] text-slate-500">Módulo_En_Construcción</p>
        </div>
    <?php endif; ?>
</section>
