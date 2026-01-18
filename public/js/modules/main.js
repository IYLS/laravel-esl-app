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

window.resetExercise = function(exerciseId, questions) {
    const elements = document.getElementsByClassName(`multiple-choice-${exerciseId}-check`);
    Array.from(elements).forEach(element => {
        element.checked = false;
    });
    Feedback.setVisibility(true, exerciseId, questions);
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