/**
 * Módulo de tracking de interacciones
 * Maneja el seguimiento de ayuda y feedback
 */
const Tracking = {
    helpOptions: {
        transcript: { count: 0, totalTime: 0 },
        listening_tips: { count: 0, totalTime: 0 },
        cultural_notes: { count: 0, totalTime: 0 },
        glossary: { count: 0, totalTime: 0 },
        translation: { count: 0, totalTime: 0 },
        dictionary: { count: 0, totalTime: 0 }
    },
    
    helpOptionStartTime: null,
    currentExerciseId: null,

    /**
     * Inicializa el tracking para un ejercicio
     * @param {number} exerciseId - ID del ejercicio
     */
    initExercise(exerciseId) {
        this.currentExerciseId = exerciseId;
        this.resetHelpOptions();
        this.resetFeedbackInteractions(exerciseId);
    },

    /**
     * Reinicia los contadores de opciones de ayuda
     */
    resetHelpOptions() {
        Object.keys(this.helpOptions).forEach(key => {
            this.helpOptions[key].count = 0;
            this.helpOptions[key].totalTime = 0;
        });
    },

    /**
     * Registra cuando se abre una opción de ayuda
     * @param {string} type - Tipo de ayuda (transcript, listening_tips, etc.)
     */
    onHelpOptionOpened(type) {
        this.helpOptionStartTime = Utils.getCurrentTime();
    },

    /**
     * Registra cuando se cierra una opción de ayuda
     * @param {string} type - Tipo de ayuda
     */
    onHelpOptionClosed(type) {
        if (!this.helpOptionStartTime) return;

        const timeSpent = Utils.getCurrentTime() - this.helpOptionStartTime;
        const option = this.helpOptions[type];

        if (option) {
            option.count += 1;
            option.totalTime += timeSpent;
        }

        this.helpOptionStartTime = null;
    },

    /**
     * Reinicia los contadores de feedback
     * @param {number} exerciseId - ID del ejercicio
     */
    resetFeedbackInteractions(exerciseId) {
        const items = document.getElementsByClassName(`feedback_interactions_count_${exerciseId}`);
        Array.from(items).forEach(item => {
            item.setAttribute('value', '0');
        });
    },

    /**
     * Agrega los valores de tracking al formulario antes de enviarlo
     * @param {number} exerciseId - ID del ejercicio
     * @param {string} formType - Tipo de formulario
     */
    appendToForm(exerciseId, formType) {
        const form = document.getElementById(`${formType}_form_${exerciseId}`);
        if (!form) return;

        const options = [
            'transcript',
            'listening_tips',
            'cultural_notes',
            'glossary',
            'translation',
            'dictionary'
        ];

        options.forEach(option => {
            const data = this.helpOptions[option];
            const nameMap = {
                'transcript': 'transcript',
                'listening_tips': 'listening_tips',
                'cultural_notes': 'cultural_notes',
                'glossary': 'glossary',
                'translation': 'translation',
                'dictionary': 'dictionary'
            };

            const baseName = nameMap[option];
            
            // Agregar contador
            const countInput = Utils.createElement('input', {
                'name': `${baseName}_count`,
                'value': data.count,
                'hidden': ''
            });
            form.appendChild(countInput);

            // Agregar tiempo total (convertido a formato legible)
            const timeInput = Utils.createElement('input', {
                'name': `${baseName}_total_time`,
                'value': Utils.millisToHms(data.totalTime),
                'hidden': ''
            });
            form.appendChild(timeInput);
        });
    }
};

// Exportar
if (typeof module !== 'undefined' && module.exports) {
    module.exports = Tracking;
}