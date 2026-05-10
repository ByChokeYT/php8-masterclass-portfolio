<?php
/**
 * mentor.php — Sección del Instructor
 */
?>
<section id="mentor" class="py-32 relative">

    <div class="absolute inset-0 pointer-events-none"
         style="background: radial-gradient(ellipse 60% 50% at 50% 50%, rgba(99,102,241,0.05) 0%, transparent 70%);">
    </div>

    <div class="max-w-7xl mx-auto px-6">
        <div class="flex flex-col lg:flex-row items-center gap-16 lg:gap-24">

            <!-- Visual del Instructor -->
            <div class="w-full lg:w-5/12" data-aos="fade-right">
                <div class="relative group max-w-sm mx-auto lg:mx-0">

                    <!-- Glow -->
                    <div class="absolute -inset-4 rounded-[3rem] blur-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-1000"
                         style="background: linear-gradient(135deg, rgba(99,102,241,0.2), rgba(6,182,212,0.1));"></div>

                    <!-- Card del instructor -->
                    <div class="relative glass rounded-[2.5rem] overflow-hidden shadow-2xl">
                        <div class="aspect-square flex items-center justify-center relative overflow-hidden"
                             style="background: linear-gradient(135deg, #0d0f16 0%, #070810 100%);">

                            <!-- Decoración de fondo -->
                            <div class="absolute inset-0 opacity-20"
                                 style="background-image: linear-gradient(rgba(99,102,241,0.1) 1px, transparent 1px), linear-gradient(90deg, rgba(99,102,241,0.1) 1px, transparent 1px); background-size: 25px 25px;"></div>

                            <!-- Avatar / Foto placeholder -->
                            <div class="relative z-10 text-center p-10">
                                <div class="w-28 h-28 mx-auto rounded-full flex items-center justify-center mb-6 shadow-2xl"
                                     style="background: linear-gradient(135deg, rgba(99,102,241,0.3), rgba(6,182,212,0.2)); border: 2px solid rgba(99,102,241,0.3);">
                                    <i class="ph-fill ph-chalkboard-teacher text-6xl text-indigo-400" style="filter: drop-shadow(0 0 15px rgba(99,102,241,0.5));"></i>
                                </div>
                                <h3 class="text-2xl font-black text-white tracking-tight">José Luis</h3>
                                <h3 class="text-2xl font-black text-white tracking-tight">Choquevillca</h3>
                                <p class="section-label mt-3 text-cyan-400">Software Engineer & Mentor</p>
                            </div>
                        </div>
                    </div>

                    <!-- Badge flotante -->
                    <div class="absolute -bottom-4 -right-4 glass px-5 py-3 rounded-2xl shadow-xl" style="border-color: rgba(99,102,241,0.2);">
                        <div class="text-2xl font-black text-white">10+</div>
                        <div class="section-label text-[8px]">Años Exp.</div>
                    </div>
                </div>
            </div>

            <!-- Contenido del Instructor -->
            <div class="w-full lg:w-7/12 space-y-7" data-aos="fade-left" data-aos-delay="100">

                <div>
                    <div class="section-label mb-4">El Instructor</div>
                    <h2 class="text-4xl md:text-5xl font-black text-white tracking-tight leading-tight mb-6">
                        Aprende con un<br><span class="grad-text">Ingeniero Real</span>
                    </h2>
                    <p class="text-lg text-slate-400 leading-relaxed">
                        "Mi misión es transformar tu lógica de programación. No construimos demos baratos —
                        diseñamos arquitecturas que escalan a producción real."
                    </p>
                </div>

                <!-- Skills -->
                <div class="grid grid-cols-2 gap-4">
                    <?php foreach ([
                        ['ph-code', 'PHP 8.5+', 'OOP, Enums, Fibers'],
                        ['ph-database', 'MySQL & PDO', 'Queries optimizadas'],
                        ['ph-tree-structure', 'Clean Architecture', 'MVC, DDD, SOLID'],
                        ['ph-cloud', 'DevOps', 'Linux, Apache, Deploy'],
                    ] as [$icon, $title, $sub]): ?>
                    <div class="glass rounded-xl p-4 flex items-start gap-3">
                        <div class="w-9 h-9 rounded-lg shrink-0 flex items-center justify-center" style="background: rgba(99,102,241,0.1); border: 1px solid rgba(99,102,241,0.15);">
                            <i class="ph-fill <?= $icon ?> text-indigo-400"></i>
                        </div>
                        <div>
                            <div class="text-white font-bold text-sm"><?= $title ?></div>
                            <div class="text-slate-500 text-xs"><?= $sub ?></div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>

                <!-- Contacto -->
                <div class="flex flex-wrap gap-4 pt-4">
                    <a href="https://cvbychoke.netlify.app/" target="_blank"
                       class="px-6 py-3 rounded-xl bg-white text-black font-black text-xs uppercase tracking-widest hover:bg-indigo-400 hover:text-white transition-all shadow-lg">
                        Ver CV
                    </a>
                    <a href="https://wa.me/59162793829" target="_blank"
                       class="px-6 py-3 rounded-xl border border-white/10 bg-white/5 text-white font-bold text-xs uppercase tracking-widest hover:bg-white/10 hover:border-green-500/30 hover:text-green-400 transition-all flex items-center gap-2">
                        <i class="ph-fill ph-whatsapp-logo text-lg"></i>
                        WhatsApp
                    </a>
                    <a href="https://www.linkedin.com/in/jose-luis-choquevillca/" target="_blank"
                       class="w-10 h-10 rounded-xl border border-white/10 bg-white/5 flex items-center justify-center text-slate-500 hover:text-blue-400 hover:border-blue-400/20 transition-all">
                        <i class="ph-fill ph-linkedin-logo text-lg"></i>
                    </a>
                    <a href="https://codepen.io/ByChokeYT" target="_blank"
                       class="w-10 h-10 rounded-xl border border-white/10 bg-white/5 flex items-center justify-center text-slate-500 hover:text-white hover:border-white/20 transition-all">
                        <i class="ph-fill ph-codepen-logo text-lg"></i>
                    </a>
                </div>

            </div>
        </div>
    </div>
</section>
