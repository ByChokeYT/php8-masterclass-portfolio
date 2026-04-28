<?php
declare(strict_types=1);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Business Identity | Masterclass PHP</title>
    <link rel="icon" type="image/x-icon" href="https://www.php.net/favicon.ico">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;700;900&family=JetBrains+Mono:wght@400;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <style>
        :root { --bg: #05070a; --cyan: #10b981; }
        body { background-color: var(--bg); color: #94a3b8; font-family: 'Outfit', sans-serif; min-height: 100vh; display: flex; align-items: center; justify-content: center; }
        .industrial-grid {
            position: fixed; inset: 0; z-index: -1;
            background-image: linear-gradient(rgba(255,255,255,0.01) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,0.01) 1px, transparent 1px);
            background-size: 40px 40px;
        }
        .tech-label { font-family: 'JetBrains Mono'; text-transform: uppercase; letter-spacing: 0.1em; font-size: 0.6rem; opacity: 0.4; }
        .glass-panel { background: rgba(13, 17, 23, 0.6); backdrop-filter: blur(20px); border: 1px solid rgba(255,255,255,0.05); }
        .input-industrial { background: rgba(0,0,0,0.4); border: 1px solid rgba(255,255,255,0.05); transition: all 0.2s; }
        .input-industrial:focus { border-color: var(--cyan); outline: none; box-shadow: 0 0 15px rgba(16, 185, 129, 0.05); }
        
        @keyframes shine { 0% { background-position: -200% -200%; } 100% { background-position: 200% 200%; } }
        
        .card-container { transition: transform 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275); }
        .card-container.updating { opacity: 0.7; transform: scale(0.98); }

        @media print {
            body { background: white !important; margin: 0; padding: 0; display: block; }
            .no-print { display: none !important; }
            .industrial-grid { display: none !important; }
            .business-card { 
                transform: none !important; 
                box-shadow: none !important; 
                border: 1px solid #ccc !important;
                background: #0d1117 !important;
                -webkit-print-color-adjust: exact;
                margin: 20mm auto;
            }
        }
    </style>
</head>
<body class="p-6">
    <div class="industrial-grid"></div>

    <div class="w-full max-w-6xl no-print">
        <div class="grid grid-cols-1 lg:grid-cols-[450px,1fr] gap-12 items-center">
            
            <!-- Editor Modular -->
            <section class="space-y-8">
                <header>
                    <div class="flex items-center gap-3 mb-4">
                        <div class="p-2 bg-emerald-500/10 rounded-lg border border-emerald-500/20"><i class="ph-bold ph-identification-card text-emerald-400 text-xl"></i></div>
                        <span class="tech-label">Operación // Modular_Identity_v19</span>
                    </div>
                    <h1 class="text-4xl font-black text-white uppercase tracking-tighter">Business <span class="text-emerald-400">Card</span></h1>
                </header>

                <div class="glass-panel p-8 rounded-[2rem]">
                    <form id="profileForm" class="space-y-5" enctype="multipart/form-data">
                        <input type="hidden" name="current_photo" id="currentPhoto">
                        
                        <div class="space-y-1.5">
                            <label class="tech-label ml-1">Retrato Profesional</label>
                            <input type="file" name="photo" id="photoInput" accept="image/*" class="w-full input-industrial px-4 py-2 rounded-xl text-white text-[10px] file:bg-emerald-500 file:border-none file:text-black file:font-bold file:px-3 file:py-1 file:rounded-md file:mr-4 file:cursor-pointer">
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div class="space-y-1.5">
                                <label class="tech-label ml-1">Identidad</label>
                                <input type="text" name="name" maxlength="25" placeholder="Tu Nombre" class="w-full input-industrial px-4 py-2.5 rounded-xl text-white text-xs">
                            </div>
                            <div class="space-y-1.5">
                                <label class="tech-label ml-1">Posición</label>
                                <input type="text" name="role" maxlength="30" placeholder="Cargo Pro" class="w-full input-industrial px-4 py-2.5 rounded-xl text-white text-xs">
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div class="space-y-1.5">
                                <label class="tech-label ml-1">Corporación</label>
                                <input type="text" name="company" maxlength="35" placeholder="Empresa" class="w-full input-industrial px-4 py-2.5 rounded-xl text-white text-xs">
                            </div>
                            <div class="space-y-1.5">
                                <label class="tech-label ml-1">Tono de Acento</label>
                                <input type="color" name="color" value="#10b981" class="w-full h-9 input-industrial p-1 rounded-xl cursor-pointer">
                            </div>
                        </div>

                        <div class="space-y-1.5">
                            <label class="tech-label ml-1">Email Corporativo</label>
                            <input type="email" name="email" placeholder="email@corporativo.com" class="w-full input-industrial px-4 py-2.5 rounded-xl text-white text-xs">
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div class="space-y-1.5">
                                <label class="tech-label ml-1">Terminal</label>
                                <input type="text" name="phone" placeholder="+00 000 000" class="w-full input-industrial px-4 py-2.5 rounded-xl text-white text-xs">
                            </div>
                            <div class="space-y-1.5">
                                <label class="tech-label ml-1">Web_Hub</label>
                                <input type="text" name="website" placeholder="www.sitio.com" class="w-full input-industrial px-4 py-2.5 rounded-xl text-white text-xs">
                            </div>
                        </div>
                    </form>
                    
                    <button id="printBtn" class="w-full mt-8 bg-emerald-500 hover:bg-emerald-400 text-black font-black py-4 rounded-xl text-[10px] uppercase tracking-[0.2em] transition-all shadow-[0_10px_30px_rgba(16,185,129,0.2)]">
                        <i class="ph-bold ph-printer mr-2"></i> Generar Impresión PDF
                    </button>
                    
                    <a href="../index.php" class="block text-center mt-6 tech-label hover:text-emerald-400 transition-colors">Volver al Portal Central</a>
                </div>
            </section>

            <!-- Preview Modular -->
            <section class="card-preview-area flex flex-col items-center justify-center">
                <div class="tech-label mb-8 flex items-center gap-2">
                    <div class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></div>
                    Sincronización Modular Activa
                </div>
                
                <div id="cardWrapper" class="card-container">
                    <!-- Inyección AJAX -->
                </div>

                <div class="mt-12 p-5 border border-white/5 rounded-2xl bg-white/2 text-[10px] font-mono text-center max-w-[320px] leading-relaxed opacity-40">
                    Arquitectura desacoplada: El renderizado se delega a <span class="text-emerald-400">CardRenderer.php</span> para asegurar escalabilidad y limpieza de código.
                </div>
            </section>
        </div>
    </div>

    <script>
        const form = document.getElementById('profileForm');
        const wrapper = document.getElementById('cardWrapper');
        const photoInput = document.getElementById('photoInput');
        const currentPhoto = document.getElementById('currentPhoto');

        const printBtn = document.getElementById('printBtn');

        const updateCard = async () => {
            const formData = new FormData(form);
            wrapper.classList.add('updating');
            
            try {
                const response = await fetch('handler.php', { method: 'POST', body: formData });
                const html = await response.text();
                wrapper.innerHTML = html;
            } catch (e) {
                console.error("Sync Error:", e);
            } finally {
                wrapper.classList.remove('updating');
            }
        };

        const printCard = () => {
            const cardHtml = wrapper.innerHTML;
            const printWindow = window.open('', '_blank', 'width=800,height=600');
            
            printWindow.document.write(`
                <html>
                <head>
                    <title>Impresión de Tarjeta Profesional</title>
                    <script src="https://cdn.tailwindcss.com"><\/script>
                    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;700;900&family=JetBrains+Mono:wght@400;700&display=swap" rel="stylesheet">
                    <script src="https://unpkg.com/@phosphor-icons/web"><\/script>
                    <style>
                        body { margin: 0; padding: 0; display: flex; align-items: center; justify-content: center; min-height: 100vh; background: white; font-family: 'Outfit', sans-serif; }
                        .business-card { 
                            transform: none !important; 
                            box-shadow: none !important; 
                            -webkit-print-color-adjust: exact !important; 
                            print-color-adjust: exact !important;
                            border: none !important;
                        }
                        @page { size: auto; margin: 0; }
                    </style>
                </head>
                <body>
                    ${cardHtml}
                    <script>
                        // Esperar a que los recursos (fuentes e imágenes) carguen
                        window.onload = () => {
                            setTimeout(() => {
                                window.print();
                                window.close();
                            }, 500);
                        };
                    <\/script>
                </body>
                </html>
            `);
            printWindow.document.close();
        };

        // Escuchar cambios
        form.addEventListener('input', (e) => {
            if (e.target.type !== 'file') updateCard();
        });

        photoInput.addEventListener('change', () => {
            const file = photoInput.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    currentPhoto.value = e.target.result;
                    updateCard();
                };
                reader.readAsDataURL(file);
            }
        });

        printBtn.addEventListener('click', printCard);

        // Inicializar
        updateCard();
    </script>
</body>
</html>
