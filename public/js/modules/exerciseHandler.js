/**
 * Módulo principal de manejo de ejercicios
 * Coordina el procesamiento y envío de respuestas
 */
const ExerciseHandler = {
    /**
     * Procesa y obtiene los datos de respuesta según el tipo de ejercicio
     * @param {Array} questions - Preguntas del ejercicio
     * @param {Object} exercise - Datos del ejercicio
     * @param {string} type - Tipo de ejercicio
     * @returns {Object} - Resultados procesados
     */
    getResponseData(questions, exercise, type) {
        let answers = {};

        switch (type) {
            case 'drag_and_drop':
                answers = ExerciseTypes.processDragAndDrop(questions, exercise);
                break;
            case 'multiple_choice':
                answers = ExerciseTypes.processMultipleChoice(questions, exercise);
                break;
            case 'fill_in_the_gaps':
                if (exercise.subtype == 2) {
                    answers = ExerciseTypes.processFillInTheGaps(questions, exercise);
                } else {
                    answers = ExerciseTypes.processDictationCloze(questions, exercise);
                }
                break;
            case 'open_ended':
                answers = ExerciseTypes.processOpenEnded(questions, exercise);
                break;
            default:
                answers = { responses: [] };
        }

        // Agregar valores de tracking
        Tracking.appendToForm(exercise.id, type);

        // Calcular tiempo transcurrido
        const timeSpent = Timer.getElapsedTime();
        const formId = `${type}_form_${exercise.id}`;

        // Agregar tiempo y conteos al formulario
        const shouldIncludeCounts = type !== 'open_ended' && 
                                   type !== 'form' && 
                                   exercise.subtype !== 99 && 
                                   exercise.subtype !== 991;

        if (shouldIncludeCounts && answers.correct !== undefined) {
            ExerciseResponses.appendTimeAndCounts(
                formId, 
                timeSpent, 
                answers.correct, 
                answers.wrong
            );
        } else {
            ExerciseResponses.appendTimeAndCounts(formId, timeSpent);
        }

        // Agregar respuestas al formulario
        if (type !== 'form' && answers.responses && answers.responses.length > 0) {
            answers.responses.forEach(item => {
                const responseInput = Utils.createElement('input', {
                    'name': `responses[${item.id}]`,
                    'value': item.response,
                    'hidden': ''
                });
                const form = document.getElementById(formId);
                if (form) {
                    form.appendChild(responseInput);
                }
            });
        }

        return answers;
    },

    /**
     * Maneja el envío del formulario de ejercicio
     * @param {Object} exercise - Datos del ejercicio
     * @param {Array} questions - Preguntas
     * @param {string} type - Tipo de ejercicio
     * @param {number} exerciseId - ID del ejercicio
     * @param {number} userId - ID del usuario
     * @param {string} route - Ruta del endpoint
     */
    handleSubmit(exercise, questions, type, exerciseId, userId, route) {
        // Obtener datos de respuesta (excepto para voice_recognition)
        if (type !== 'voice_recognition') {
            this.getResponseData(questions, exercise, type);
        }

        event.preventDefault();

        // Enviar formulario vía AJAX
        $.ajax({
            url: route,
            type: 'POST',
            data: $(`#${type}_form_${exerciseId}`).serialize(),
            dataType: 'json',
            success: (response) => {
                const currentExerciseUrl = `${type}${exercise.id}`;
                ModalManager.presentExerciseCompletion(
                    response.feedback_message,
                    response.status_message,
                    response.navigation_url,
                    response.navigation_type,
                    currentExerciseUrl
                );
            },
            error: (response) => {
                console.error('Error submitting exercise:', response);
            }
        });
    }
};

// Exportar
if (typeof module !== 'undefined' && module.exports) {
    module.exports = ExerciseHandler;
}