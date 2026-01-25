@extends('layouts.app')
@section('main')

<style>
    .faq-container {
        max-width: 900px;
        margin: 0 auto;
    }
    .faq-header {
        text-align: center;
        margin-bottom: 3rem;
        padding: 2rem 0;
    }
    .faq-header h1 {
        font-size: 2.5rem;
        font-weight: 700;
        color: #2c3e50;
        margin-bottom: 0.5rem;
    }
    .faq-header p {
        font-size: 1.1rem;
        color: #7f8c8d;
    }
    .faq-section {
        margin-bottom: 2rem;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .faq-section:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.12);
    }
    .faq-section-header {
        padding: 1.25rem 1.5rem;
        font-weight: 600;
        font-size: 1.25rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    .faq-section-header i {
        font-size: 1.5rem;
    }
    .faq-accordion .accordion-item {
        border: none;
        border-bottom: 1px solid #e9ecef;
    }
    .faq-accordion .accordion-item:last-child {
        border-bottom: none;
    }
    .faq-accordion .accordion-button {
        font-weight: 500;
        color: #2c3e50;
        padding: 1rem 1.5rem;
        background-color: #fff;
        border: none;
    }
    .faq-accordion .accordion-button:not(.collapsed) {
        background-color: #f8f9fa;
        color: #0d6efd;
    }
    .faq-accordion .accordion-button:focus {
        box-shadow: none;
        border-color: transparent;
    }
    .faq-accordion .accordion-body {
        padding: 1.5rem;
        line-height: 1.7;
        color: #495057;
    }
    .faq-accordion .accordion-body ol, .faq-accordion .accordion-body ul {
        padding-left: 1.5rem;
    }
    .faq-accordion .accordion-body li {
        margin-bottom: 0.5rem;
    }
    .info-box {
        border-left: 4px solid;
        padding: 1rem 1.25rem;
        margin-top: 1rem;
        border-radius: 4px;
        background-color: #f8f9fa;
    }
    .info-box.alert-info {
        border-left-color: #0dcaf0;
        background-color: #e7f5f8;
    }
    .info-box.alert-warning {
        border-left-color: #ffc107;
        background-color: #fff8e1;
    }
    .info-box.alert-success {
        border-left-color: #198754;
        background-color: #d1e7dd;
    }
    .info-box strong {
        display: block;
        margin-bottom: 0.5rem;
        font-size: 1rem;
    }
    .section-icon {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        flex-shrink: 0;
        background-color: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(4px);
    }
    .section-icon .material-symbols-outlined {
        font-size: 24px;
        color: white !important;
        font-weight: normal;
        font-style: normal;
        line-height: 1;
        display: inline-block;
        width: 24px;
        height: 24px;
    }
</style>

<div class="container mt-4 mb-5">
    <div class="faq-container">
        <div class="faq-header">
            <h1>❓ Preguntas Frecuentes</h1>
            <p>Guía completa para configurar y gestionar tu plataforma de aprendizaje</p>
        </div>
        
        <!-- Sección de Preguntas Generales -->
        <div class="faq-section">
            <div class="faq-section-header text-white" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                <div class="section-icon">
                    <span class="material-symbols-outlined">help</span>
                </div>
                <span>Preguntas Generales</span>
            </div>
            <div class="card-body p-0">
                <div class="accordion faq-accordion" id="generalAccordion">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingGeneral1">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseGeneral1" aria-expanded="true" aria-controls="collapseGeneral1">
                                🔐 ¿Cómo inicio sesión como profesor?
                            </button>
                        </h2>
                        <div id="collapseGeneral1" class="accordion-collapse collapse show" aria-labelledby="headingGeneral1" data-bs-parent="#generalAccordion">
                            <div class="accordion-body">
                                Ve a la página de login, ingresa tu correo electrónico y contraseña, y asegúrate de seleccionar el rol <strong>"Teacher"</strong> antes de hacer clic en "Login". Una vez iniciada la sesión, serás redirigido al dashboard principal del módulo profesor.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingGeneral2">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseGeneral2" aria-expanded="false" aria-controls="collapseGeneral2">
                                🏠 ¿Qué puedo hacer desde el dashboard principal?
                            </button>
                        </h2>
                        <div id="collapseGeneral2" class="accordion-collapse collapse" aria-labelledby="headingGeneral2" data-bs-parent="#generalAccordion">
                            <div class="accordion-body">
                                Desde el dashboard puedes acceder a:
                                <ul>
                                    <li><strong>Users:</strong> Gestionar usuarios, asignar grupos, contraseñas y permisos.</li>
                                    <li><strong>Groups:</strong> Crear y administrar grupos de estudiantes.</li>
                                    <li><strong>Units:</strong> Crear y gestionar unidades de contenido, actividades y preguntas.</li>
                                    <li><strong>Tracking System:</strong> Revisar respuestas, tiempos y progreso de los estudiantes.</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sección de Ejemplos: Cómo Cargar Unidades -->
        <div class="faq-section">
            <div class="faq-section-header text-white" style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);">
                <div class="section-icon">
                    <span class="material-symbols-outlined">book</span>
                </div>
                <span>Ejemplos: Cómo Cargar y Configurar Unidades</span>
            </div>
            <div class="card-body p-0">
                <div class="accordion faq-accordion" id="unitsAccordion">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingUnit1">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseUnit1" aria-expanded="true" aria-controls="collapseUnit1">
                                ➕ Crear una Nueva Unidad
                            </button>
                        </h2>
                        <div id="collapseUnit1" class="accordion-collapse collapse show" aria-labelledby="headingUnit1" data-bs-parent="#unitsAccordion">
                            <div class="accordion-body">
                                <strong class="d-block mb-3">Pasos para crear una unidad:</strong>
                                <ol>
                                    <li>Ve al menú <strong>"Units"</strong> desde el dashboard o la barra de navegación.</li>
                                    <li>Haz clic en el botón <strong>"Create New Unit"</strong> o "Nueva Unidad".</li>
                                    <li>Completa el formulario con la información requerida:
                                        <ul>
                                            <li><strong>Título:</strong> Nombre descriptivo de la unidad</li>
                                            <li><strong>Video:</strong> Sube un archivo de video (opcional) que será el contenido principal</li>
                                            <li><strong>Copyright del video:</strong> Información de derechos de autor si aplica</li>
                                        </ul>
                                    </li>
                                    <li>Haz clic en <strong>"Save"</strong> o "Guardar" para crear la unidad.</li>
                                    <li>Una vez creada, serás redirigido a la página de detalles de la unidad donde podrás agregar secciones y ejercicios.</li>
                                </ol>
                                <div class="info-box alert-info">
                                    <strong>💡 Tip:</strong> Asegúrate de tener todos los materiales (videos, audios, imágenes) listos antes de crear la unidad para una configuración más eficiente.
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingUnit2">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseUnit2" aria-expanded="false" aria-controls="collapseUnit2">
                                📑 Agregar Secciones a una Unidad
                            </button>
                        </h2>
                        <div id="collapseUnit2" class="accordion-collapse collapse" aria-labelledby="headingUnit2" data-bs-parent="#unitsAccordion">
                            <div class="accordion-body">
                                <strong class="d-block mb-3">Pasos para agregar secciones:</strong>
                                <ol>
                                    <li>Desde la página de detalles de la unidad, busca la sección <strong>"Sections"</strong> o "Secciones".</li>
                                    <li>Haz clic en <strong>"Add Section"</strong> o "Agregar Sección".</li>
                                    <li>Completa el formulario:
                                        <ul>
                                            <li><strong>Nombre:</strong> Nombre de la sección (ej: "Pre-listening", "While-listening")</li>
                                            <li><strong>Posición:</strong> Orden en que aparecerá la sección (1, 2, 3...)</li>
                                        </ul>
                                    </li>
                                    <li>Guarda la sección.</li>
                                    <li>Puedes arrastrar y soltar las secciones para reordenarlas si es necesario.</li>
                                </ol>
                                <div class="info-box alert-warning">
                                    <strong>⚠️ Importante:</strong> Las secciones se completan en orden. Asegúrate de organizarlas lógicamente según el flujo de aprendizaje que deseas.
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingUnit3">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseUnit3" aria-expanded="false" aria-controls="collapseUnit3">
                                ✏️ Crear Ejercicios dentro de una Sección
                            </button>
                        </h2>
                        <div id="collapseUnit3" class="accordion-collapse collapse" aria-labelledby="headingUnit3" data-bs-parent="#unitsAccordion">
                            <div class="accordion-body">
                                <strong class="d-block mb-3">Pasos para crear ejercicios:</strong>
                                <ol>
                                    <li>Desde la página de detalles de la sección, haz clic en <strong>"Add Exercise"</strong> o "Agregar Ejercicio".</li>
                                    <li>Selecciona el tipo de ejercicio que deseas crear:
                                        <ul>
                                            <li><strong>Multiple Choice:</strong> Preguntas de opción múltiple</li>
                                            <li><strong>Fill in the Gaps:</strong> Ejercicios de completar espacios</li>
                                            <li><strong>Drag and Drop:</strong> Ejercicios de arrastrar y soltar</li>
                                            <li><strong>Open Ended:</strong> Preguntas de respuesta abierta</li>
                                            <li><strong>Form:</strong> Formularios personalizados</li>
                                            <li><strong>Voice Recognition:</strong> Ejercicios de reconocimiento de voz</li>
                                        </ul>
                                    </li>
                                    <li>Completa la información del ejercicio:
                                        <ul>
                                            <li>Título del ejercicio</li>
                                            <li>Subtipo (si aplica)</li>
                                            <li>Video o audio asociado (opcional)</li>
                                            <li>Imagen (opcional)</li>
                                        </ul>
                                    </li>
                                    <li>Guarda el ejercicio y luego agrega las preguntas correspondientes.</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingUnit4">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseUnit4" aria-expanded="false" aria-controls="collapseUnit4">
                                ❓ Agregar Preguntas a un Ejercicio
                            </button>
                        </h2>
                        <div id="collapseUnit4" class="accordion-collapse collapse" aria-labelledby="headingUnit4" data-bs-parent="#unitsAccordion">
                            <div class="accordion-body">
                                <strong class="d-block mb-3">Pasos para agregar preguntas:</strong>
                                <ol>
                                    <li>Desde la página de detalles del ejercicio, haz clic en <strong>"Add Question"</strong> o "Agregar Pregunta".</li>
                                    <li>Completa el formulario según el tipo de ejercicio:
                                        <ul>
                                            <li><strong>Multiple Choice:</strong> Escribe el enunciado, agrega alternativas y marca cuál es la correcta</li>
                                            <li><strong>Fill in the Gaps:</strong> Escribe el texto con espacios marcados como ";;" y agrega el audio</li>
                                            <li><strong>Drag and Drop:</strong> Define las palabras/elementos y sus destinos</li>
                                            <li><strong>Open Ended:</strong> Escribe la pregunta o instrucción</li>
                                        </ul>
                                    </li>
                                    <li>Establece la posición de la pregunta (orden de aparición).</li>
                                    <li>Guarda la pregunta.</li>
                                    <li>Puedes agregar múltiples preguntas al mismo ejercicio.</li>
                                </ol>
                                <div class="info-box alert-info">
                                    <strong>💡 Tip:</strong> Usa el editor de texto enriquecido para formatear tus preguntas. Puedes agregar negritas, cursivas y otros formatos.
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingUnit5">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseUnit5" aria-expanded="false" aria-controls="collapseUnit5">
                                🆘 Configurar Opciones de Ayuda para una Unidad
                            </button>
                        </h2>
                        <div id="collapseUnit5" class="accordion-collapse collapse" aria-labelledby="headingUnit5" data-bs-parent="#unitsAccordion">
                            <div class="accordion-body">
                                <strong class="d-block mb-3">Pasos para configurar opciones de ayuda:</strong>
                                <ol>
                                    <li>Desde la página de detalles de la unidad, busca la sección <strong>"Help Options"</strong> o "Opciones de Ayuda".</li>
                                    <li>Activa las opciones que deseas habilitar para los estudiantes:
                                        <ul>
                                            <li><strong>Transcript:</strong> Muestra el texto completo del audio</li>
                                            <li><strong>Listening Tips:</strong> Consejos para mejorar la comprensión</li>
                                            <li><strong>Cultural Notes:</strong> Notas culturales</li>
                                            <li><strong>Glossary:</strong> Glosario de palabras clave</li>
                                            <li><strong>Translation:</strong> Traducción del contenido</li>
                                            <li><strong>Dictionary:</strong> Acceso a diccionario</li>
                                        </ul>
                                    </li>
                                    <li>Para cada opción activada, ingresa el contenido correspondiente usando el editor de texto.</li>
                                    <li>Guarda los cambios.</li>
                                </ol>
                                <div class="info-box alert-warning">
                                    <strong>⚠️ Nota:</strong> El uso de estas opciones de ayuda es rastreado y puedes revisarlo en el Tracking System para evaluar cómo los estudiantes utilizan los recursos disponibles.
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingUnit6">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseUnit6" aria-expanded="false" aria-controls="collapseUnit6">
                                💬 Configurar Feedback para Ejercicios
                            </button>
                        </h2>
                        <div id="collapseUnit6" class="accordion-collapse collapse" aria-labelledby="headingUnit6" data-bs-parent="#unitsAccordion">
                            <div class="accordion-body">
                                <strong class="d-block mb-3">Pasos para configurar feedback:</strong>
                                <ol>
                                    <li>Desde la página de detalles del ejercicio, haz clic en <strong>"Feedback Settings"</strong> o "Configuración de Feedback".</li>
                                    <li>Selecciona los tipos de feedback que deseas habilitar:
                                        <ul>
                                            <li><strong>Correct Answer:</strong> Mensaje cuando la respuesta es correcta</li>
                                            <li><strong>Wrong Answer:</strong> Mensaje cuando la respuesta es incorrecta</li>
                                            <li><strong>Knowledge of Correct Response:</strong> Mostrar la respuesta correcta (puede ser texto, audio o imagen)</li>
                                            <li><strong>Elaborative Feedback:</strong> Feedback explicativo adicional</li>
                                        </ul>
                                    </li>
                                    <li>Puedes configurar feedback a nivel de ejercicio o a nivel de pregunta individual.</li>
                                    <li>Para ejercicios de "Dictation Cloze", puedes subir una imagen con todas las respuestas correctas que se mostrará después de 3 intentos.</li>
                                    <li>Guarda la configuración de feedback.</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sección de Configuración de la Plataforma -->
        <div class="faq-section">
            <div class="faq-section-header text-white" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                <div class="section-icon">
                    <span class="material-symbols-outlined">settings</span>
                </div>
                <span>Configuración de la Plataforma</span>
            </div>
            <div class="card-body p-0">
                <div class="accordion faq-accordion" id="configAccordion">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingConfig1">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseConfig1" aria-expanded="true" aria-controls="collapseConfig1">
                                👥 Gestionar Usuarios y Grupos
                            </button>
                        </h2>
                        <div id="collapseConfig1" class="accordion-collapse collapse show" aria-labelledby="headingConfig1" data-bs-parent="#configAccordion">
                            <div class="accordion-body">
                                <strong class="d-block mb-3">Crear y gestionar usuarios:</strong>
                                <ol>
                                    <li>Ve al menú <strong>"Users"</strong> desde el dashboard.</li>
                                    <li>Haz clic en <strong>"Create New User"</strong> para agregar un nuevo estudiante o profesor.</li>
                                    <li>Completa la información: nombre, correo, contraseña, rol y grupo.</li>
                                    <li>Asigna cada usuario a un grupo correspondiente.</li>
                                    <li>Puedes editar o eliminar usuarios desde la lista de usuarios.</li>
                                </ol>
                                <strong class="d-block mb-3 mt-4">Crear y gestionar grupos:</strong>
                                <ol>
                                    <li>Ve al menú <strong>"Groups"</strong> desde el dashboard.</li>
                                    <li>Haz clic en <strong>"Create New Group"</strong> para crear un nuevo grupo.</li>
                                    <li>Asigna unidades a cada grupo desde la página de detalles del grupo.</li>
                                    <li>Los estudiantes solo podrán acceder a las unidades asignadas a su grupo.</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingConfig2">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseConfig2" aria-expanded="false" aria-controls="collapseConfig2">
                                📚 Asignar Unidades a Grupos
                            </button>
                        </h2>
                        <div id="collapseConfig2" class="accordion-collapse collapse" aria-labelledby="headingConfig2" data-bs-parent="#configAccordion">
                            <div class="accordion-body">
                                <strong class="d-block mb-3">Pasos para asignar unidades:</strong>
                                <ol>
                                    <li>Ve al menú <strong>"Groups"</strong> y selecciona el grupo al que deseas asignar unidades.</li>
                                    <li>Desde la página de detalles del grupo, busca la sección <strong>"Units"</strong> o "Unidades".</li>
                                    <li>Haz clic en <strong>"Assign Units"</strong> o "Asignar Unidades".</li>
                                    <li>Selecciona las unidades que deseas asignar al grupo marcando los checkboxes.</li>
                                    <li>Guarda los cambios.</li>
                                    <li>Los estudiantes de ese grupo ahora podrán acceder a las unidades asignadas.</li>
                                </ol>
                                <div class="info-box alert-info">
                                    <strong>💡 Tip:</strong> Puedes asignar diferentes unidades a diferentes grupos según el nivel o curso de los estudiantes.
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingConfig3">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseConfig3" aria-expanded="false" aria-controls="collapseConfig3">
                                📊 Usar el Sistema de Tracking (Researcher Module)
                            </button>
                        </h2>
                        <div id="collapseConfig3" class="accordion-collapse collapse" aria-labelledby="headingConfig3" data-bs-parent="#configAccordion">
                            <div class="accordion-body">
                                <strong class="d-block mb-3">Funcionalidades del Tracking System:</strong>
                                <ul>
                                    <li><strong>Filtrar por grupo o estudiante:</strong> Usa los filtros en la parte superior para ver datos específicos.</li>
                                    <li><strong>Ver respuestas individuales:</strong> Haz clic en cualquier registro para ver detalles completos de la respuesta del estudiante.</li>
                                    <li><strong>Exportar datos:</strong> Usa el botón <strong>"Export data"</strong> para descargar un archivo Excel con todos los datos de seguimiento.</li>
                                    <li><strong>Revisar métricas:</strong> Puedes ver tiempo invertido, respuestas correctas/incorrectas, uso de opciones de ayuda, y más.</li>
                                </ul>
                                <div class="info-box alert-success">
                                    <strong>✅ Beneficio:</strong> El sistema de tracking te permite analizar el progreso de los estudiantes y identificar áreas que necesitan más atención.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sección de Mejores Prácticas -->
        <div class="faq-section">
            <div class="faq-section-header text-white" style="background: linear-gradient(135deg, #0dcaf0 0%, #0d6efd 100%);">
                <div class="section-icon">
                    <span class="material-symbols-outlined">star</span>
                </div>
                <span>Mejores Prácticas</span>
            </div>
            <div class="card-body p-4">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="d-flex align-items-start gap-2">
                            <span class="fs-4">📋</span>
                            <div>
                                <strong>Organización</strong>
                                <p class="mb-0 small text-muted">Crea unidades temáticas claras y organiza las secciones en un orden lógico de aprendizaje.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex align-items-start gap-2">
                            <span class="fs-4">🎨</span>
                            <div>
                                <strong>Variedad</strong>
                                <p class="mb-0 small text-muted">Usa diferentes tipos de ejercicios para mantener el interés y evaluar diferentes habilidades.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex align-items-start gap-2">
                            <span class="fs-4">💬</span>
                            <div>
                                <strong>Feedback constructivo</strong>
                                <p class="mb-0 small text-muted">Proporciona feedback útil que ayude a los estudiantes a entender sus errores y mejorar.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex align-items-start gap-2">
                            <span class="fs-4">🆘</span>
                            <div>
                                <strong>Recursos de ayuda</strong>
                                <p class="mb-0 small text-muted">Configura las opciones de ayuda apropiadas para el nivel de tus estudiantes.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex align-items-start gap-2">
                            <span class="fs-4">📈</span>
                            <div>
                                <strong>Monitoreo regular</strong>
                                <p class="mb-0 small text-muted">Revisa el Tracking System regularmente para identificar estudiantes que necesitan apoyo adicional.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex align-items-start gap-2">
                            <span class="fs-4">✅</span>
                            <div>
                                <strong>Pruebas</strong>
                                <p class="mb-0 small text-muted">Siempre prueba tus ejercicios como estudiante antes de asignarlos para asegurarte de que funcionan correctamente.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
