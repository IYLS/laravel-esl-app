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
            <p>Encuentra respuestas rápidas a tus dudas sobre cómo usar la plataforma</p>
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
                                🔐 ¿Cómo inicio sesión en la plataforma?
                            </button>
                        </h2>
                        <div id="collapseGeneral1" class="accordion-collapse collapse show" aria-labelledby="headingGeneral1" data-bs-parent="#generalAccordion">
                            <div class="accordion-body">
                                Para iniciar sesión, ve a la página de login e ingresa tu correo electrónico y contraseña. Asegúrate de seleccionar el rol <strong>"Estudiante"</strong> antes de hacer clic en "Login".
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingGeneral2">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseGeneral2" aria-expanded="false" aria-controls="collapseGeneral2">
                                📚 ¿Cómo selecciono una unidad para trabajar?
                            </button>
                        </h2>
                        <div id="collapseGeneral2" class="accordion-collapse collapse" aria-labelledby="headingGeneral2" data-bs-parent="#generalAccordion">
                            <div class="accordion-body">
                                Después de iniciar sesión, verás una pantalla de bienvenida. Haz clic en <strong>"Start here"</strong> y luego selecciona la unidad que deseas trabajar desde el menú de selección de nivel.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingGeneral3">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseGeneral3" aria-expanded="false" aria-controls="collapseGeneral3">
                                🔑 ¿Qué hago si olvidé mi contraseña?
                            </button>
                        </h2>
                        <div id="collapseGeneral3" class="accordion-collapse collapse" aria-labelledby="headingGeneral3" data-bs-parent="#generalAccordion">
                            <div class="accordion-body">
                                Si olvidaste tu contraseña, contacta a tu profesor o administrador del sistema para que puedan restablecerla por ti.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sección de Ejemplos de Ejercicios -->
        <div class="faq-section">
            <div class="faq-section-header text-white" style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);">
                <div class="section-icon">
                    <span class="material-symbols-outlined">school</span>
                </div>
                <span>Ejemplos de Cómo Completar Ejercicios</span>
            </div>
            <div class="card-body p-0">
                <div class="accordion faq-accordion" id="examplesAccordion">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingExample1">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample1" aria-expanded="true" aria-controls="collapseExample1">
                                ✅ Ejercicios de Opción Múltiple (Multiple Choice)
                            </button>
                        </h2>
                        <div id="collapseExample1" class="accordion-collapse collapse show" aria-labelledby="headingExample1" data-bs-parent="#examplesAccordion">
                            <div class="accordion-body">
                                <strong class="d-block mb-3">Pasos para completar:</strong>
                                <ol>
                                    <li>Lee cuidadosamente la pregunta o instrucción.</li>
                                    <li>Escucha el audio si está disponible haciendo clic en el botón de reproducción.</li>
                                    <li>Selecciona la opción que consideres correcta marcando el checkbox o radio button correspondiente.</li>
                                    <li>Haz clic en el botón <strong>"Check"</strong> para verificar tu respuesta. Tras el primer envío, el mismo botón mostrará <strong>"Try again"</strong> para que puedas volver a intentar.</li>
                                    <li>Revisa el feedback que aparece: ✓ para respuestas correctas, ✗ para incorrectas.</li>
                                    <li>Puedes usar el botón <strong>"Reset"</strong> para limpiar tus respuestas (máximo 3 veces por ejercicio).</li>
                                </ol>
                                <div class="info-box alert-info">
                                    <strong>💡 Tip:</strong> En ejercicios de "Evaluating statements", si no estás seguro, puedes seleccionar "I'm not sure" y recibirás un feedback especial.
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingExample2">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample2" aria-expanded="false" aria-controls="collapseExample2">
                                ✏️ Ejercicios de Llenar Espacios (Fill in the Gaps)
                            </button>
                        </h2>
                        <div id="collapseExample2" class="accordion-collapse collapse" aria-labelledby="headingExample2" data-bs-parent="#examplesAccordion">
                            <div class="accordion-body">
                                <strong class="d-block mb-3">Pasos para completar:</strong>
                                <ol>
                                    <li>Escucha el audio completo primero para entender el contexto.</li>
                                    <li>Lee el texto con los espacios en blanco (marcados como campos de texto).</li>
                                    <li>Escribe la palabra o frase que falta en cada espacio en blanco.</li>
                                    <li>Asegúrate de escribir correctamente, prestando atención a la ortografía y mayúsculas.</li>
                                    <li>Haz clic en <strong>"Check"</strong> para verificar tus respuestas.</li>
                                    <li>Las respuestas correctas se marcarán en verde, las incorrectas en rojo.</li>
                                    <li>En ejercicios de "Dictation Cloze", después de 3 intentos verás una imagen con todas las respuestas correctas.</li>
                                </ol>
                                <div class="info-box alert-info">
                                    <strong>💡 Tip:</strong> Escucha el audio varias veces si es necesario. Puedes usar las opciones de ayuda como "Transcript" para ver el texto completo.
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingExample3">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample3" aria-expanded="false" aria-controls="collapseExample3">
                                🎯 Ejercicios de Arrastrar y Soltar (Drag and Drop)
                            </button>
                        </h2>
                        <div id="collapseExample3" class="accordion-collapse collapse" aria-labelledby="headingExample3" data-bs-parent="#examplesAccordion">
                            <div class="accordion-body">
                                <strong class="d-block mb-3">Pasos para completar:</strong>
                                <ol>
                                    <li>Lee la pregunta o instrucción cuidadosamente.</li>
                                    <li>Observa las palabras o elementos disponibles en la zona de origen.</li>
                                    <li>Arrastra cada palabra o elemento a su destino correspondiente haciendo clic y manteniendo presionado mientras mueves el mouse.</li>
                                    <li>Suelta el elemento sobre el área de destino correcta.</li>
                                    <li>Repite el proceso para todos los elementos.</li>
                                    <li>Haz clic en <strong>"Check"</strong> para verificar tus respuestas.</li>
                                    <li>Si necesitas corregir, puedes arrastrar los elementos de vuelta a su origen.</li>
                                </ol>
                                <div class="info-box alert-info">
                                    <strong>💡 Tip:</strong> Asegúrate de que cada elemento esté completamente dentro del área de destino antes de soltarlo.
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingExample4">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample4" aria-expanded="false" aria-controls="collapseExample4">
                                📝 Ejercicios de Respuesta Abierta (Open Ended)
                            </button>
                        </h2>
                        <div id="collapseExample4" class="accordion-collapse collapse" aria-labelledby="headingExample4" data-bs-parent="#examplesAccordion">
                            <div class="accordion-body">
                                <strong class="d-block mb-3">Pasos para completar:</strong>
                                <ol>
                                    <li>Lee la pregunta o instrucción detenidamente.</li>
                                    <li>Escucha el audio o revisa el material proporcionado.</li>
                                    <li>Escribe tu respuesta en el campo de texto. Puedes escribir varias oraciones si es necesario.</li>
                                    <li>Revisa tu respuesta antes de enviarla, verificando ortografía y gramática.</li>
                                    <li>Haz clic en <strong>"Check"</strong> para enviar tu respuesta.</li>
                                    <li>Tu respuesta será revisada y recibirás feedback.</li>
                                </ol>
                                <div class="info-box alert-info">
                                    <strong>💡 Tip:</strong> Sé específico y claro en tus respuestas. Usa las opciones de ayuda como "Translation" o "Dictionary" si necesitas apoyo con vocabulario.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sección de Opciones de Ayuda -->
        <div class="faq-section">
            <div class="faq-section-header text-white" style="background: linear-gradient(135deg, #0dcaf0 0%, #0d6efd 100%);">
                <div class="section-icon">
                    <span class="material-symbols-outlined">support</span>
                </div>
                <span>Uso de Opciones de Ayuda</span>
            </div>
            <div class="card-body p-4">
                <p class="mb-3">La plataforma ofrece varias opciones de ayuda que puedes usar mientras completas los ejercicios:</p>
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="d-flex align-items-start gap-2">
                            <span class="fs-4">📄</span>
                            <div>
                                <strong>Transcript</strong>
                                <p class="mb-0 small text-muted">Muestra el texto completo del audio. Útil para verificar lo que escuchaste.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex align-items-start gap-2">
                            <span class="fs-4">💡</span>
                            <div>
                                <strong>Listening Tips</strong>
                                <p class="mb-0 small text-muted">Proporciona consejos para mejorar tu comprensión auditiva.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex align-items-start gap-2">
                            <span class="fs-4">🌍</span>
                            <div>
                                <strong>Culture Notes</strong>
                                <p class="mb-0 small text-muted">Explica aspectos culturales relevantes al contenido.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex align-items-start gap-2">
                            <span class="fs-4">📖</span>
                            <div>
                                <strong>Glossary</strong>
                                <p class="mb-0 small text-muted">Lista de palabras clave con sus definiciones.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex align-items-start gap-2">
                            <span class="fs-4">🌐</span>
                            <div>
                                <strong>Translation</strong>
                                <p class="mb-0 small text-muted">Traducción del contenido a tu idioma nativo.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex align-items-start gap-2">
                            <span class="fs-4">📚</span>
                            <div>
                                <strong>Dictionary</strong>
                                <p class="mb-0 small text-muted">Acceso a un diccionario para buscar palabras.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="info-box alert-warning mt-4">
                    <strong>⚠️ Nota:</strong> El uso de estas opciones de ayuda es registrado y puede ser revisado por tu profesor para evaluar tu proceso de aprendizaje.
                </div>
            </div>
        </div>

        <!-- Sección de Navegación -->
        <div class="faq-section">
            <div class="faq-section-header text-white" style="background: linear-gradient(135deg, #6c757d 0%, #495057 100%);">
                <div class="section-icon">
                    <span class="material-symbols-outlined">navigation</span>
                </div>
                <span>Navegación y Progreso</span>
            </div>
            <div class="card-body p-0">
                <div class="accordion faq-accordion" id="navigationAccordion">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingNav1">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseNav1" aria-expanded="true" aria-controls="collapseNav1">
                                🗺️ ¿Cómo navego entre ejercicios?
                            </button>
                        </h2>
                        <div id="collapseNav1" class="accordion-collapse collapse show" aria-labelledby="headingNav1" data-bs-parent="#navigationAccordion">
                            <div class="accordion-body">
                                Después de completar un ejercicio, aparecerá un botón <strong>"Next exercise"</strong> que te llevará al siguiente ejercicio sin completar en orden. Una vez que completes todos los ejercicios de una sección (stage), aparecerá el botón <strong>"Next stage"</strong>. Cuando completes todas las secciones de una unidad, aparecerá <strong>"Next unit"</strong>.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingNav2">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseNav2" aria-expanded="false" aria-controls="collapseNav2">
                                🔄 ¿Puedo cambiar de unidad mientras trabajo?
                            </button>
                        </h2>
                        <div id="collapseNav2" class="accordion-collapse collapse" aria-labelledby="headingNav2" data-bs-parent="#navigationAccordion">
                            <div class="accordion-body">
                                Sí, puedes cambiar de unidad en cualquier momento usando el enlace <strong>"Choose different unit"</strong> en el menú de navegación superior. Tu progreso en la unidad actual se guardará automáticamente.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>
</div>

@endsection
