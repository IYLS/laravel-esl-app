/**
 * Módulo de funcionalidad Drag and Drop
 * Maneja las operaciones de arrastrar y soltar
 */
const DragAndDrop = {
    /**
     * Permite soltar un elemento (previene comportamiento por defecto)
     * @param {Event} ev - Evento de arrastre
     */
    allowDrop(ev) {
        ev.preventDefault();
    },

    /**
     * Inicia el arrastre de un elemento
     * @param {Event} ev - Evento de arrastre
     */
    drag(ev) {
        ev.dataTransfer.setData("text", ev.target.id);
    },

    /**
     * Maneja el evento de soltar un elemento
     * @param {Event} ev - Evento de soltar
     */
    drop(ev) {
        ev.preventDefault();
        const data = ev.dataTransfer.getData("text");
        const draggedElement = document.getElementById(data);
        if (draggedElement) {
            ev.target.appendChild(draggedElement);
        }
    }
};

// Exportar
if (typeof module !== 'undefined' && module.exports) {
    module.exports = DragAndDrop;
}