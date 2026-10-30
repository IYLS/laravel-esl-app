/**
 * Script de inicialización
 * Configuración inicial y eventos del sistema
 */

// Inicializar popovers de Bootstrap
document.addEventListener('DOMContentLoaded', function() {
    const popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
    const popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
        return new bootstrap.Popover(popoverTriggerEl);
    });

    // Inicializar timer si está disponible
    if (typeof Timer !== 'undefined') {
        Timer.start();
    }
});