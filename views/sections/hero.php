<section class="min-h-screen flex items-center justify-center relative pt-24 pb-20 overflow-hidden">

    <!-- Luces de ambiente -->
    <div class="absolute top-1/4 left-1/3 w-[700px] h-[700px] rounded-full blur-[120px] pointer-events-none" style="background: radial-gradient(circle, rgba(99,102,241,0.12) 0%, transparent 70%);"></div>
    <div class="absolute bottom-0 right-0 w-[500px] h-[500px] rounded-full blur-[100px] pointer-events-none" style="background: radial-gradient(circle, rgba(6,182,212,0.07) 0%, transparent 70%);"></div>

    <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 lg:grid-cols-12 gap-12 items-center w-full">

        <!-- LEFT: Copy -->
        <div class="lg:col-span-7 space-y-8" data-aos="fade-right">

            <!-- Badge animado -->
            <div class="badge-pill">
                <span class="w-1.5 h-1.5 rounded-full bg-indigo-400 animate-pulse"></span>
                PHP_Masterclass_v8.5 · 50 Proyectos
            </div>

            <!-- Título -->
            <h1 class="text-5xl md:text-6xl lg:text-7xl font-black text-white tracking-tighter leading-[1.0]">
                De Coder<br>a <span class="grad-text">Arquitecto</span><br>
                <span class="text-slate-500 font-black text-4xl md:text-5xl">Backend</span>
            </h1>

            <!-- Descripción -->
            <p class="text-lg text-slate-400 leading-relaxed max-w-xl font-medium">
                Aprende PHP moderno con el rigor de un ingeniero Senior. 
                <strong class="text-white">Clean Architecture, OOP avanzado, PDO, APIs REST</strong> y más —
                a través de proyectos de grado industrial, no tutoriales de YouTube.
            </p>

            <!-- CTAs -->
            <div class="flex flex-col sm:flex-row gap-4">
                <a href="#proyectos"
                   class="px-8 py-4 rounded-xl bg-gradient-to-r from-indigo-600 to-cyan-500 text-white font-black text-xs uppercase tracking-widest hover:-translate-y-1 hover:shadow-[0_15px_40px_rgba(99,102,241,0.35)] transition-all flex items-center justify-center gap-2 shadow-lg shadow-indigo-600/25">
                    <i class="ph-bold ph-terminal-window text-lg"></i>
                    Iniciar Laboratorio
                </a>
                <a href="https://github.com/ByChokeYT/php8-masterclass-portfolio" target="_blank"
                   class="px-8 py-4 rounded-xl border border-white/10 bg-white/5 text-white font-bold text-xs uppercase tracking-widest hover:bg-white/10 hover:border-white/20 transition-all flex items-center justify-center gap-2">
                    <i class="ph-bold ph-github-logo text-lg"></i>
                    Ver en GitHub
                </a>
            </div>

            <!-- Stats -->
            <div class="flex flex-wrap gap-8 pt-6 border-t border-white/5">
                <div>
                    <div class="text-3xl font-black text-white">50+</div>
                    <div class="section-label mt-1">Proyectos</div>
                </div>
                <div>
                    <div class="text-3xl font-black text-cyan-400">10+</div>
                    <div class="section-label mt-1">Años Exp.</div>
                </div>
                <div>
                    <div class="text-3xl font-black text-indigo-400">5</div>
                    <div class="section-label mt-1">Módulos</div>
                </div>
                <div class="flex items-center gap-3">
                    <div class="flex -space-x-2">
                        <?php foreach ([11,12,13] as $i): ?>
                            <img class="w-9 h-9 rounded-full border-2 border-[#050608]"
                                 src="https://i.pravatar.cc/80?img=<?= $i ?>" alt="Student">
                        <?php endforeach; ?>
                        <div class="w-9 h-9 rounded-full border-2 border-[#050608] bg-indigo-600 flex items-center justify-center text-[9px] font-black text-white">+2k</div>
                    </div>
                    <div class="section-label">Alumnos</div>
                </div>
            </div>
        </div>

        <!-- RIGHT: Visual card -->
        <div class="lg:col-span-5 flex justify-center" data-aos="fade-left" data-aos-delay="150">
            <div class="relative w-full max-w-sm group">

                <!-- Glow trasero -->
                <div class="absolute -inset-4 rounded-[3rem] blur-3xl opacity-0 group-hover:opacity-100 transition-opacity duration-1000"
                     style="background: linear-gradient(135deg, rgba(99,102,241,0.2), rgba(6,182,212,0.15));"></div>

                <!-- Card principal -->
                <div class="relative glass rounded-[2.5rem] p-1.5 shadow-2xl">
                    <div class="rounded-[2.2rem] overflow-hidden relative flex items-center justify-center aspect-square"
                         style="background: linear-gradient(135deg, #0d0f16 0%, #070810 100%);">

                        <!-- Grid overlay -->
                        <div class="absolute inset-0 opacity-20"
                             style="background-image: linear-gradient(rgba(99,102,241,0.1) 1px, transparent 1px), linear-gradient(90deg, rgba(99,102,241,0.1) 1px, transparent 1px); background-size: 30px 30px;"></div>

                        <img src="/assets/img/hero_elephant.png"
                             alt="PHP Elephant Mascot"
                             class="w-4/5 h-auto relative z-10 drop-shadow-[0_0_40px_rgba(99,102,241,0.5)] group-hover:scale-105 transition-transform duration-700"
                             style="mix-blend-mode: lighten;">
                    </div>
                </div>

                <!-- Badge: PHP Version -->
                <div class="absolute -top-4 -right-4 md:-right-8 glass px-4 py-3 rounded-2xl shadow-xl border-indigo-500/20"
                     style="animation: float1 4s ease-in-out infinite;">
                    <div class="flex items-center gap-2.5">
                        <div class="w-9 h-9 rounded-full flex items-center justify-center" style="background: rgba(99,102,241,0.15); border: 1px solid rgba(99,102,241,0.2);">
                            <i class="ph-fill ph-code text-lg text-indigo-400"></i>
                        </div>
                        <div>
                            <div class="section-label text-[8px]">PHP Core</div>
                            <div class="text-sm font-black text-white">v8.5 Ready</div>
                        </div>
                    </div>
                </div>

                <!-- Badge: Terminal -->
                <div class="absolute -bottom-4 -left-4 md:-left-8 glass px-4 py-3 rounded-2xl shadow-xl"
                     style="animation: float2 5s ease-in-out infinite;">
                    <div class="flex items-center gap-1.5 mb-1.5 pb-1.5 border-b border-white/10">
                        <span class="w-2 h-2 rounded-full bg-red-400"></span>
                        <span class="w-2 h-2 rounded-full bg-amber-400"></span>
                        <span class="w-2 h-2 rounded-full bg-green-400 animate-pulse"></span>
                        <span class="ml-1 text-[9px] tech-mono text-slate-500">bash</span>
                    </div>
                    <div class="tech-mono text-[11px]">
                        <span class="text-slate-600">$</span>
                        <span class="text-indigo-400"> php</span>
                        <span class="text-cyan-400"> main.php</span>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <style>
        @keyframes float1 { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-8px)} }
        @keyframes float2 { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-6px)} }
    </style>
</section>
