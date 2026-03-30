/**
 * JavaScript consolidado para la vista de estudiante (student/show.blade.php)
 * Este archivo contiene toda la lógica de ejercicios organizada y modularizada
 * 
 * PRINCIPIOS APLICADOS:
 * - SOLID: Separación de responsabilidades por módulos
 * - DRY: Eliminación de código duplicado
 * - Clean Code: Nombres descriptivos, funciones pequeñas y enfocadas
 */

(function() {
    'use strict';

    // ============================================================================
    // MÓDULO: Utilidades Generales
    // ============================================================================
    const StudentUtils = {
        /**
         * Convierte milisegundos a formato HH:MM:SS o MM:SS
         */
        millisToHms(ms) {
            const n = Number(ms);
            if (!Number.isFinite(n) || n < 0) return '00:00';

            const totalSeconds = Math.floor(n / 1000);
            const h = Math.floor(totalSeconds / 3600);
            const m = Math.floor((totalSeconds % 3600) / 60);
            const s = totalSeconds % 60;
            const base = `${String(m).padStart(2, '0')}:${String(s).padStart(2, '0')}`;
            return (h > 0) ? `${h}:${base}` : base;
        },

        /**
         * Obtiene el tiempo actual en milisegundos
         */
        getCurrentTime() {
            return new Date().getTime();
        },

        /**
         * Crea un elemento DOM con atributos
         */
        createElement(tag, attributes = {}, content = '') {
            const element = document.createElement(tag);
            Object.keys(attributes).forEach(key => {
                if (key === 'hidden' && attributes[key] === true) {
                    element.hidden = true;
                } else {
                    element.setAttribute(key, attributes[key]);
                }
            });
            if (content) {
                element.innerHTML = content;
            }
            return element;
        }
    };

    // ============================================================================
    // MÓDULO: Timer de Ejercicios
    // ============================================================================
    const ExerciseTimer = {
        startTime: null,

        start() {
            this.startTime = StudentUtils.getCurrentTime();
            window.startTime = this.startTime;
        },

        getElapsedTime() {
            if (!this.startTime) return '00:00';
            const elapsed = StudentUtils.getCurrentTime() - this.startTime;
            return StudentUtils.millisToHms(elapsed);
        },

        getElapsedMilliseconds() {
            if (!this.startTime) return 0;
            return StudentUtils.getCurrentTime() - this.startTime;
        }
    };

    // ============================================================================
    // MÓDULO: Drag and Drop
    // ============================================================================
    const DragAndDropHandler = {
        allowDrop(ev) {
            ev.preventDefault();
        },

        drag(ev) {
            ev.dataTransfer.setData("text", ev.target.id);
        },

        drop(ev) {
            ev.preventDefault();
            const data = ev.dataTransfer.getData("text");
            const element = document.getElementById(data);
            if (element && ev.target) {
                ev.target.appendChild(element);
            }
        }
    };

    /**
     * Normaliza subtype del ejercicio (evita fallos por string "99" vs número 99).
     */
    function exerciseSubtypeNum(exercise) {
        const s = exercise && exercise.subtype;
        if (s === null || s === undefined || s === '') {
            return null;
        }
        const n = Number(s);
        return Number.isNaN(n) ? null : n;
    }

    // ============================================================================
    // MÓDULO: Feedback Manager
    // ============================================================================
    const FeedbackManager = {
        /**
         * Muestra u oculta feedback
         */
        setVisibility(hidden, exerciseId, questions) {
            questions.forEach(question => {
                const feedbackElement = document.getElementById(`question-feedback-container-${question.id}`);
                if (feedbackElement) {
                    feedbackElement.hidden = hidden;
                }
            });

            const exerciseFeedback = document.getElementById(`feedback-exercise-details-container-${exerciseId}`);
            if (exerciseFeedback) {
                exerciseFeedback.hidden = hidden;
            }

            const shortMsgA = document.getElementById(`feedback-exercise-short-message-a-${exerciseId}`);
            if (shortMsgA) {
                shortMsgA.hidden = hidden;
            }
        },

        /**
         * Muestra feedback correcto
         */
        showCorrect(questionId) {
            const correct = document.getElementById(`question-${questionId}-feedback-correct`);
            const wrong = document.getElementById(`question-${questionId}-feedback-wrong`);
            if (correct) correct.hidden = false;
            if (wrong) wrong.hidden = true;
        },

        /**
         * Muestra feedback incorrecto
         */
        showWrong(questionId) {
            const correct = document.getElementById(`question-${questionId}-feedback-correct`);
            const wrong = document.getElementById(`question-${questionId}-feedback-wrong`);
            const notSure = document.getElementById(`question-${questionId}-feedback-not-sure`);
            if (correct) correct.hidden = true;
            if (wrong) wrong.hidden = false;
            if (notSure) notSure.hidden = true;
        },

        /**
         * Muestra feedback para "I'm not sure" (Evaluating statements)
         */
        showNotSure(questionId) {
            const correct = document.getElementById(`question-${questionId}-feedback-correct`);
            const wrong = document.getElementById(`question-${questionId}-feedback-wrong`);
            const notSure = document.getElementById(`question-${questionId}-feedback-not-sure`);
            if (correct) correct.hidden = true;
            if (wrong) wrong.hidden = true;
            if (notSure) notSure.hidden = false;
        },

        /**
         * Actualiza contadores de respuestas
         */
        updateCounters(exerciseId, correctCount, wrongCount) {
            const correctElement = document.getElementById(`feedback-exercise-correct-${exerciseId}`);
            const wrongElement = document.getElementById(`feedback-exercise-wrong-${exerciseId}`);
            
            if (correctElement) {
                correctElement.innerHTML = `<strong>${correctCount}</strong>  ✅`;
                correctElement.hidden = false;
            }
            
            if (wrongElement) {
                wrongElement.innerHTML = `<strong>${wrongCount}</strong>  ❌`;
                wrongElement.hidden = false;
            }
        },

        /**
         * Muestra u oculta mensajes condicionales
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

    // ============================================================================
    // MÓDULO: Tracking de Help Options
    // ============================================================================
    const HelpOptionsTracking = {
        data: {
            transcript: { count: 0, totalTime: 0 },
            listening_tips: { count: 0, totalTime: 0 },
            cultural_notes: { count: 0, totalTime: 0 },
            glossary: { count: 0, totalTime: 0 },
            translation: { count: 0, totalTime: 0 },
            dictionary: { count: 0, totalTime: 0 }
        },
        startTime: null,
        currentExerciseId: null,

        /**
         * Inicializa el tracking para un nuevo ejercicio
         */
        initExercise(exerciseId) {
            this.currentExerciseId = exerciseId;
            this.reset();
        },

        /**
         * Reinicia todos los contadores
         */
        reset() {
            Object.keys(this.data).forEach(key => {
                this.data[key].count = 0;
                this.data[key].totalTime = 0;
            });
        },

        /**
         * Registra cuando se abre una opción de ayuda
         */
        onOpened(type) {
            this.startTime = StudentUtils.getCurrentTime();
        },

        /**
         * Registra cuando se cierra una opción de ayuda
         */
        onClosed(type) {
            if (!this.startTime) return;

            const timeSpent = StudentUtils.getCurrentTime() - this.startTime;
            const option = this.data[type];

            if (option) {
                option.count += 1;
                option.totalTime += timeSpent;
                console.log(`Total time spent in ${type}: ${StudentUtils.millisToHms(option.totalTime)}`);
                console.log(`${type}_count: ${option.count}`);
            }

            this.startTime = null;
        },

        /**
         * Reinicia contadores de feedback interactions
         */
        resetFeedbackInteractions(exerciseId) {
            const items = document.getElementsByClassName(`feedback_interactions_count_${exerciseId}`);
            Array.from(items).forEach(item => {
                item.setAttribute('value', '0');
            });
        },

        /**
         * Agrega valores de tracking al formulario
         */
        appendToForm(exerciseId, formType) {
            const form = document.getElementById(`${formType}_form_${exerciseId}`);
            if (!form) return;

            const mappings = {
                'transcript': { count: 'transcript_count', time: 'transcript_total_time' },
                'listening_tips': { count: 'listening_tips_count', time: 'listening_tips_total_time' },
                'cultural_notes': { count: 'cultural_notes_count', time: 'cultural_notes_total_time' },
                'glossary': { count: 'glossary_count', time: 'glossary_total_time' },
                'translation': { count: 'translation_count', time: 'translation_total_time' },
                'dictionary': { count: 'dictionary_count', time: 'dictionary_total_time' }
            };

            Object.keys(mappings).forEach(type => {
                const mapping = mappings[type];
                const data = this.data[type];

                if (!data) {
                    console.warn(`Help option data not found for type: ${type}`);
                    return;
                }

                // Count input
                const countInput = StudentUtils.createElement('input', {
                    'name': mapping.count,
                    'value': data.count || 0,
                    'hidden': true
                });
                form.appendChild(countInput);

                // Time input: backend espera segundos (integer), no formato HH:MM:SS
                const timeInput = StudentUtils.createElement('input', {
                    'name': mapping.time,
                    'value': Math.round((data.totalTime || 0) / 1000),
                    'hidden': true
                });
                form.appendChild(timeInput);
            });
        }
    };

    // ============================================================================
    // MÓDULO: Procesamiento de Respuestas por Tipo de Ejercicio
    // ============================================================================
    const ExerciseResponseProcessor = {
        /**
         * Procesa respuestas de Multiple Choice
         */
        processMultipleChoice(questions, exercise) {
            let correctQuestions = 0;
            const responses = [];
            const isPersonalResponse = questions[0]?.personal_response === true;
            const shouldShowFeedback = !isPersonalResponse;
            const st = exerciseSubtypeNum(exercise);

            questions.forEach(question => {
                const alternatives = document.getElementsByName(`question-${question.id}`);

                // Ocultar todos los feedbacks explicativos primero
                Array.from(alternatives).forEach(alt => {
                    const explanatory = document.getElementById(`${alt.value}-explanatory`);
                    if (explanatory) explanatory.hidden = true;
                });

                // Procesar alternativas seleccionadas
                Array.from(alternatives).forEach(alternative => {
                    if (alternative.checked) {
                        const isCorrect = question.correct_answer == alternative.value;
                        const responseText = alternative.value || alternative.parentNode.children[1]?.innerHTML?.trim() || '';
                        const isNotSure = responseText.toLowerCase().includes("i'm not sure") || 
                                         responseText.toLowerCase().includes("not sure") ||
                                         responseText.toLowerCase().includes("im not sure");

                        if (isCorrect) {
                            responses.push({
                                id: String(question.id),
                                response: String(question.correct_answer)
                            });
                            if (shouldShowFeedback) {
                                FeedbackManager.showCorrect(question.id);
                            }
                            correctQuestions++;
                        } else if (isNotSure && st === 3) {
                            // Evaluating statements: mostrar emoji pensativo para "I'm not sure"
                            responses.push({
                                id: String(question.id),
                                response: responseText
                            });
                            if (shouldShowFeedback) {
                                FeedbackManager.showNotSure(question.id);
                                const explanatory = document.getElementById(`${alternative.value}-explanatory`);
                                if (explanatory) explanatory.hidden = false;
                            }
                        } else {
                            responses.push({
                                id: String(question.id),
                                response: responseText
                            });
                            if (shouldShowFeedback) {
                                FeedbackManager.showWrong(question.id);
                                const explanatory = document.getElementById(`${alternative.value}-explanatory`);
                                if (explanatory) explanatory.hidden = false;
                            }
                        }
                    }
                });
            });

            const wrongQuestions = questions.length - correctQuestions;

            if (shouldShowFeedback) {
                FeedbackManager.toggleConditionalMessages(exercise.id, questions.length, correctQuestions);
                FeedbackManager.updateCounters(exercise.id, correctQuestions, wrongQuestions);
                FeedbackManager.setVisibility(false, exercise.id, questions);
            }

            return {
                correct: correctQuestions,
                wrong: wrongQuestions,
                responses: responses
            };
        },

        /**
         * Procesa respuestas de Fill in the Gaps (Vocabulary Practice)
         */
        processFillInTheGaps(questions, exercise) {
            let correctQuestions = 0;
            const responses = [];

            questions.forEach(question => {
                const answers = document.getElementsByName(`answer-${question.id}`);
                const questionResponses = Array.from(answers).map(a => a.value);
                const finalResponses = questionResponses.join(',');

                responses.push({
                    id: String(question.id),
                    response: finalResponses
                });

                if (finalResponses === question.answer) {
                    FeedbackManager.showCorrect(question.id);
                    correctQuestions++;
                } else {
                    FeedbackManager.showWrong(question.id);
                }
            });

            const wrongQuestions = questions.length - correctQuestions;
            FeedbackManager.toggleConditionalMessages(exercise.id, questions.length, correctQuestions);
            FeedbackManager.updateCounters(exercise.id, correctQuestions, wrongQuestions);
            FeedbackManager.setVisibility(false, exercise.id, questions);

            return {
                correct: correctQuestions,
                wrong: wrongQuestions,
                responses: responses
            };
        },

        /**
         * Procesa respuestas de Dictation Cloze
         */
        processDictationCloze(questions, exercise) {
            let correctQuestions = 0;
            let questionsNumber = 0;
            const responses = [];

            questions.forEach(question => {
                const answers = document.getElementsByName(`answer-${question.id}`);
                questionsNumber = answers.length;
                const questionResponses = [];

                Array.from(answers).forEach(answer => {
                    const isCorrect = question.answer.includes(answer.value) && answer.value !== '';
                    const isWrong = !question.answer.includes(answer.value);

                    if (isCorrect) {
                        answer.style.setProperty('border-color', 'lime', 'important');
                        correctQuestions++;
                    } else if (isWrong) {
                        answer.style.setProperty('border-color', 'red', 'important');
                    }

                    questionResponses.push(answer.value);
                });

                responses.push({
                    id: String(question.id),
                    response: questionResponses.join(',')
                });
            });

            const wrongQuestions = questionsNumber - correctQuestions;
            FeedbackManager.toggleConditionalMessages(exercise.id, questionsNumber, correctQuestions);
            FeedbackManager.updateCounters(exercise.id, correctQuestions, wrongQuestions);

            const exerciseFeedback = document.getElementById(`feedback-exercise-details-container-${exercise.id}`);
            if (exerciseFeedback) {
                exerciseFeedback.hidden = false;
            }

            // Deshabilitar botón de intentar de nuevo
            const tryAgainBtn = document.querySelector(`[onclick*="resetExercise(${exercise.id}"]`);
            if (tryAgainBtn) {
                tryAgainBtn.disabled = true;
            }

            return {
                correct: correctQuestions,
                wrong: wrongQuestions,
                responses: responses
            };
        },

        /**
         * Procesa respuestas de Drag and Drop
         */
        processDragAndDrop(questions, exercise) {
            let correctQuestions = 0;
            let wrongQuestions = 0;
            const responses = [];
            questions.forEach(question => {
                const definitionContainer = document.getElementById(`word-destination-${question.answer}`);
                const wordContainer = document.getElementById(`word-${question.statement}`);

                if (definitionContainer && definitionContainer.firstChild) {
                    const actualResponse = definitionContainer.firstChild.innerHTML.trim();
                    responses.push({
                        id: String(question.id),
                        response: actualResponse
                    });

                    if (definitionContainer.contains(wordContainer)) {
                        FeedbackManager.showCorrect(question.id);
                        correctQuestions++;
                    } else {
                        FeedbackManager.showWrong(question.id);
                    }
                } else {
                    responses.push({
                        id: String(question.id),
                        response: ''
                    });
                    FeedbackManager.showWrong(question.id);
                }
            });

            wrongQuestions = questions.length - correctQuestions;
            FeedbackManager.toggleConditionalMessages(exercise.id, questions.length, correctQuestions);
            FeedbackManager.updateCounters(exercise.id, correctQuestions, wrongQuestions);
            FeedbackManager.setVisibility(false, exercise.id, questions);

            return {
                correct: correctQuestions,
                wrong: wrongQuestions,
                responses: responses
            };
        },

        /**
         * Procesa respuestas de Poll (Likert 1-7)
         */
        processPoll(questions, exercise) {
            const responses = [];
            let answeredCount = 0;

            questions.forEach(question => {
                const selected = document.querySelector(`input[name="question-${question.id}"]:checked`);
                if (selected) {
                    responses.push({
                        id: String(question.id),
                        response: String(selected.value)
                    });
                    answeredCount++;
                }
            });

            const total = questions.length;
            const correctQuestions = answeredCount === total ? total : 0;
            const wrongQuestions = total - answeredCount;

            FeedbackManager.toggleConditionalMessages(exercise.id, total, correctQuestions);
            FeedbackManager.updateCounters(exercise.id, answeredCount, wrongQuestions);
            FeedbackManager.setVisibility(false, exercise.id, questions);

            return {
                correct: correctQuestions,
                wrong: wrongQuestions,
                responses: responses
            };
        },

        /**
         * Procesa respuestas de Form (tabla con checkboxes/radios)
         */
        processForm(questions, exercise) {
            let correctQuestions = 0;
            const responses = [];

            questions.forEach(question => {
                const hasDouble = question.answer != null && question.answer !== '';
                const checked = document.querySelectorAll(`input.answer-${question.id}:checked`);
                const vals = Array.from(checked).map(c => c.value).join(';;');
                responses.push({
                    id: String(question.id),
                    response: vals
                });

                if (checked.length === 0) {
                    FeedbackManager.showWrong(question.id);
                    return;
                }

                let ok = true;
                if (hasDouble) {
                    const c0 = document.querySelectorAll(`input[name^="answers[${question.id}][0]"]:checked`).length;
                    const c1 = document.querySelectorAll(`input[name^="answers[${question.id}][1]"]:checked`).length;
                    ok = c0 > 0 && c1 > 0;
                } else {
                    const alts = question.alternatives || [];
                    const mustCorrect = alts.filter(a => a.correct_alt).map(a => String(a.id));
                    if (mustCorrect.length > 0) {
                        const selectedIds = Array.from(checked).map(inp => {
                            const m = String(inp.name).match(/\[(\d+)\]$/);
                            if (m) {
                                return m[1];
                            }
                            const v = String(inp.value || '');
                            const found = alts.find(a => v.includes(String(a.title)));
                            return found ? String(found.id) : '';
                        }).filter(Boolean);
                        ok = mustCorrect.length === selectedIds.length &&
                            mustCorrect.every(id => selectedIds.includes(id));
                    } else {
                        ok = true;
                    }
                }

                if (ok) {
                    FeedbackManager.showCorrect(question.id);
                    correctQuestions++;
                } else {
                    FeedbackManager.showWrong(question.id);
                }
            });

            const wrongQuestions = questions.length - correctQuestions;
            FeedbackManager.toggleConditionalMessages(exercise.id, questions.length, correctQuestions);
            FeedbackManager.updateCounters(exercise.id, correctQuestions, wrongQuestions);
            FeedbackManager.setVisibility(false, exercise.id, questions);

            return {
                correct: correctQuestions,
                wrong: wrongQuestions,
                responses: responses
            };
        },

        /**
         * Procesa respuestas de Open Ended
         */
        processOpenEnded(questions, exercise) {
            const responses = [];
            let questionsNumber = 0;

            questions.forEach(question => {
                const answers = document.getElementsByName(`answer-${question.id}`);
                Array.from(answers).forEach(answer => {
                    responses.push({
                        id: String(question.id),
                        response: String(answer.value)
                    });
                });

                if (answers.length > 0) {
                    questionsNumber = answers.length;
                    FeedbackManager.showCorrect(question.id);
                }
            });

            const correctQuestions = questionsNumber;
            FeedbackManager.toggleConditionalMessages(exercise.id, questionsNumber, correctQuestions);
            FeedbackManager.setVisibility(false, exercise.id, questions);

            return {
                responses: responses
            };
        }
    };

    // ============================================================================
    // MÓDULO: Gestor Principal de Respuestas
    // ============================================================================
    const ResponseDataHandler = {
        /**
         * Obtiene y procesa datos de respuesta según el tipo de ejercicio
         */
        getResponseData(questions, exercise, type) {
            let answers = {};

            switch (type) {
                case 'drag_and_drop':
                    answers = ExerciseResponseProcessor.processDragAndDrop(questions, exercise);
                    break;
                case 'multiple_choice':
                    answers = ExerciseResponseProcessor.processMultipleChoice(questions, exercise);
                    break;
                case 'fill_in_the_gaps':
                    if (exerciseSubtypeNum(exercise) === 2) {
                        answers = ExerciseResponseProcessor.processFillInTheGaps(questions, exercise);
                    } else {
                        answers = ExerciseResponseProcessor.processDictationCloze(questions, exercise);
                    }
                    break;
                case 'open_ended':
                    answers = ExerciseResponseProcessor.processOpenEnded(questions, exercise);
                    break;
                case 'poll':
                    answers = ExerciseResponseProcessor.processPoll(questions, exercise);
                    break;
                case 'form':
                    answers = ExerciseResponseProcessor.processForm(questions, exercise);
                    break;
                default:
                    answers = { responses: [] };
            }

            // Agregar valores de tracking
            HelpOptionsTracking.appendToForm(exercise.id, type);

            // Calcular y agregar tiempo
            const timeSpent = ExerciseTimer.getElapsedTime();
            const form = document.getElementById(`${type}_form_${exercise.id}`);
            
            if (!form) return answers;

            // Agregar tiempo siempre
            const timeInput = StudentUtils.createElement('input', {
                'name': 'time',
                'value': timeSpent,
                'hidden': true
            });
            form.appendChild(timeInput);

            // Agregar correctas e incorrectas si corresponde
            const shouldIncludeCounts = type !== 'open_ended' && answers.correct !== undefined;

            if (shouldIncludeCounts && answers.correct !== undefined) {
                const correctInput = StudentUtils.createElement('input', {
                    'name': 'correct',
                    'value': String(answers.correct),
                    'hidden': true
                });
                form.appendChild(correctInput);

                const wrongInput = StudentUtils.createElement('input', {
                    'name': 'wrong',
                    'value': String(answers.wrong),
                    'hidden': true
                });
                form.appendChild(wrongInput);
            }

            // Agregar respuestas
            if (type !== 'form' && answers.responses && answers.responses.length > 0) {
                answers.responses.forEach(item => {
                    const responseInput = StudentUtils.createElement('input', {
                        'name': `responses[${item.id}]`,
                        'value': item.response,
                        'hidden': true
                    });
                    form.appendChild(responseInput);
                });
            }

            return answers;
        }
    };

    // ============================================================================
    // MÓDULO: Gestor de Modales
    // ============================================================================
    const ModalHandler = {
        /**
         * Presenta el modal de finalización de ejercicio
         */
        presentExerciseCompletion(feedbackMessage, statusMessage, url, type, currentExerciseUrl) {
            // Remover modal existente si existe
            const existingModal = document.getElementById('alert-modal');
            if (existingModal) {
                existingModal.remove();
            }

            // Crear estructura del modal
            const modalContainer = StudentUtils.createElement('div', {
                'class': 'modal fade',
                'id': 'alert-modal',
                'tabindex': '-1',
                'aria-labelledby': 'alert-modal',
                'aria-hidden': 'true'
            });

            const modalDialog = StudentUtils.createElement('div', {
                'class': 'modal-dialog modal-dialog-centered'
            });

            const modalContent = StudentUtils.createElement('div', {
                'class': 'modal-content'
            });

            const modalHeader = StudentUtils.createElement('div', {
                'class': 'd-flex justify-content-end pt-2 pe-2'
            }, '<button type="button" class="btn-close btn-sm" data-bs-dismiss="modal" aria-label="Close"></button>');

            const modalBody = StudentUtils.createElement('div', {
                'class': 'modal-body'
            });

            const messageContainer = StudentUtils.createElement('div', {
                'class': 'p-2'
            });

            const messageText = StudentUtils.createElement('p', {
                'class': 'text-center text-success',
                'id': 'alert-modal-message'
            }, feedbackMessage);

            const statusText = StudentUtils.createElement('h4', {
                'class': 'text-center text-dark',
                'id': 'alert-modal-status'
            }, statusMessage);

            const buttonContainer = StudentUtils.createElement('div', {
                'class': 'd-flex justify-content-center p-2'
            });

            const cancelButton = StudentUtils.createElement('button', {
                'class': 'btn btn-sm btn-secondary me-2',
                'type': 'button',
                'data-bs-dismiss': 'modal'
            }, 'Check results');

            const statusButton = StudentUtils.createElement('button', {
                'class': 'text-center btn btn-primary btn-sm',
                'type': 'button'
            });

            const buttonText = type === 'section' ? 'Next stage' : `Next ${type}`;
            statusButton.innerHTML = buttonText;
            statusButton.setAttribute('onclick', `goTo('${url}', '${type}', '${currentExerciseUrl}')`);

            // Construir estructura
            buttonContainer.appendChild(cancelButton);
            buttonContainer.appendChild(statusButton);
            messageContainer.appendChild(messageText);
            messageContainer.appendChild(statusText);
            messageContainer.appendChild(buttonContainer);
            modalBody.appendChild(messageContainer);
            modalContent.appendChild(modalHeader);
            modalContent.appendChild(modalBody);
            modalDialog.appendChild(modalContent);
            modalContainer.appendChild(modalDialog);

            // Agregar al body y mostrar
            document.body.appendChild(modalContainer);

            // Mostrar modal con jQuery (compatibilidad)
            $(function() {
                $("#alert-modal").modal("show");
            });
        }
    };

    // ============================================================================
    // MÓDULO: Gestor de Navegación
    // ============================================================================
    const NavigationHandler = {
        /**
         * Navega según el tipo especificado
         */
        goTo(uri, type, currentExerciseUrl) {
            switch (type) {
                case 'unit':
                    if (uri) {
                        window.location.href = uri;
                    } else {
                        window.location.reload();
                    }
                    break;

                case 'section':
                    this.switchToSection(uri);
                    break;

                case 'exercise':
                    this.switchToExercise(uri, currentExerciseUrl);
                    break;
            }

            // Cerrar modal
            const modal = document.getElementById('alert-modal');
            if (modal) {
                $('#alert-modal').modal('hide');
            }
        },

        /**
         * Cambia a una sección específica
         */
        switchToSection(sectionId) {
            const wantedTabButton = document.querySelector(`button#${sectionId}-tab`);
            const activeTabButton = document.querySelector(`button.section-btn.active`);

            const wantedTabPane = document.querySelector(`div#${sectionId}`);
            const activeTabPane = document.querySelector(`div.section-pane.active`);

            if (activeTabButton && wantedTabButton) {
                activeTabButton.classList.remove('active');
                wantedTabButton.classList.add('active');
            }

            if (activeTabPane && wantedTabPane) {
                activeTabPane.classList.remove('active', 'show');
                wantedTabPane.classList.add('show', 'active');
            }

            if (wantedTabButton) {
                wantedTabButton.click();
            }
        },

        /**
         * Cambia a un ejercicio específico
         */
        switchToExercise(exerciseId, currentExerciseId) {
            const wantedTabButton = document.querySelector(`button#${exerciseId}-tab`);
            const activeTabButton = document.querySelector(`button#${currentExerciseId}-tab`);

            const wantedTabPane = document.querySelector(`div#${exerciseId}`);
            const activeTabPane = document.querySelector(`div#${currentExerciseId}`);

            if (activeTabButton && wantedTabButton) {
                activeTabButton.classList.remove('active');
                wantedTabButton.classList.add('active');
            }

            if (activeTabPane && wantedTabPane) {
                activeTabPane.classList.remove('active', 'show');
                wantedTabPane.classList.add('show', 'active');
            }

            if (wantedTabButton) {
                wantedTabButton.click();
            }
        }
    };

    // ============================================================================
    // MÓDULO: Gestor de Envío de Ejercicios
    // ============================================================================
    const ExerciseSubmitHandler = {
        /**
         * Maneja el envío del formulario de ejercicio
         */
        handleSubmit(exercise, questions, type, exerciseId, userId, route) {
            // Obtener datos de respuesta (excepto voice_recognition)
            if (type !== 'voice_recognition') {
                ResponseDataHandler.getResponseData(questions, exercise, type);
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
                    ModalHandler.presentExerciseCompletion(
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

    // ============================================================================
    // FUNCIONES GLOBALES PARA COMPATIBILIDAD
    // ============================================================================
    
    // Funciones de utilidad
    window.millisToHms = function(ms) {
        return StudentUtils.millisToHms(ms);
    };

    window.startTimer = function() {
        ExerciseTimer.start();
    };

    // Drag and Drop
    window.allowDrop = function(ev) {
        DragAndDropHandler.allowDrop(ev);
    };

    window.drag = function(ev) {
        DragAndDropHandler.drag(ev);
    };

    window.drop = function(ev) {
        DragAndDropHandler.drop(ev);
    };

    // Feedback
    window.setFeedbackHidden = function(value, exerciseId, questions) {
        FeedbackManager.setVisibility(value, exerciseId, questions);
    };

    // Respuestas
    window.getResponseData = function(questions, exercise, type) {
        return ResponseDataHandler.getResponseData(questions, exercise, type);
    };

    window.getMultipleChoiceResults = function(questions, exercise) {
        return ExerciseResponseProcessor.processMultipleChoice(questions, exercise);
    };

    window.getFillInTheGapsResults = function(questions, exercise) {
        return ExerciseResponseProcessor.processFillInTheGaps(questions, exercise);
    };

    window.getDictationClozeResults = function(questions, exercise) {
        return ExerciseResponseProcessor.processDictationCloze(questions, exercise);
    };

    window.getDragAndDropResults = function(questions, exercise) {
        return ExerciseResponseProcessor.processDragAndDrop(questions, exercise);
    };

    window.getOpenEndedResults = function(questions, exercise) {
        return ExerciseResponseProcessor.processOpenEnded(questions, exercise);
    };

    // Tracking
    window.onHelpOptionClicked = function(type) {
        HelpOptionsTracking.onOpened(type);
    };

    window.onHelpOptionDismissed = function(type) {
        HelpOptionsTracking.onClosed(type);
    };

    window.setCurrentExercise = function(exerciseId) {
        HelpOptionsTracking.currentExerciseId = exerciseId;
        console.log(`Current exercise id: ${exerciseId}`);
    };

    window.onExerciseClicked = function(exerciseId) {
        HelpOptionsTracking.initExercise(exerciseId);
        ExerciseTimer.start();
    };

    window.appendTrackingValues = function(exerciseId, type) {
        HelpOptionsTracking.appendToForm(exerciseId, type);
    };

    window.resetFeedbackInteractionsCount = function(exerciseId) {
        HelpOptionsTracking.resetFeedbackInteractions(exerciseId);
    };

    // Modales y navegación
    window.presentModal = function(feedbackMessage, statusMessage, url, type, currentExerciseUrl) {
        ModalHandler.presentExerciseCompletion(feedbackMessage, statusMessage, url, type, currentExerciseUrl);
    };

    window.goTo = function(uri, type, currentExerciseUrl) {
        NavigationHandler.goTo(uri, type, currentExerciseUrl);
    };

    // Envío de ejercicios
    window.checkAction = function(exercise, questions, type, exerciseId, userId, route) {
        ExerciseSubmitHandler.handleSubmit(exercise, questions, type, exerciseId, userId, route);
    };

    // Reset
    window.resetExercise = function(exerciseId, questions, exerciseType) {
        // Si no se proporciona el tipo, intentar detectarlo o usar múltiple choice por defecto
        if (!exerciseType) {
            // Intentar detectar por elementos presentes
            const checkboxes = document.getElementsByClassName(`multiple-choice-${exerciseId}-check`);
            if (checkboxes.length > 0) {
                exerciseType = 'multiple_choice';
            } else {
                // Por defecto, solo resetear feedback
                FeedbackManager.setVisibility(true, exerciseId, questions);
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

            case 'poll':
                // Desmarcar todos los radios del poll
                const pollRadios = document.querySelectorAll(`.poll-${exerciseId}-check`);
                Array.from(pollRadios).forEach(radio => {
                    radio.checked = false;
                });
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
        FeedbackManager.setVisibility(true, exerciseId, questions);
        
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

    // Utilidades específicas
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

    // Inicializar timer cuando se carga la página
    document.addEventListener('DOMContentLoaded', function() {
        ExerciseTimer.start();

        // Capturar cierre de help options por Escape u otros medios (no solo click en X)
        document.querySelectorAll('.modal[data-help-type]').forEach(function(modal) {
            const helpType = modal.getAttribute('data-help-type');
            if (helpType) {
                modal.addEventListener('hidden.bs.modal', function() {
                    if (typeof window.onHelpOptionDismissed === 'function') {
                        window.onHelpOptionDismissed(helpType);
                    }
                });
            }
        });
    });

})();