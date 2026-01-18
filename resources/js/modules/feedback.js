/**
 * Módulo de gestión de feedback
 * Maneja la visibilidad y estado del feedback en ejercicios
 */
const Feedback = {
    /**
     * Muestra u oculta el feedback de preguntas y ejercicio
     * @param {boolean} hidden - Si debe estar oculto
     * @param {number} exerciseId - ID del ejercicio
     * @param {Array} questions - Array de preguntas
     */
    setVisibility(hidden, exerciseId, questions) {
        // Ocultar/mostrar feedback de cada pregunta
        questions.forEach(question => {
            const questionFeedback = document.getElementById(`question-feedback-container-${question.id}`);
            if (questionFeedback) {
                questionFeedback.hidden = hidden;
            }
        });

        // Ocultar/mostrar feedback del ejercicio
        const exerciseFeedback = document.getElementById(`feedback-exercise-details-container-${exerciseId}`);
        if (exerciseFeedback) {
            exerciseFeedback.hidden = hidden;
        }
    },

    /**
     * Muestra el feedback correcto de una pregunta
     * @param {number} questionId - ID de la pregunta
     */
    showCorrect(questionId) {
        Utils.setElementVisibility(`question-${questionId}-feedback-correct`, false);
        Utils.setElementVisibility(`question-${questionId}-feedback-wrong`, true);
    },

    /**
     * Muestra el feedback incorrecto de una pregunta
     * @param {number} questionId - ID de la pregunta
     */
    showWrong(questionId) {
        Utils.setElementVisibility(`question-${questionId}-feedback-correct`, true);
        Utils.setElementVisibility(`question-${questionId}-feedback-wrong`, false);
    },

    /**
     * Actualiza los contadores de respuestas correctas e incorrectas
     * @param {number} exerciseId - ID del ejercicio
     * @param {number} correct - Cantidad de correctas
     * @param {number} wrong - Cantidad de incorrectas
     */
    updateCounters(exerciseId, correct, wrong) {
        const correctElement = document.getElementById(`feedback-exercise-correct-${exerciseId}`);
        const wrongElement = document.getElementById(`feedback-exercise-wrong-${exerciseId}`);
        
        if (correctElement) {
            correctElement.innerHTML = `<strong>${correct}</strong>  ✅`;
            correctElement.hidden = false;
        }
        
        if (wrongElement) {
            wrongElement.innerHTML = `<strong>${wrong}</strong>  ❌`;
            wrongElement.hidden = false;
        }
    },

    /**
     * Muestra u oculta mensajes condicionales basados en respuestas
     * @param {number} exerciseId - ID del ejercicio
     * @param {number} totalQuestions - Total de preguntas
     * @param {number} correctQuestions - Preguntas correctas
     */
    toggleConditionalMessages(exerciseId, totalQuestions, correctQuestions) {
        const allCorrectElement = document.querySelector(`.show-on-all-correct-${exerciseId}`);
        const anyWrongElement = document.querySelector(`.show-on-any-wrong-${exerciseId}`);

        if (allCorrectElement) {
            allCorrectElement.hidden = (totalQuestions !== correctQuestions);
        }

        if (anyWrongElement) {
            anyWrongElement.hidden = (totalQuestions === correctQuestions);
        }
    }
};

// Exportar
if (typeof module !== 'undefined' && module.exports) {
    module.exports = Feedback;
}