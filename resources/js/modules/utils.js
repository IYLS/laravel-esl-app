/**
 * Utilidades generales del sistema
 * Funciones de apoyo que no dependen de otros módulos
 */
const Utils = {
    /**
     * Convierte milisegundos a formato HH:MM:SS o MM:SS
     * @param {number} ms - Milisegundos
     * @returns {string} - Formato de tiempo
     */
    millisToHms(ms) {
        const n = Number(ms);
        if (!Number.isFinite(n) || n < 0) return '00:00';

        const totalSeconds = Math.floor(n / 1000);
        const h = Math.floor(totalSeconds / 3600);
        const m = Math.floor((totalSeconds % 3600) / 60);
        const s = totalSeconds % 60;
        const base = `${String(m).padStart(2, '0')}:${String(s).padStart(2, '0')}`;
        return (h > 0) ? `${h}:${base}` : base;
    },

    /**
     * Obtiene el tiempo actual en milisegundos
     * @returns {number}
     */
    getCurrentTime() {
        return new Date().getTime();
    },

    /**
     * Crea un elemento DOM con atributos
     * @param {string} tag - Etiqueta HTML
     * @param {Object} attributes - Atributos del elemento
     * @param {string} content - Contenido opcional
     * @returns {HTMLElement}
     */
    createElement(tag, attributes = {}, content = '') {
        const element = document.createElement(tag);
        Object.keys(attributes).forEach(key => {
            element.setAttribute(key, attributes[key]);
        });
        if (content) {
            element.innerHTML = content;
        }
        return element;
    },

    /**
     * Muestra u oculta un elemento
     * @param {string} elementId - ID del elemento
     * @param {boolean} hidden - Si debe estar oculto
     */
    setElementVisibility(elementId, hidden) {
        const element = document.getElementById(elementId);
        if (element) {
            element.hidden = hidden;
        }
    }
};

// Exportar para uso en otros módulos
if (typeof module !== 'undefined' && module.exports) {
    module.exports = Utils;
}