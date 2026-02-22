document.addEventListener('DOMContentLoaded', () => {
    // Interacción suave en inputs
    const inputs = document.querySelectorAll('input, select');

    inputs.forEach(input => {
        input.addEventListener('focus', () => {
            input.parentElement.classList.add('focused');
        });

        input.addEventListener('blur', () => {
            input.parentElement.classList.remove('focused');
        });
    });

    // Simular carga en el botón
    const form = document.querySelector('form');
    const btn = document.querySelector('.btn-primary');

    form.addEventListener('submit', () => {
        const originalContent = btn.innerHTML;
        btn.innerHTML = '<i class="ph-bold ph-spinner ph-spin"></i> PROCESANDO...';
        btn.style.opacity = '0.8';
        // No prevenimos el envío real, solo cambiamos el estado visual
    });
});
