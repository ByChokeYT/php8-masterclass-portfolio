<?php
declare(strict_types=1);

/**
 * Patrón DTO (Data Transfer Object) usando clases readonly de PHP 8.2+
 * Garantiza inmutabilidad y tipado estricto para los datos de la vista.
 */
readonly class Service {
    public function __construct(
        public string $id,
        public string $title,
        public string $description,
        public string $icon,
        public string $imageUrl,
        public string $colorClass,
        public string $bgClass
    ) {}
}

readonly class Testimonial {
    public function __construct(
        public string $name,
        public string $role,
        public string $content,
        public string $avatarUrl
    ) {}
}

readonly class Stat {
    public function __construct(
        public string $value,
        public string $label
    ) {}
}

// ==========================================
// ⚙️ DATOS DINÁMICOS (Data Layer) - TORNERÍA
// ==========================================

$heroConfig = [
    'badge' => '🔩 Precisión Industrial',
    'title' => 'Mecanizado y Tornería',
    'highlight' => 'de Alta Precisión',
    'description' => 'Fabricamos y reparamos piezas metálicas bajo estrictos estándares de calidad. Especialistas en aceros, bronce y aluminio para la minería, industria y automotriz.',
    'primaryBtn' => 'Solicitar Cotización',
    'secondaryBtn' => 'Ver Trabajos'
];

$stats = [
    new Stat('+25k', 'Piezas Fabricadas'),
    new Stat('0.01mm', 'Tolerancia Máxima'),
    new Stat('15', 'Años de Experiencia'),
    new Stat('350+', 'Clientes Industriales')
];

$services = [
    new Service(
        id: 'embragues',
        title: 'Prensas de Embrague',
        description: 'Reparaciones integrales de prensas de embrague para línea pesada: Volvo, Mercedes, Scania, Nissan, Volkswagen y más.',
        icon: 'ph-disc',
        imageUrl: 'img/cnc.png',
        colorClass: 'text-cyan-400',
        bgClass: 'bg-cyan-400/10'
    ),
    new Service(
        id: 'mecanica',
        title: 'Reconstrucción de Ejes',
        description: 'Reconstrucción precisa de muñones, puntas de ejes y bujes. Cambio de chicotillos (acelerador, freno de mano, embrague, caja).',
        icon: 'ph-wrench',
        imageUrl: 'img/fresado.png',
        colorClass: 'text-blue-500',
        bgClass: 'bg-blue-500/10'
    ),
    new Service(
        id: 'mangueras',
        title: 'Prensado de Mangueras',
        description: 'Prensado y cambio de mangueras hidráulicas e industriales de alta, media y baja presión garantizado.',
        icon: 'ph-wave-sine',
        imageUrl: 'img/mantenimiento.png',
        colorClass: 'text-indigo-400',
        bgClass: 'bg-indigo-400/10'
    ),
    new Service(
        id: 'soldadura',
        title: 'Soldadura y Tornería General',
        description: 'Soldaduras especiales al arco y oxígeno. Trabajos de tornería en general (roscas, ejes, poleas) para cualquier maquinaria.',
        icon: 'ph-fire',
        imageUrl: 'img/soldadura.png',
        colorClass: 'text-sky-400',
        bgClass: 'bg-sky-400/10'
    )
];

$testimonials = [
    new Testimonial(
        name: 'Roberto Daza',
        role: 'Ingeniero de Mina @ OruroMetals',
        content: '"Reconstruyeron un eje de trituradora que nadie más quería tocar. Funciona mejor que el repuesto original y en tiempo récord."',
        avatarUrl: 'https://ui-avatars.com/api/?name=Roberto+Daza&background=FF8A65&color=fff&size=128'
    ),
    new Testimonial(
        name: 'Carlos Yavi',
        role: 'Gerente Mantenimiento Flota',
        content: '"Las piezas en serie de bronce requerían una tolerancia mínima. Cumplieron con los estándares de la automotriz a la perfección."',
        avatarUrl: 'https://ui-avatars.com/api/?name=Carlos+Yavi&background=F57C00&color=fff&size=128'
    ),
    new Testimonial(
        name: 'Julio Miranda',
        role: 'Constructora JM',
        content: '"Es nuestra tornería de confianza para todos los proyectos grandes. Su precisión CNC nos ahorra miles en ensamblaje rápido."',
        avatarUrl: 'https://ui-avatars.com/api/?name=Julio+Miranda&background=E65100&color=fff&size=128'
    )
];
?>
<!DOCTYPE html>
<html lang="es" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tornería Samuel | Mecanizado Industrial en Oruro</title>
    
    <!-- Meta SEO Basico -->
    <meta name="description" content="Taller de tornería y mecanizado industrial. Torno CNC, fresadora y fabricación de repuestos de alta precisión.">
    <link rel="icon" type="image/x-icon" href="https://www.php.net/favicon.ico">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        metalDark: '#0B1120',     /* Deep Slate */
                        metalMedium: '#1E293B',   /* Slate 800 */
                        metalLight: '#334155',    /* Slate 700 */
                        steelBlue: '#38BDF8',     /* Sky 400 */
                        industrialCyan: '#06B6D4' /* Cyan 500 */
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        display: ['Outfit', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Outfit:wght@400;700;900&display=swap" rel="stylesheet">
    
    <!-- Phosphor Icons -->
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    
    <!-- Custom CSS para estética industrial pesada -->
    <style>
        body {
            background-color: #020617; /* Slate 950 */
            color: #f1f5f9; /* Slate 100 */
            background-image: 
                linear-gradient(rgba(2, 6, 23, 0.92), rgba(2, 6, 23, 0.97)),
                url('img/hero.png'); 
            background-size: cover;
            background-attachment: fixed;
            background-position: center;
        }

        .industrial-panel {
            background: linear-gradient(145deg, rgba(30, 41, 59, 0.8), rgba(15, 23, 42, 0.9));
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            border: 1px solid rgba(56, 189, 248, 0.15); /* Borde Steel Blue Sutil */
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.5), inset 0 1px 0 rgba(255,255,255,0.05);
        }

        .text-steel-gradient {
            background-clip: text;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-image: linear-gradient(to right, #7DD3FC, #38BDF8, #0EA5E9);
        }

        /* Efecto luz arco voltaico */
        .spark-glow {
            box-shadow: 0 0 20px rgba(56, 189, 248, 0.4);
        }

        /* Grilla de fondo metálico */
        .metal-grid {
            background-image: linear-gradient(rgba(56, 189, 248, 0.03) 1px, transparent 1px),
            linear-gradient(90deg, rgba(56, 189, 248, 0.03) 1px, transparent 1px);
            background-size: 40px 40px;
        }

        @keyframes slideIn {
            from { opacity: 0; transform: translateX(-30px); }
            to { opacity: 1; transform: translateX(0); }
        }
        
        .animate-slide-in {
            animation: slideIn 0.7s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            opacity: 0;
        }

        /* Marquesina (Carousel) infinita para marcas */
        @keyframes scroll {
            0% { transform: translateX(0); }
            100% { transform: translateX(calc(-250px * 7)); }
        }
        
        .slider {
            background: rgba(15, 23, 42, 0.95);
            box-shadow: 0 10px 20px -5px rgba(0, 0, 0, 0.5);
            height: 80px;
            margin: auto;
            overflow: hidden;
            position: relative;
            width: 100%;
            border-top: 1px solid rgba(56, 189, 248, 0.2);
            border-bottom: 1px solid rgba(56, 189, 248, 0.2);
        }
        
        .slider::before,
        .slider::after {
            background: linear-gradient(to right, rgba(2,6,23,1) 0%, rgba(255,255,255,0) 100%);
            content: "";
            height: 80px;
            position: absolute;
            width: 150px;
            z-index: 2;
        }
        
        .slider::after {
            right: 0;
            top: 0;
            transform: rotateZ(180deg);
        }
        
        .slider::before {
            left: 0;
            top: 0;
        }
        
        .slide-track {
            animation: scroll 30s linear infinite;
            display: flex;
            width: calc(250px * 14);
        }
        
        .slide {
            height: 80px;
            width: 250px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Outfit', sans-serif;
            font-size: 1.5rem;
            font-weight: 900;
            color: #334155;
            text-transform: uppercase;
            letter-spacing: 2px;
            transition: color 0.3s ease;
        }
        
        .slide:hover {
            color: #38BDF8;
            text-shadow: 0 0 10px rgba(56, 189, 248, 0.5);
        }

        .delay-100 { animation-delay: 100ms; }

        .delay-200 { animation-delay: 200ms; }
        .delay-300 { animation-delay: 300ms; }
    </style>
</head>
<body class="font-sans antialiased text-slate-300 min-h-screen flex flex-col overflow-x-hidden selection:bg-steelBlue selection:text-slate-900">

    <!-- Línea superior de acero frío decorativa -->
    <div class="h-1 w-full bg-gradient-to-r from-cyan-400 via-sky-500 to-blue-600"></div>

    <!-- Navbar -->
    <nav class="fixed w-full z-50 transition-all duration-300 mt-1 border-b border-white/5" id="navbar">
        <div class="max-w-7xl mx-auto px-6 h-20 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="bg-gradient-to-br from-cyan-400 to-blue-600 p-2 rounded flex items-center justify-center border border-white/10 shadow-[0_0_15px_rgba(56,189,248,0.3)]">
                    <i class="ph-bold ph-gear text-2xl text-slate-900 animate-[spin_10s_linear_infinite]"></i>
                </div>
                <span class="font-display font-black text-2xl tracking-tighter text-white uppercase">
                    Tornería<span class="text-steelBlue">Samuel</span>
                </span>
            </div>
            
            <div class="hidden md:flex items-center gap-8 font-medium text-sm tracking-wide">
                <a href="#inicio" class="hover:text-steelBlue transition-colors uppercase">Taller</a>
                <a href="#identidad" class="hover:text-steelBlue transition-colors uppercase">Nuestra Alma</a>
                <a href="#servicios" class="hover:text-steelBlue transition-colors uppercase">Capacidad</a>
                <a href="#testimonios" class="hover:text-steelBlue transition-colors uppercase">Clientes</a>
                <a href="#contacto" class="px-6 py-2 border-2 border-steelBlue text-steelBlue font-bold hover:bg-steelBlue hover:text-slate-900 transition-all uppercase shadow-[0_0_10px_rgba(56,189,248,0.2)]">
                    Cotizar Pieza
                </a>
            </div>
            
            <button class="md:hidden text-2xl text-steelBlue hover:text-white transition-colors">
                <i class="ph-bold ph-list"></i>
            </button>
        </div>
    </nav>

    <main class="flex-grow pt-24 metal-grid">
        <!-- Hero Section -->
        <section id="inicio" class="relative pt-20 pb-24 overflow-hidden flex flex-col items-center text-center px-6">
            
            <div class="inline-flex items-center gap-2 px-4 py-1.5 border border-sky-400/50 bg-sky-400/10 text-sky-400 text-xs font-bold uppercase tracking-widest mb-8 animate-slide-in shadow-[0_0_10px_rgba(56,189,248,0.15)]">
                <i class="ph-fill ph-crosshair"></i> <?= htmlspecialchars($heroConfig['badge']) ?>
            </div>

            <h1 class="font-display text-5xl md:text-7xl font-black text-white max-w-5xl tracking-tight leading-[1.1] mb-6 animate-slide-in delay-100 uppercase">
                <?= htmlspecialchars($heroConfig['title']) ?> <br>
                <span class="text-steel-gradient"><?= htmlspecialchars($heroConfig['highlight']) ?></span>
            </h1>

            <p class="text-lg md:text-xl text-slate-400 max-w-3xl mb-12 animate-slide-in delay-200 leading-relaxed">
                <?= htmlspecialchars($heroConfig['description']) ?>
            </p>

            <div class="flex flex-col sm:flex-row gap-5 w-full sm:w-auto animate-slide-in delay-300">
                <a href="#contacto" class="group relative px-8 py-4 bg-gradient-to-r from-sky-400 to-blue-600 text-slate-900 font-extrabold text-lg uppercase tracking-wider overflow-hidden transition-all hover:scale-105 active:scale-95 flex items-center justify-center gap-2 spark-glow">
                    <i class="ph-bold ph-shield-check"></i> <?= htmlspecialchars($heroConfig['primaryBtn']) ?>
                </a>
                <a href="#servicios" class="px-8 py-4 bg-slate-800 text-white font-bold text-lg border border-slate-600 uppercase tracking-wider transition-all hover:bg-slate-700 active:scale-95 flex items-center justify-center">
                    <?= htmlspecialchars($heroConfig['secondaryBtn']) ?>
                </a>
            </div>

            <!-- Stats Bar -->
            <div class="mt-24 w-full max-w-6xl grid grid-cols-2 md:grid-cols-4 gap-6 animate-slide-in" style="animation-delay: 400ms;">
                <?php foreach ($stats as $stat): ?>
                <div class="industrial-panel rounded bg-slate-900/50 p-6 text-center border-b-4 border-b-sky-500/30 hover:border-b-sky-400 hover:-translate-y-1 transition-all">
                    <div class="font-display text-4xl md:text-5xl font-black text-white mb-2"><?= htmlspecialchars($stat->value) ?></div>
                    <div class="text-xs md:text-sm font-bold text-sky-400 uppercase tracking-widest"><?= htmlspecialchars($stat->label) ?></div>
                </div>
                <?php endforeach; ?>
            </div>
        </section>

        <!-- Carousel / Marquesina de Marcas de Transporte Pesado -->
        <div class="slider relative z-20">
            <div class="slide-track">
                <!-- Se repite 2 veces para animación infinita -->
                <div class="slide"><i class="ph-fill ph-truck mr-2"></i> VOLVO</div>
                <div class="slide"><i class="ph-fill ph-truck mr-2"></i> SCANIA</div>
                <div class="slide"><i class="ph-fill ph-truck mr-2"></i> MERCEDES-BENZ</div>
                <div class="slide"><i class="ph-fill ph-truck mr-2"></i> NISSAN</div>
                <div class="slide"><i class="ph-fill ph-truck mr-2"></i> VOLKSWAGEN</div>
                <div class="slide"><i class="ph-fill ph-truck mr-2"></i> HINO</div>
                <div class="slide"><i class="ph-fill ph-truck mr-2"></i> MITSUBISHI FUSO</div>
                
                <div class="slide"><i class="ph-fill ph-truck mr-2"></i> VOLVO</div>
                <div class="slide"><i class="ph-fill ph-truck mr-2"></i> SCANIA</div>
                <div class="slide"><i class="ph-fill ph-truck mr-2"></i> MERCEDES-BENZ</div>
                <div class="slide"><i class="ph-fill ph-truck mr-2"></i> NISSAN</div>
                <div class="slide"><i class="ph-fill ph-truck mr-2"></i> VOLKSWAGEN</div>
                <div class="slide"><i class="ph-fill ph-truck mr-2"></i> HINO</div>
                <div class="slide"><i class="ph-fill ph-truck mr-2"></i> MITSUBISHI FUSO</div>
            </div>
        </div>

        <!-- Divider tipo metal rallado -->
        <div class="h-2 w-full bg-[repeating-linear-gradient(45deg,transparent,transparent_10px,rgba(56,189,248,0.1)_10px,rgba(56,189,248,0.1)_20px)] border-y border-slate-800"></div>

        <!-- Identidad Section (El Alma de la Tornería) -->
        <section id="identidad" class="py-24 px-6 bg-slate-900/40 relative overflow-hidden">
            <!-- Círculo de luz decorativo metálico -->
            <div class="absolute -left-40 top-20 w-96 h-96 bg-sky-500/10 rounded-full blur-3xl pointer-events-none"></div>

            <div class="max-w-7xl mx-auto flex flex-col md:flex-row items-center gap-16 relative z-10">
                <div class="w-full md:w-1/2">
                    <div class="inline-flex items-center gap-2 text-sky-400 font-bold uppercase tracking-widest text-sm mb-4">
                        <i class="ph-bold ph-fingerprint"></i> El Alma del Taller
                    </div>
                    <h2 class="font-display text-4xl md:text-5xl font-black text-white uppercase mb-6 leading-tight">
                        Forjamos <span class="text-steel-gradient">Soluciones</span>, No Solo Metal
                    </h2>
                    <p class="text-slate-400 text-lg leading-relaxed mb-6">
                        Detrás del ruido de los tornos y el calor de las soldaduras, existe una filosofía inquebrantable. Creemos que la industria no se detiene, y por eso, nosotros tampoco. Cada pieza de acero que mecanizamos lleva nuestra firma de garantía, tolerancia cero al error y un compromiso absoluto con tus tiempos de inactividad.
                    </p>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mt-8">
                        <div class="flex gap-4">
                            <i class="ph-fill ph-check-circle text-sky-400 text-2xl shrink-0 mt-1"></i>
                            <div>
                                <h4 class="text-white font-bold uppercase text-sm mb-1">Cero Margen de Error</h4>
                                <p class="text-slate-400 text-sm">Mediciones milimétricas con instrumentos calibrados ISO.</p>
                            </div>
                        </div>
                        <div class="flex gap-4">
                            <i class="ph-fill ph-clock text-sky-400 text-2xl shrink-0 mt-1"></i>
                            <div>
                                <h4 class="text-white font-bold uppercase text-sm mb-1">Respuesta Crítica</h4>
                                <p class="text-slate-400 text-sm">Atención 24/7 para emergencias de paradas de planta.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="w-full md:w-1/2 inline-flex justify-center">
                   <div class="relative p-2 rounded-xl bg-gradient-to-tr from-sky-500/20 to-blue-600/20 border border-white/5 shadow-2xl">
                       <img src="img/fresado.png" alt="Esencia Industrial" class="rounded-lg shadow-2xl opacity-90 object-cover h-[450px] w-full">
                       <!-- Capa de brillo superior -->
                       <div class="absolute inset-0 bg-gradient-to-b from-white/5 to-transparent rounded-lg pointer-events-none"></div>
                   </div>
                </div>
            </div>
        </section>

        <!-- Servicios Section -->
        <section id="servicios" class="py-32 px-6 bg-slate-950/90 relative">
            <div class="max-w-7xl mx-auto z-10 relative">
                <div class="mb-16 border-l-4 border-sky-400 pl-6">
                    <h2 class="font-display text-4xl md:text-5xl font-black text-white uppercase mb-2">Capacidad Operativa</h2>
                    <p class="text-slate-400 text-lg max-w-2xl">Maquinaria pesada y personal altamente cualificado para resolver los problemas mecánicos más exigentes de la industria.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <?php foreach ($services as $key => $service): ?>
                        <div class="industrial-panel group hover:border-sky-400/50 transition-all duration-300 relative overflow-hidden flex flex-col h-full rounded">
                            
                            <!-- Imagen de fondo/cabecera del servicio -->
                            <div class="h-48 w-full relative overflow-hidden border-b border-sky-400/20">
                                <img src="<?= htmlspecialchars($service->imageUrl) ?>" alt="<?= htmlspecialchars($service->title) ?>" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 opacity-70 group-hover:opacity-100 mix-blend-luminosity hover:mix-blend-normal">
                                <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-slate-900/40 to-transparent"></div>
                                <div class="absolute bottom-4 left-4 w-12 h-12 bg-slate-900/90 backdrop-blur-md rounded flex items-center justify-center <?= htmlspecialchars($service->colorClass) ?> border border-slate-700 shadow-[0_0_15px_rgba(56,189,248,0.2)]">
                                    <i class="<?= htmlspecialchars($service->icon) ?> text-2xl spark-glow"></i>
                                </div>
                            </div>

                            <div class="p-6 relative z-10 flex-grow flex flex-col bg-slate-900/50">
                                <h3 class="font-display text-xl font-bold text-white mb-3 uppercase tracking-wide"><?= htmlspecialchars($service->title) ?></h3>
                                <p class="text-slate-400 text-sm leading-relaxed flex-grow"><?= htmlspecialchars($service->description) ?></p>
                                
                                <div class="mt-6 pt-4 border-t border-slate-800">
                                    <a href="#contacto" class="inline-flex items-center gap-2 text-xs font-bold text-slate-500 hover:text-sky-400 transition-colors uppercase tracking-wider">
                                        Detalles Técnicos <i class="ph-bold ph-arrow-circle-right text-sky-400 text-base"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <!-- Testimonios Section -->
        <section id="testimonios" class="py-24 px-6 relative border-t border-slate-800 bg-slate-900/50">
            <div class="max-w-7xl mx-auto">
                <h2 class="font-display text-3xl md:text-4xl font-black text-center text-white uppercase mb-16">
                    Respaldados por la <span class="text-steel-gradient">Industria</span>
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <?php foreach ($testimonials as $testimonial): ?>
                        <div class="industrial-panel p-8 relative rounded-lg border-t-2 border-t-sky-500/30">
                            <!-- Tornillos decorativos mecánicos -->
                            <div class="absolute top-4 left-4 w-2.5 h-2.5 rounded-full bg-slate-400 border border-slate-600 shadow-inner flex items-center justify-center"><div class="w-full h-[1px] bg-slate-600 rotate-45"></div></div>
                            <div class="absolute top-4 right-4 w-2.5 h-2.5 rounded-full bg-slate-400 border border-slate-600 shadow-inner flex items-center justify-center"><div class="w-full h-[1px] bg-slate-600 rotate-12"></div></div>
                            
                            <div class="mb-8 mt-4">
                                <i class="ph-fill ph-quotes text-4xl text-sky-500/30 mb-4 block"></i>
                                <p class="text-slate-300 font-medium leading-relaxed">
                                    <?= htmlspecialchars($testimonial->content) ?>
                                </p>
                            </div>
                            <div class="flex items-center gap-4 bg-slate-800/80 p-4 -mx-8 -mb-8 border-t border-slate-700/50 rounded-b-lg">
                                <img src="<?= htmlspecialchars($testimonial->avatarUrl) ?>" alt="Avatar" class="w-12 h-12 rounded bg-slate-800 mix-blend-luminosity hover:mix-blend-normal transition-all duration-300 ring-2 ring-sky-500/20">
                                <div>
                                    <div class="font-bold text-white uppercase tracking-wide text-sm"><?= htmlspecialchars($testimonial->name) ?></div>
                                    <div class="text-xs text-sky-400 font-medium"><?= htmlspecialchars($testimonial->role) ?></div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section id="contacto" class="py-32 px-6 relative">
            <div class="max-w-5xl mx-auto bg-gradient-to-r from-cyan-500 to-blue-700 rounded-lg p-1 shadow-2xl relative">
                <!-- Marco tipo pieza maquinada CNC -->
                <div class="bg-slate-950 p-10 md:p-16 text-center h-full w-full rounded-md relative overflow-hidden">
                    <div class="absolute w-[200%] h-[200%] top-[-50%] left-[-50%] bg-[conic-gradient(from_0deg_at_50%_50%,rgba(56,189,248,0.1)_0deg,transparent_60deg,transparent_300deg,rgba(56,189,248,0.1)_360deg)] animate-[spin_8s_linear_infinite] pointer-events-none"></div>

                    <div class="relative z-10">
                        <i class="ph-fill ph-cube focus text-6xl text-sky-400 mb-6 drop-shadow-[0_0_15px_rgba(56,189,248,0.5)]"></i>
                        <h2 class="font-display text-4xl md:text-5xl font-black text-white mb-6 uppercase tracking-tight">¿Tienes un plano y una urgencia?</h2>
                        <p class="text-slate-400 text-lg mb-10 max-w-2xl mx-auto">Envíanos tolerancias y materiales (Acero Inoxidable, Bronce SAE, etc.). Cotizamos en el mismo día y despachamos piezas terminadas a todo el país.</p>
                        
                        <form class="max-w-md mx-auto flex flex-col gap-4">
                            <input type="text" placeholder="Proyecto (Ej: Eje Tratamiento Térmico)" required class="w-full bg-slate-900/80 border-2 border-slate-700 rounded px-4 py-4 text-white placeholder:text-slate-500 focus:outline-none focus:border-sky-400 focus:ring-1 focus:ring-sky-400 transition-all uppercase font-mono text-sm shadow-inner">
                            <button type="button" onclick="alert('Sistema Tornería: Protocolo de cotización iniciado.')" class="w-full bg-gradient-to-r from-sky-400 to-blue-600 hover:from-sky-300 hover:to-blue-500 text-white font-black text-lg py-4 rounded transition-colors uppercase tracking-widest spark-glow flex items-center justify-center gap-2 shadow-lg">
                                <i class="ph-bold ph-envelope-simple-open"></i> Iniciar Orden
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- Mapa GPS (Av. Circunvalación final montecinos, Oruro) -->
        <section class="h-96 w-full border-t border-b border-sky-500/20 relative grayscale hover:grayscale-0 transition-all duration-700">
            <!-- Capa protectora overlay para evitar scroll accidental -->
            <div class="absolute inset-0 bg-slate-950/20 pointer-events-none z-10"></div>
            <!-- iFrame embed de Google Maps apuntando a Oruro, Bolivia near Circunvalación -->
            <iframe 
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3795.539744654876!2d-67.112!3d-17.962!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0!2sAv%20Circunvalacion%2C%20Oruro%2C%20Bolivia!5e0!3m2!1ses!2sbo!4v1710000000000!5m2!1ses!2sbo" 
                width="100%" 
                height="100%" 
                style="border:0;" 
                allowfullscreen="" 
                loading="lazy" 
                referrerpolicy="no-referrer-when-downgrade"
                class="absolute inset-0 z-0">
            </iframe>
        </section>
    </main>

    <!-- Footer -->
    <footer class="bg-slate-950 py-12 px-6">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-start md:items-center gap-8">
            <div class="flex flex-col gap-3">
                <div class="flex items-center gap-3">
                    <i class="ph-fill ph-map-pin text-sky-400 text-xl"></i>
                    <span class="font-medium text-slate-400 tracking-wider font-display text-sm">Av. Circunvalación final Montecinos, Oruro</span>
                </div>
                <div class="flex items-center gap-3">
                    <i class="ph-fill ph-user-gear text-sky-400 text-xl"></i>
                    <span class="font-medium text-slate-400 tracking-wider font-display text-sm">Samuel Chambi - Propietario</span>
                </div>
                <div class="flex items-center gap-3">
                    <i class="ph-fill ph-phone text-sky-400 text-xl"></i>
                    <span class="font-medium text-slate-400 tracking-wider font-display text-sm">Cel: <a href="tel:72318777" class="hover:text-sky-400 transition-colors">72318777</a></span>
                </div>
            </div>
            <div class="text-left md:text-right">
                <div class="flex items-center gap-2 justify-start md:justify-end mb-2">
                    <i class="ph-fill ph-check-square-offset text-sky-400 text-xl"></i>
                    <span class="font-medium text-slate-500 tracking-wider font-display">TORNERÍA SAMUEL &copy; <?= date('Y') ?></span>
                </div>
                <div class="text-slate-600 text-sm font-mono tracking-widest">
                    [ PRECISIÓN Y CALIDAD GARANTIZADA ]
                </div>
            </div>
        </div>
    </footer>

    <script>
        window.addEventListener('scroll', () => {
            const navbar = document.getElementById('navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('bg-slate-950/95', 'shadow-2xl');
                navbar.classList.remove('mt-1');
            } else {
                navbar.classList.remove('bg-slate-950/95', 'shadow-2xl');
                navbar.classList.add('mt-1');
            }
        });
    </script>
</body>
</html>
