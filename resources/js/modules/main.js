/**
 * Archivo principal de módulos
 * Carga todos los módulos y expone funciones globales para compatibilidad
 */

// Cargar módulos en orden de dependencias
// Nota: En un entorno real, estos se cargarían vía import/require o build tool
// Aquí asumimos que los módulos están en el scope global o se cargan antes

// Esperar a que el DOM esté listo
document.addEventListener('DOMContentLoaded', function() {
    // Inicializar Timer si es necesario
    if (typeof Timer !== 'undefined') {
        Timer.start();
    }
});

// Exportar funciones globales para compatibilidad con código existente
window.ExerciseHandler = ExerciseHandler || {};
window.Tracking = Tracking || {};
window.Timer = Timer || {};
window.Feedback = Feedback || {};
window.Navigation = Navigation || {};
window.ModalManager = ModalManager || {};
window.Utils = Utils || {};
window.DragAndDrop = DragAndDrop || {};
window.VideoHandler = VideoHandler || {};

// Funciones de compatibilidad global
window.millisToHms = function(ms) {
    return Utils.millisToHms(ms);
};

window.startTimer = function() {
    Timer.start();
};

window.allowDrop = function(ev) {
    DragAndDrop.allowDrop(ev);
};

window.drag = function(ev) {
    DragAndDrop.drag(ev);
};

window.drop = function(ev) {
    DragAndDrop.drop(ev);
};

window.setFeedbackHidden = function(value, exerciseId, questions) {
    Feedback.setVisibility(value, exerciseId, questions);
};

window.getResponseData = function(questions, exercise, type) {
    return ExerciseHandler.getResponseData(questions, exercise, type);
};

window.checkAction = function(exercise, questions, type, exerciseId, userId, route) {
    ExerciseHandler.handleSubmit(exercise, questions, type, exerciseId, userId, route);
};

window.presentModal = function(feedbackMessage, statusMessage, url, type, currentExerciseUrl) {
    ModalManager.presentExerciseCompletion(feedbackMessage, statusMessage, url, type, currentExerciseUrl);
};

window.goTo = function(uri, type, currentExerciseUrl) {
    Navigation.goTo(uri, type, currentExerciseUrl);
};

window.onHelpOptionClicked = function(type) {
    Tracking.onHelpOptionOpened(type);
};

window.onHelpOptionDismissed = function(type) {
    Tracking.onHelpOptionClosed(type);
};

window.setCurrentExercise = function(exerciseId) {
    Tracking.currentExerciseId = exerciseId;
};

window.onExerciseClicked = function(exerciseId) {
    Tracking.initExercise(exerciseId);
};

window.appendTrackingValues = function(exerciseId, type) {
    Tracking.appendToForm(exerciseId, type);
};

window.resetExercise = function(exerciseId, questions, exerciseType) {
    // Si no se proporciona el tipo, intentar detectarlo o usar múltiple choice por defecto
    if (!exerciseType) {
        // Intentar detectar por elementos presentes
        const checkboxes = document.getElementsByClassName(`multiple-choice-${exerciseId}-check`);
        if (checkboxes.length > 0) {
            exerciseType = 'multiple_choice';
        } else {
            // Por defecto, solo resetear feedback
            Feedback.setVisibility(true, exerciseId, questions);
            return;
        }
    }

    // Resetear según el tipo de ejercicio
    switch(exerciseType) {
        case 'multiple_choice':
            // Desmarcar todos los checkboxes
            const checkboxes = document.getElementsByClassName(`multiple-choice-${exerciseId}-check`);
            Array.from(checkboxes).forEach(element => {
                element.checked = false;
            });
            // Ocultar feedback explicativo de alternativas
            questions.forEach(question => {
                const alternatives = document.getElementsByName(`question-${question.id}`);
                Array.from(alternatives).forEach(alternative => {
                    const explanatory = document.getElementById(`${alternative.value}-explanatory`);
                    if (explanatory) {
                        explanatory.hidden = true;
                    }
                });
            });
            break;

        case 'fill_in_the_gaps':
            // Limpiar todos los inputs de respuesta
            questions.forEach(question => {
                const answers = document.getElementsByName(`answer-${question.id}`);
                Array.from(answers).forEach(answer => {
                    answer.value = '';
                    // Remover estilos de borde (para Dictation Cloze)
                    answer.style.borderColor = '';
                });
            });
            // Remover clases strikable y bg-warning de palabras (para Vocabulary Practice)
            const strikableWords = document.querySelectorAll('.strikable');
            strikableWords.forEach(word => {
                word.classList.remove('strikable', 'bg-warning');
            });
            break;

        case 'drag_and_drop':
            // Mover todas las palabras de vuelta a su origen
            // Buscar todos los elementos word-* que están dentro de destinos
            questions.forEach(question => {
                const destinationContainer = document.getElementById(`word-destination-${question.answer}`);
                if (destinationContainer && destinationContainer.firstChild) {
                    // Si hay un hijo en el destino, buscar su origen correspondiente
                    const wordElement = destinationContainer.firstChild;
                    const wordId = wordElement.id; // ej: "word-palabra"
                    if (wordId && wordId.startsWith('word-')) {
                        const wordText = wordId.replace('word-', '');
                        const originContainer = document.getElementById(`word-origin-${wordText}`);
                        if (originContainer) {
                            originContainer.appendChild(wordElement);
                        }
                    }
                }
            });
            break;

        case 'open_ended':
            // Limpiar todos los textareas
            questions.forEach(question => {
                const answers = document.getElementsByName(`answer-${question.id}`);
                Array.from(answers).forEach(answer => {
                    answer.value = '';
                });
            });
            break;

        case 'form':
            // Limpiar todos los inputs del formulario
            const form = document.getElementById(`form_form_${exerciseId}`);
            if (form) {
                const inputs = form.querySelectorAll('input, textarea, select');
                inputs.forEach(input => {
                    if (input.type === 'checkbox' || input.type === 'radio') {
                        input.checked = false;
                    } else {
                        input.value = '';
                    }
                });
            }
            break;

        case 'voice_recognition':
            // Limpiar inputs si existen
            questions.forEach(question => {
                const answers = document.getElementsByName(`answer-${question.id}`);
                Array.from(answers).forEach(answer => {
                    answer.value = '';
                });
            });
            break;
    }

    // Resetear feedback para todos los tipos
    Feedback.setVisibility(true, exerciseId, questions);
    
    // Resetear contadores de feedback
    const correctElement = document.getElementById(`feedback-exercise-correct-${exerciseId}`);
    const wrongElement = document.getElementById(`feedback-exercise-wrong-${exerciseId}`);
    if (correctElement) {
        correctElement.innerHTML = '';
        correctElement.hidden = true;
    }
    if (wrongElement) {
        wrongElement.innerHTML = '';
        wrongElement.hidden = true;
    }

    // Resetear mensajes condicionales
    const allCorrectElement = document.querySelector(`.show-on-all-correct-${exerciseId}`);
    const anyWrongElement = document.querySelector(`.show-on-any-wrong-${exerciseId}`);
    if (allCorrectElement) {
        allCorrectElement.hidden = true;
    }
    if (anyWrongElement) {
        anyWrongElement.hidden = true;
    }
};

window.strikeWord = function(item) {
    if (!item.classList.contains('strikable')) {
        item.classList.add('strikable', 'bg-warning');
    } else {
        item.classList.remove('strikable', 'bg-warning');
    }
};

window.unstick = function() {
    const stickyBar = document.getElementById('sticky-bar');
    if (stickyBar) {
        stickyBar.classList.remove('sticky-top');
    }
};