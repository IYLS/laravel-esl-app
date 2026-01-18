/**
 * Módulo de manejo de respuestas de ejercicios
 * Contiene funciones comunes para procesar respuestas
 */
const ExerciseResponses = {
    /**
     * Agrega campos ocultos al formulario antes de enviarlo
     * @param {Object} data - Datos a agregar
     * @param {string} formId - ID del formulario
     */
    appendFormFields(data, formId) {
        const form = document.getElementById(formId);
        if (!form) return;

        Object.keys(data).forEach(key => {
            const input = Utils.createElement('input', {
                'name': key,
                'value': data[key],
                'hidden': ''
            });
            form.appendChild(input);
        });
    },

    /**
     * Construye el objeto de respuestas para envío
     * @param {Array} responses - Array de respuestas
     * @returns {Object} - Objeto con las respuestas formateadas
     */
    buildResponseObject(responses) {
        return {
            responses: responses.map(r => ({
                id: String(r.id),
                response: String(r.response)
            }))
        };
    },

    /**
     * Agrega tiempo y conteos al formulario
     * @param {string} formId - ID del formulario
     * @param {string} timeSpent - Tiempo transcurrido
     * @param {number} correct - Respuestas correctas (opcional)
     * @param {number} wrong - Respuestas incorrectas (opcional)
     */
    appendTimeAndCounts(formId, timeSpent, correct = null, wrong = null) {
        const form = document.getElementById(formId);
        if (!form) return;

        // Tiempo siempre se agrega
        const timeInput = Utils.createElement('input', {
            'name': 'time',
            'value': timeSpent,
            'hidden': ''
        });
        form.appendChild(timeInput);

        // Correctas e incorrectas solo si se proporcionan
        if (correct !== null) {
            const correctInput = Utils.createElement('input', {
                'name': 'correct',
                'value': String(correct),
                'hidden': ''
            });
            form.appendChild(correctInput);
        }

        if (wrong !== null) {
            const wrongInput = Utils.createElement('input', {
                'name': 'wrong',
                'value': String(wrong),
                'hidden': ''
            });
            form.appendChild(wrongInput);
        }
    }
};

// Exportar
if (typeof module !== 'undefined' && module.exports) {
    module.exports = ExerciseResponses;
}