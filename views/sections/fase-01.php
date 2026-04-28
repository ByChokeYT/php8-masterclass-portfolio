<?php
$phaseId = 1;
$phase = $phases[$phaseId];
$phaseProjects = array_values(array_filter($projects, fn($p) => $p['phase_id'] === $phaseId));
$hasProjects = !empty($phaseProjects);
?>

<section class="stagger-item p-10 md:p-16 rounded-[4rem] bg-white/[0.01] border border-white/5 shadow-2xl relative overflow-hidden group/module mb-32">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center gap-8 mb-16 border-b border-white/5 pb-12">
        <div class="w-16 h-16 rounded-2xl flex items-center justify-center text-3xl shadow-xl border border-white/10" style="background: <?= $phase['color'] ?>15; color: <?= $phase['color'] ?>;">
            <i class="ph-fill <?= $phase['icon'] ?>"></i>
        </div>
        <div class="flex-1">
            <div class="flex items-center gap-3 mb-2">
                <span class="text-[10px] font-black tech-mono uppercase tracking-[0.4em] opacity-40">Módulo_0<?= $phaseId ?></span>
                <span class="px-3 py-0.5 rounded-full border text-[8px] font-black uppercase tracking-widest" style="border-color: <?= $phase['color'] ?>20; background: <?= $phase['color'] ?>05; color: <?= $phase['color'] ?>">
                    <?= $phase['difficulty'] ?>
                </span>
            </div>
            <h2 class="text-3xl md:text-4xl font-black text-white uppercase italic tracking-tighter"><?= $phase['title'] ?></h2>
        </div>
    </div>

    <!-- Grid -->
    <?php if ($hasProjects): ?>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <?php foreach ($phaseProjects as $p): ?>
                <a href="<?= $p['path'] ?>" class="group relative p-6 rounded-[2rem] bg-white/[0.02] border border-white/5 hover:bg-white/[0.05] transition-all duration-500 flex flex-col justify-between min-h-[220px]">
                    <div class="relative z-10">
                        <div class="flex justify-between items-start mb-6">
                            <span class="text-[9px] font-black text-slate-600 tech-mono uppercase tracking-[0.3em]">Day_<?= str_pad((string)$p['day'], 2, '0', STR_PAD_LEFT) ?></span>
                            <i class="ph ph-arrow-up-right text-slate-700 group-hover:text-white transition-colors"></i>
                        </div>
                        <h3 class="text-sm font-black text-white mb-3 uppercase italic tracking-tight leading-tight">
                            <i class="<?= $p['icon'] ?> text-xl mr-2 text-<?= $phase['color'] ?> opacity-80" style="color: <?= $phase['color'] ?>"></i><?= $p['title'] ?>
                        </h3>
                        <p class="text-[10px] text-slate-500 font-medium leading-relaxed line-clamp-3 mb-6"><?= $p['description'] ?></p>
                    </div>
                    <div class="relative z-10 flex flex-wrap gap-2 pt-4 border-t border-white/5">
                        <?php foreach (array_slice($p['tags'], 0, 2) as $tag): ?>
                            <span class="px-2.5 py-1 rounded-md bg-white/5 text-[8px] font-black text-slate-500 tech-mono uppercase tracking-widest"><?= $tag ?></span>
                        <?php endforeach; ?>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="py-20 text-center opacity-20"><i class="ph ph-lock-key text-4xl mb-4"></i><p class="text-[10px] uppercase tracking-widest">Módulo en Desarrollo</p></div>
    <?php endif; ?>
</section>
