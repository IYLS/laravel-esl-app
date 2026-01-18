/**
 * Bundle principal de JavaScript
 * Carga todos los módulos en orden correcto
 * 
 * NOTA: Este archivo se carga directamente en las vistas.
 * En producción, debería compilarse con webpack/mix.
 */

// Cargar módulos en orden de dependencias
// 1. Utils (sin dependencias)
if (typeof Utils === 'undefined') {
    console.error('Utils module not loaded');
}

// 2. Timer (depende de Utils)
if (typeof Timer === 'undefined') {
    console.error('Timer module not loaded');
}

// 3. DragAndDrop (sin dependencias)
if (typeof DragAndDrop === 'undefined') {
    console.error('DragAndDrop module not loaded');
}

// 4. Feedback (depende de Utils)
if (typeof Feedback === 'undefined') {
    console.error('Feedback module not loaded');
}

// 5. Tracking (depende de Utils)
if (typeof Tracking === 'undefined') {
    console.error('Tracking module not loaded');
}

// 6. ExerciseResponses (depende de Utils)
if (typeof ExerciseResponses === 'undefined') {
    console.error('ExerciseResponses module not loaded');
}

// 7. ExerciseTypes (depende de Feedback, Utils)
if (typeof ExerciseTypes === 'undefined') {
    console.error('ExerciseTypes module not loaded');
}

// 8. ExerciseHandler (depende de varios módulos)
if (typeof ExerciseHandler === 'undefined') {
    console.error('ExerciseHandler module not loaded');
}

// 9. ModalManager (depende de Utils, Navigation)
if (typeof ModalManager === 'undefined') {
    console.error('ModalManager module not loaded');
}

// 10. Navigation (sin dependencias)
if (typeof Navigation === 'undefined') {
    console.error('Navigation module not loaded');
}

// 11. ExerciseHelpers (sin dependencias externas de otros módulos)
if (typeof ExerciseHelpers === 'undefined') {
    console.error('ExerciseHelpers module not loaded');
}

// Verificar que Main.js haya cargado las funciones globales
// Esto se hace automáticamente si main.js se carga después de todos los módulos