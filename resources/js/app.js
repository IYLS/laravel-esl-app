/**
 * Archivo principal de aplicación
 * Carga todos los módulos del sistema
 */

require('./bootstrap');

// Cargar módulos en orden de dependencias
// Nota: En producción, estos deberían ser empaquetados por webpack/mix
// Por ahora, se asumen que están disponibles en el scope global

// El orden de carga importa debido a las dependencias:
// 1. Utils (sin dependencias)
// 2. Timer (depende de Utils)
// 3. DragAndDrop (sin dependencias)
// 4. Feedback (depende de Utils)
// 5. Tracking (depende de Utils)
// 6. ExerciseResponses (depende de Utils)
// 7. ExerciseTypes (depende de Feedback, Utils)
// 8. ExerciseHandler (depende de ExerciseTypes, Tracking, Timer, ExerciseResponses)
// 9. ModalManager (depende de Utils, Navigation)
// 10. Navigation (sin dependencias)
// 11. Main (carga todo y expone funciones globales)

// En desarrollo, estos archivos se cargarían vía <script> tags en el HTML
// En producción, se empaquetarían con webpack/mix