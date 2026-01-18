/**
 * Funciones auxiliares para ejercicios
 * Funciones específicas de formularios y ejercicios
 */
const ExerciseHelpers = {
    /**
     * Agrega una columna de pregunta al formulario
     * @param {number} id - ID de la pregunta
     */
    addColumn(id) {
        const questionsContainer = document.getElementById(`questions-form-${id}`);
        if (!questionsContainer) return;

        const input = Utils.createElement('input', {
            'type': 'text',
            'class': 'form-control',
            'placeholder': 'Question statement',
            'name': 'alternatives[]'
        });

        const inputContainer = Utils.createElement('div', {
            'class': 'col-10'
        });
        inputContainer.appendChild(input);

        const deleteIcon = Utils.createElement('i', {
            'class': 'mdi mdi-delete'
        });

        const deleteButton = Utils.createElement('a', {
            'class': 'btn btn-danger',
            'onclick': `deleteFormQuestion('form-question-${this.numberOfQuestions()}')`
        });
        deleteButton.appendChild(deleteIcon);

        const deleteContainer = Utils.createElement('div', {
            'class': 'col-2'
        });
        deleteContainer.appendChild(deleteButton);

        const container = Utils.createElement('div', {
            'class': 'row form-question-title mb-1',
            'id': `form-question-${this.numberOfQuestions()}`
        });
        container.appendChild(inputContainer);
        container.appendChild(deleteContainer);

        questionsContainer.appendChild(container);
    },

    /**
     * Cuenta el número de preguntas en el formulario
     * @returns {number}
     */
    numberOfQuestions() {
        return document.getElementsByClassName('form-question-title').length + 1;
    },

    /**
     * Elimina una pregunta del formulario
     * @param {string} id - ID del elemento a eliminar
     */
    deleteFormQuestion(id) {
        const element = document.getElementById(id);
        if (element) {
            element.remove();
        }
    },

    /**
     * Agrega una alternativa a una pregunta
     * @param {number} id - ID de la pregunta
     */
    addAlternative(id) {
        const alternativesContainer = document.getElementById(`question-${id}-alternatives`);
        if (!alternativesContainer) return;

        const numberOfAlternatives = this.numberOfAlternatives(id);

        const inputContainer = Utils.createElement('div', {
            'class': 'col-9'
        });
        inputContainer.innerHTML = "<input type='text' class='form-control' placeholder='Alternative title' name='alternatives[]'>";

        const checkContainer = Utils.createElement('div', {
            'class': 'col-1 form-check'
        });
        checkContainer.innerHTML = `<input class='form-check-input' value='${numberOfAlternatives}' type='radio' name='correct_answer'>`;

        const deleteButton = Utils.createElement('button', {
            'type': 'button',
            'class': 'btn btn-danger btn-sm',
            'onclick': `removeAlternative("${id}", ${numberOfAlternatives})`
        }, '<i class="mdi mdi-delete"></i>');

        const deleteContainer = Utils.createElement('div', {
            'class': 'col-1'
        });
        deleteContainer.appendChild(deleteButton);

        const container = Utils.createElement('div', {
            'class': `row ms-1 me-1 question-${id}-alternative mb-1 d-flex justify-content-center align-items-center`,
            'id': `question-${id}-alternative-${numberOfAlternatives}`
        });
        container.appendChild(checkContainer);
        container.appendChild(inputContainer);
        container.appendChild(deleteContainer);

        alternativesContainer.appendChild(container);
    },

    /**
     * Cuenta el número de alternativas de una pregunta
     * @param {number} id - ID de la pregunta
     * @returns {number}
     */
    numberOfAlternatives(id) {
        return document.getElementsByClassName(`question-${id}-alternative`).length;
    },

    /**
     * Elimina una alternativa de una pregunta
     * @param {number} id - ID de la pregunta
     * @param {number} index - Índice de la alternativa
     */
    removeAlternative(id, index) {
        const element = document.getElementById(`question-${id}-alternative-${index}`);
        if (element) {
            element.remove();
        }
    }
};

// Exportar funciones globales para compatibilidad
window.addColumn = function(id) {
    ExerciseHelpers.addColumn(id);
};

window.numberOfQuestions = function() {
    return ExerciseHelpers.numberOfQuestions();
};

window.deleteFormQuestion = function(id) {
    ExerciseHelpers.deleteFormQuestion(id);
};

window.addAlternative = function(id) {
    ExerciseHelpers.addAlternative(id);
};

window.numberOfAlternatives = function(id) {
    return ExerciseHelpers.numberOfAlternatives(id);
};

window.removeAlternative = function(id, index) {
    ExerciseHelpers.removeAlternative(id, index);
};

// Exportar
if (typeof module !== 'undefined' && module.exports) {
    module.exports = ExerciseHelpers;
}