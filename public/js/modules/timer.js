/**
 * Módulo de gestión de tiempo para ejercicios
 * Maneja el tiempo invertido en ejercicios
 */
const Timer = {
    startTime: null,

    /**
     * Inicia el timer del ejercicio
     */
    start() {
        this.startTime = Utils.getCurrentTime();
        window.startTime = this.startTime;
    },

    /**
     * Calcula el tiempo transcurrido desde que se inició
     * @returns {string} - Tiempo formateado
     */
    getElapsedTime() {
        if (!this.startTime) {
            return '00:00';
        }
        const currentTime = Utils.getCurrentTime();
        return Utils.millisToHms(currentTime - this.startTime);
    },

    /**
     * Obtiene el tiempo transcurrido en milisegundos
     * @returns {number}
     */
    getElapsedMilliseconds() {
        if (!this.startTime) {
            return 0;
        }
        return Utils.getCurrentTime() - this.startTime;
    }
};

// Exportar
if (typeof module !== 'undefined' && module.exports) {
    module.exports = Timer;
}