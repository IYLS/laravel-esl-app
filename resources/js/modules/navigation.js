/**
 * Módulo de navegación
 * Maneja la navegación entre ejercicios, secciones y unidades
 */
const Navigation = {
    /**
     * Navega según el tipo especificado
     * @param {string} uri - URI o identificador de destino
     * @param {string} type - Tipo de navegación (unit, section, exercise)
     * @param {string} currentExerciseUrl - URL del ejercicio actual
     */
    goTo(uri, type, currentExerciseUrl) {
        switch (type) {
            case 'unit':
                if (uri) {
                    window.location.href = uri;
                } else {
                    window.location.reload();
                }
                break;

            case 'section':
                this.switchToTab(uri, 'section');
                break;

            case 'exercise':
                this.switchToTab(uri, 'exercise', currentExerciseUrl);
                break;
        }

        // Cerrar modal
        const modal = document.getElementById('alert-modal');
        if (modal) {
            $('#alert-modal').modal('hide');
        }
    },

    /**
     * Cambia a una pestaña específica
     * @param {string} targetId - ID de la pestaña objetivo
     * @param {string} type - Tipo de pestaña (section o exercise)
     * @param {string} currentId - ID de la pestaña actual (solo para exercises)
     */
    switchToTab(targetId, type, currentId = null) {
        const targetButton = document.querySelector(`button#${targetId}-tab`);
        const activeButton = currentId 
            ? document.querySelector(`button#${currentId}-tab`)
            : document.querySelector(`button.${type}-btn.active`);

        const targetPane = document.querySelector(`div#${targetId}`);
        const activePane = currentId
            ? document.querySelector(`div#${currentId}`)
            : document.querySelector(`div.${type}-pane.active`);

        if (activeButton && targetButton) {
            activeButton.classList.remove('active');
            targetButton.classList.add('active');
        }

        if (activePane && targetPane) {
            activePane.classList.remove('active', 'show');
            targetPane.classList.add('show', 'active');
        }

        // Hacer click en el botón para activar el cambio de pestaña
        if (targetButton) {
            targetButton.click();
        }
    }
};

// Exportar
if (typeof module !== 'undefined' && module.exports) {
    module.exports = Navigation;
}