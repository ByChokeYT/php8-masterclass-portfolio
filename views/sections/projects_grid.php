<?php
/**
 * projects_grid.php — Grid Interactivo de Proyectos
 * Usa Vue.js 3 (CDN) para filtrar proyectos por Fase sin recargar la página.
 * 
 * @var array $projects  Generado por ProjectScanner
 * @var array $phases    Generado por ProjectRepository::getPhases()
 */
$projectsJson = json_encode(array_map(fn($p) => [
    'id'         => $p['id'],
    'day'        => $p['day'],
    'title'      => $p['title'],
    'description'=> $p['description'],
    'tags'       => $p['tags'],
    'path'       => $p['path'],
    'phase_id'   => $p['phase_id'],
    'phase_title'=> $p['phase']['title'] ?? '',
    'phase_color'=> $p['phase']['color'] ?? '#6366f1',
    'icon'       => $p['icon'] ?? 'devicon-php-plain',
    'difficulty' => $p['phase']['difficulty'] ?? 'Inicial',
], $projects), JSON_UNESCAPED_UNICODE);
?>

<section id="proyectos" class="py-32 relative">

    <div class="max-w-7xl mx-auto px-6">

        <!-- Header de la sección -->
        <div class="text-center mb-16" data-aos="fade-up">
            <div class="section-label mb-4">Laboratorio de Código</div>
            <h2 class="text-4xl md:text-5xl font-black text-white tracking-tight mb-5">
                <?= count($projects) ?> Proyectos <span class="grad-text">Listos para Estudiar</span>
            </h2>
            <p class="text-slate-400 max-w-2xl mx-auto text-lg leading-relaxed">
                Cada proyecto tiene su propio manual pedagógico interactivo con árbol de carpetas, explorador de código y simulación de ejecución.
            </p>
        </div>

        <!-- Vue.js App: Filtros + Grid -->
        <div id="projects-app" v-cloak>

            <!-- Filtros por Fase -->
            <div class="flex flex-wrap justify-center gap-3 mb-12" data-aos="fade-up" data-aos-delay="100">
                <button @click="activeFilter = null"
                        :class="activeFilter === null ? 'bg-indigo-600 text-white border-indigo-600' : 'text-slate-400 border-white/10 hover:border-indigo-500/40 hover:text-white'"
                        class="px-5 py-2 rounded-xl border text-xs font-bold uppercase tracking-widest transition-all">
                    Todos ({{ projects.length }})
                </button>
                <?php foreach ($phases as $id => $phase): ?>
                <button @click="activeFilter = <?= $id ?>"
                        :class="activeFilter === <?= $id ?> ? 'text-white' : 'text-slate-400 border-white/10 hover:text-white'"
                        :style="activeFilter === <?= $id ?> ? 'background-color: <?= $phase['color'] ?>; border-color: <?= $phase['color'] ?>' : ''"
                        class="px-5 py-2 rounded-xl border text-xs font-bold uppercase tracking-widest transition-all hover:border-white/20">
                    <span class="mr-1"><?= $phase['emoji'] ?></span>
                    F<?= $id ?>: <?= $phase['title'] ?> ({{ phaseCount(<?= $id ?>) }})
                </button>
                <?php endforeach; ?>
            </div>

            <!-- Grid de Proyectos -->
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                <a v-for="project in filteredProjects"
                   :key="project.id"
                   :href="project.path"
                   class="glass rounded-2xl p-5 group cursor-pointer block no-underline"
                   data-aos="fade-up">

                    <!-- Header de la card -->
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex items-center gap-3">
                            <!-- Ícono Devicon -->
                            <div class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0"
                                 style="background: rgba(99,102,241,0.1); border: 1px solid rgba(99,102,241,0.15);">
                                <i :class="project.icon + ' text-xl text-indigo-400'" class="colored"></i>
                            </div>
                            <!-- Número del día -->
                            <div>
                                <div class="tech-mono text-[10px] text-slate-500 font-bold uppercase tracking-widest">Día {{ String(project.day).padStart(2,'0') }}</div>
                                <div class="text-white font-bold text-sm leading-tight">{{ project.title }}</div>
                            </div>
                        </div>
                        <!-- Arrow -->
                        <div class="w-8 h-8 rounded-lg flex items-center justify-center text-slate-600 group-hover:text-indigo-400 group-hover:bg-indigo-500/10 transition-all shrink-0">
                            <i class="ph-bold ph-arrow-up-right"></i>
                        </div>
                    </div>

                    <!-- Descripción -->
                    <p class="text-slate-500 text-sm leading-relaxed mb-4 line-clamp-2">{{ project.description }}</p>

                    <!-- Footer: Fase + Tags -->
                    <div class="flex items-center justify-between pt-3 border-t border-white/5">
                        <div class="flex items-center gap-1.5">
                            <span class="w-2 h-2 rounded-full shrink-0" :style="'background-color: ' + project.phase_color"></span>
                            <span class="tech-mono text-[9px] text-slate-500 font-bold uppercase tracking-widest">{{ project.phase_title }}</span>
                        </div>
                        <div class="flex gap-1.5 flex-wrap justify-end">
                            <span v-for="tag in project.tags.slice(0,2)" :key="tag" class="tag-chip">{{ tag }}</span>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Estado vacío -->
            <div v-if="filteredProjects.length === 0" class="text-center py-16 text-slate-600">
                <i class="ph-bold ph-folder-open text-5xl mb-4 block"></i>
                <p class="font-bold">No hay proyectos en esta fase aún.</p>
            </div>

        </div><!-- /vue app -->

    </div>
</section>

<script>
(function() {
    // Esperar a que Vue esté disponible
    function initApp() {
        if (typeof Vue === 'undefined') {
            setTimeout(initApp, 100);
            return;
        }
        const { createApp, ref, computed } = Vue;
        createApp({
            setup() {
                const projects     = ref(<?= $projectsJson ?>);
                const activeFilter = ref(null);

                const filteredProjects = computed(() => {
                    if (activeFilter.value === null) return projects.value;
                    return projects.value.filter(p => p.phase_id === activeFilter.value);
                });

                const phaseCount = (phaseId) => projects.value.filter(p => p.phase_id === phaseId).length;

                return { projects, activeFilter, filteredProjects, phaseCount };
            }
        }).mount('#projects-app');
    }
    document.addEventListener('DOMContentLoaded', initApp);
})();
</script>
