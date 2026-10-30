/**
 * Módulo de procesamiento de respuestas por tipo de ejercicio
 * Maneja la lógica específica de cada tipo de ejercicio
 */
function exerciseSubtypeNum(exercise) {
    const s = exercise && exercise.subtype;
    if (s === null || s === undefined || s === '') {
        return null;
    }
    const n = Number(s);
    return Number.isNaN(n) ? null : n;
}

const ExerciseTypes = {
    /**
     * Procesa respuestas de Multiple Choice
     * @param {Array} questions - Preguntas del ejercicio
     * @param {Object} exercise - Datos del ejercicio
     * @returns {Object} - Resultados procesados
     */
    processMultipleChoice(questions, exercise) {
        let correctQuestions = 0;
        let wrongQuestions = 0;
        const responses = [];
        const isPersonalResponse = questions[0]?.personal_response === true;
        const shouldShowFeedback = !isPersonalResponse;
        const st = exerciseSubtypeNum(exercise);

        questions.forEach(question => {
            const alternatives = document.getElementsByName(`question-${question.id}`);
            let questionAnswered = false;

            alternatives.forEach(alternative => {
                // Ocultar feedback explicativo de todas las alternativas primero
                const explanatory = document.getElementById(`${alternative.value}-explanatory`);
                if (explanatory) {
                    explanatory.hidden = true;
                }

                if (alternative.checked) {
                    questionAnswered = true;
                    // Normalizar ambas cadenas antes de comparar para manejar entidades HTML
                    const isCorrect = Utils.compareNormalized(question.correct_answer, alternative.value);
                    const responseText = alternative.value || alternative.parentNode.children[1]?.innerHTML?.trim() || '';
                    const isNotSure = responseText.toLowerCase().includes("i'm not sure") || 
                                     responseText.toLowerCase().includes("im not sure") ||
                                     responseText.toLowerCase().includes("not sure");

                    if (isCorrect) {
                        responses.push({
                            id: String(question.id),
                            response: String(question.correct_answer)
                        });

                        if (shouldShowFeedback) {
                            Feedback.showCorrect(question.id);
                        }
                        correctQuestions++;
                    } else if (isNotSure && st === 3) {
                        // Evaluating statements: mostrar emoji pensativo para "I'm not sure"
                        responses.push({
                            id: String(question.id),
                            response: responseText
                        });

                        if (shouldShowFeedback) {
                            Feedback.showNotSure(question.id);
                            if (explanatory) {
                                explanatory.hidden = false;
                            }
                        }
                    } else {
                        responses.push({
                            id: String(question.id),
                            response: responseText
                        });

                        if (shouldShowFeedback) {
                            Feedback.showWrong(question.id);
                            if (explanatory) {
                                explanatory.hidden = false;
                            }
                        }
                    }
                }
            });
        });

        wrongQuestions = questions.length - correctQuestions;

        if (shouldShowFeedback) {
            Feedback.toggleConditionalMessages(exercise.id, questions.length, correctQuestions);
            Feedback.updateCounters(exercise.id, correctQuestions, wrongQuestions);
            Feedback.setVisibility(false, exercise.id, questions);
        }

        return {
            correct: correctQuestions,
            wrong: wrongQuestions,
            responses: responses
        };
    },

    /**
     * Procesa respuestas de Fill in the Gaps (Vocabulary Practice)
     * @param {Array} questions - Preguntas del ejercicio
     * @param {Object} exercise - Datos del ejercicio
     * @returns {Object} - Resultados procesados
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
                Feedback.showCorrect(question.id);
                correctQuestions++;
            } else {
                Feedback.showWrong(question.id);
            }
        });

        const wrongQuestions = questions.length - correctQuestions;

        Feedback.toggleConditionalMessages(exercise.id, questions.length, correctQuestions);
        Feedback.updateCounters(exercise.id, correctQuestions, wrongQuestions);
        Feedback.setVisibility(false, exercise.id, questions);

        return {
            correct: correctQuestions,
            wrong: wrongQuestions,
            responses: responses
        };
    },

    /**
     * Procesa respuestas de Dictation Cloze
     * @param {Array} questions - Preguntas del ejercicio
     * @param {Object} exercise - Datos del ejercicio
     * @returns {Object} - Resultados procesados
     */
    processDictationCloze(questions, exercise) {
        let correctQuestions = 0;
        const responses = [];

        questions.forEach(question => {
            const answers = document.getElementsByName(`answer-${question.id}`);
            const questionResponses = [];
            const correctAnswers = question.answer.split(',');

            Array.from(answers).forEach(answer => {
                const isCorrect = question.answer.includes(answer.value) && answer.value !== '';
                
                if (isCorrect) {
                    answer.style.setProperty('border-color', 'lime', 'important');
                    correctQuestions++;
                } else if (!question.answer.includes(answer.value)) {
                    answer.style.setProperty('border-color', 'red', 'important');
                }

                questionResponses.push(answer.value);
            });

            responses.push({
                id: String(question.id),
                response: questionResponses.join(',')
            });
        });

        const wrongQuestions = Array.from(document.getElementsByName(`answer-${questions[0].id}`)).length - correctQuestions;

        Feedback.toggleConditionalMessages(exercise.id, 
            Array.from(document.getElementsByName(`answer-${questions[0].id}`)).length, 
            correctQuestions
        );
        Feedback.updateCounters(exercise.id, correctQuestions, wrongQuestions);

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
     * @param {Array} questions - Preguntas del ejercicio
     * @param {Object} exercise - Datos del ejercicio
     * @returns {Object} - Resultados procesados
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
                    Feedback.showCorrect(question.id);
                    correctQuestions++;
                } else {
                    Feedback.showWrong(question.id);
                }
            } else {
                responses.push({
                    id: String(question.id),
                    response: ''
                });
                Feedback.showWrong(question.id);
            }
        });

        wrongQuestions = questions.length - correctQuestions;
        Feedback.toggleConditionalMessages(exercise.id, questions.length, correctQuestions);
        Feedback.updateCounters(exercise.id, correctQuestions, wrongQuestions);
        Feedback.setVisibility(false, exercise.id, questions);

        return {
            correct: correctQuestions,
            wrong: wrongQuestions,
            responses: responses
        };
    },

    /**
     * Procesa respuestas de Poll (Likert)
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

        Feedback.toggleConditionalMessages(exercise.id, total, correctQuestions);
        Feedback.updateCounters(exercise.id, answeredCount, wrongQuestions);
        Feedback.setVisibility(false, exercise.id, questions);

        return {
            correct: correctQuestions,
            wrong: wrongQuestions,
            responses: responses
        };
    },

    /**
     * Procesa respuestas de Form
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
                Feedback.showWrong(question.id);
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
                Feedback.showCorrect(question.id);
                correctQuestions++;
            } else {
                Feedback.showWrong(question.id);
            }
        });

        const wrongQuestions = questions.length - correctQuestions;
        Feedback.toggleConditionalMessages(exercise.id, questions.length, correctQuestions);
        Feedback.updateCounters(exercise.id, correctQuestions, wrongQuestions);
        Feedback.setVisibility(false, exercise.id, questions);

        return {
            correct: correctQuestions,
            wrong: wrongQuestions,
            responses: responses
        };
    },

    /**
     * Procesa respuestas de Open Ended
     * @param {Array} questions - Preguntas del ejercicio
     * @param {Object} exercise - Datos del ejercicio
     * @returns {Object} - Resultados procesados
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
                Feedback.showCorrect(question.id);
            }
        });

        const correctQuestions = questionsNumber;
        Feedback.toggleConditionalMessages(exercise.id, questionsNumber, correctQuestions);
        Feedback.setVisibility(false, exercise.id, questions);

        return {
            responses: responses
        };
    }
};

// Exportar
if (typeof module !== 'undefined' && module.exports) {
    module.exports = ExerciseTypes;
}