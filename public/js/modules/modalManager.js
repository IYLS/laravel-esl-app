/**
 * Módulo de gestión de modales
 * Maneja la creación y presentación de modales
 */
const ModalManager = {
    /**
     * Presenta el modal de finalización de ejercicio
     * @param {string} feedbackMessage - Mensaje de feedback
     * @param {string} statusMessage - Mensaje de estado
     * @param {string} url - URL de navegación
     * @param {string} type - Tipo de navegación (unit, section, exercise)
     * @param {string} currentExerciseUrl - URL del ejercicio actual
     */
    presentExerciseCompletion(feedbackMessage, statusMessage, url, type, currentExerciseUrl) {
        // Remover modal existente si existe
        const existingModal = document.getElementById('alert-modal');
        if (existingModal) {
            existingModal.remove();
        }

        // Crear estructura del modal
        const modalContainer = Utils.createElement('div', {
            'class': 'modal fade',
            'id': 'alert-modal',
            'tabindex': '-1',
            'aria-labelledby': 'alert-modal',
            'aria-hidden': 'true'
        });

        const modalDialog = Utils.createElement('div', {
            'class': 'modal-dialog modal-dialog-centered'
        });

        const modalContent = Utils.createElement('div', {
            'class': 'modal-content'
        });

        const modalHeader = Utils.createElement('div', {
            'class': 'd-flex justify-content-end pt-2 pe-2'
        }, '<button type="button" class="btn-close btn-sm" data-bs-dismiss="modal" aria-label="Close"></button>');

        const modalBody = Utils.createElement('div', {
            'class': 'modal-body'
        });

        const messageContainer = Utils.createElement('div', {
            'class': 'p-2'
        });

        const messageText = Utils.createElement('p', {
            'class': 'text-center text-success',
            'id': 'alert-modal-message'
        }, feedbackMessage);

        const statusText = Utils.createElement('h4', {
            'class': 'text-center text-dark',
            'id': 'alert-modal-status'
        }, statusMessage);

        const buttonContainer = Utils.createElement('div', {
            'class': 'd-flex justify-content-center p-2'
        });

        const cancelButton = Utils.createElement('button', {
            'class': 'btn btn-sm btn-secondary me-2',
            'type': 'button',
            'data-bs-dismiss': 'modal'
        }, 'Check results');

        const statusButton = Utils.createElement('button', {
            'class': 'text-center btn btn-primary btn-sm',
            'type': 'button'
        });

        const buttonText = type === 'section' ? 'Next stage' : `Next ${type}`;
        statusButton.innerHTML = buttonText;
        statusButton.setAttribute('onclick', `Navigation.goTo('${url}', '${type}', '${currentExerciseUrl}')`);

        // Construir estructura
        buttonContainer.appendChild(cancelButton);
        buttonContainer.appendChild(statusButton);
        messageContainer.appendChild(messageText);
        messageContainer.appendChild(statusText);
        messageContainer.appendChild(buttonContainer);
        modalBody.appendChild(messageContainer);
        modalContent.appendChild(modalHeader);
        modalContent.appendChild(modalBody);
        modalDialog.appendChild(modalContent);
        modalContainer.appendChild(modalDialog);

        // Agregar al body y mostrar
        document.body.appendChild(modalContainer);

        // Usar jQuery para mostrar el modal (compatibilidad con código existente)
        $(function() {
            $("#alert-modal").modal("show");
        });
    }
};

// Exportar
if (typeof module !== 'undefined' && module.exports) {
    module.exports = ModalManager;
}