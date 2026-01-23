/**
 * Módulo de manejo de eventos de video
 * Detecta problemas de buffering, errores de carga y proporciona información útil
 */
const VideoHandler = {
    /**
     * Inicializa el manejo de eventos para todos los videos en la página
     */
    init() {
        const videos = document.querySelectorAll('video');
        
        videos.forEach((video, index) => {
            // Asignar ID único si no tiene uno
            if (!video.id) {
                video.id = `video-${index}-${Date.now()}`;
            }
            
            this.setupVideoEvents(video);
        });
    },

    /**
     * Configura eventos para un video específico
     * @param {HTMLVideoElement} video - Elemento de video
     */
    setupVideoEvents(video) {
        const videoId = video.id;
        let bufferingCount = 0;
        let lastBufferingTime = null;
        let bufferingStartTime = null;
        let errorCount = 0;
        let lastErrorTime = null;

        // Crear contenedor para mensajes de estado
        const statusContainer = this.createStatusContainer(videoId);
        video.parentElement.appendChild(statusContainer);

        // Evento: Esperando datos (buffering)
        video.addEventListener('waiting', () => {
            bufferingCount++;
            bufferingStartTime = Date.now();
            lastBufferingTime = Date.now();
            
            this.showBufferingStatus(videoId, statusContainer, bufferingCount);
            this.logVideoEvent(video, 'waiting', {
                bufferingCount,
                currentTime: video.currentTime,
                readyState: video.readyState,
                networkState: video.networkState
            });
        });

        // Evento: Buffering completado
        video.addEventListener('canplay', () => {
            if (bufferingStartTime) {
                const bufferingDuration = Date.now() - bufferingStartTime;
                this.hideBufferingStatus(videoId, statusContainer);
                this.logVideoEvent(video, 'canplay', {
                    bufferingDuration,
                    bufferingCount
                });
                bufferingStartTime = null;
            }
        });

        // Evento: Puede reproducir sin interrupciones
        video.addEventListener('canplaythrough', () => {
            this.hideBufferingStatus(videoId, statusContainer);
            this.logVideoEvent(video, 'canplaythrough', {
                duration: video.duration,
                buffered: this.getBufferedRanges(video)
            });
        });

        // Evento: Descarga estancada
        video.addEventListener('stalled', () => {
            this.showBufferingStatus(videoId, statusContainer, bufferingCount, true);
            this.logVideoEvent(video, 'stalled', {
                currentTime: video.currentTime,
                readyState: video.readyState,
                networkState: video.networkState,
                buffered: this.getBufferedRanges(video)
            });
        });

        // Evento: Progreso de descarga
        video.addEventListener('progress', () => {
            const buffered = this.getBufferedRanges(video);
            const bufferedPercent = this.calculateBufferedPercent(video);
            
            // Si hay buffering activo, actualizar información
            if (bufferingStartTime) {
                this.updateBufferingStatus(videoId, statusContainer, bufferedPercent);
            }
        });

        // Evento: Error de carga
        video.addEventListener('error', (e) => {
            errorCount++;
            lastErrorTime = Date.now();
            
            const errorInfo = this.getVideoErrorInfo(video);
            this.showErrorStatus(videoId, statusContainer, errorInfo);
            this.logVideoEvent(video, 'error', {
                error: errorInfo,
                errorCount,
                currentTime: video.currentTime,
                readyState: video.readyState,
                networkState: video.networkState
            });
        });

        // Evento: Tiempo de carga agotado
        video.addEventListener('loadstart', () => {
            this.logVideoEvent(video, 'loadstart', {
                src: video.currentSrc || video.src
            });
        });

        // Evento: Metadatos cargados
        video.addEventListener('loadedmetadata', () => {
            this.logVideoEvent(video, 'loadedmetadata', {
                duration: video.duration,
                videoWidth: video.videoWidth,
                videoHeight: video.videoHeight
            });
        });

        // Evento: Datos cargados
        video.addEventListener('loadeddata', () => {
            this.logVideoEvent(video, 'loadeddata', {
                currentTime: video.currentTime,
                readyState: video.readyState
            });
        });

        // Monitoreo periódico del estado de red
        setInterval(() => {
            if (video.readyState < 3 && video.networkState === 2) {
                // Red lenta o problema de conexión
                this.logVideoEvent(video, 'network_slow', {
                    readyState: video.readyState,
                    networkState: video.networkState,
                    buffered: this.getBufferedRanges(video)
                });
            }
        }, 5000);
    },

    /**
     * Crea un contenedor para mostrar el estado del video
     * @param {string} videoId - ID del video
     * @returns {HTMLElement} Contenedor de estado
     */
    createStatusContainer(videoId) {
        const container = document.createElement('div');
        container.id = `video-status-${videoId}`;
        container.className = 'video-status-container mt-2';
        container.style.display = 'none';
        return container;
    },

    /**
     * Muestra el estado de buffering
     * @param {string} videoId - ID del video
     * @param {HTMLElement} container - Contenedor de estado
     * @param {number} count - Número de veces que ha ocurrido buffering
     * @param {boolean} isStalled - Si está estancado
     */
    showBufferingStatus(videoId, container, count, isStalled = false) {
        container.innerHTML = `
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>${isStalled ? '⚠️ Conexión lenta detectada' : '⏳ Cargando video...'}</strong>
                <p class="mb-0 small">
                    ${isStalled 
                        ? 'El video se ha detenido por problemas de conexión. Por favor, verifica tu conexión a internet.'
                        : 'El video está cargando. Esto puede deberse a una conexión lenta.'}
                    ${count > 1 ? `<br><small>Buffering detectado ${count} veces.</small>` : ''}
                </p>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        `;
        container.style.display = 'block';
    },

    /**
     * Actualiza el estado de buffering con información de progreso
     * @param {string} videoId - ID del video
     * @param {HTMLElement} container - Contenedor de estado
     * @param {number} bufferedPercent - Porcentaje de video cargado
     */
    updateBufferingStatus(videoId, container, bufferedPercent) {
        const alert = container.querySelector('.alert');
        if (alert) {
            const small = alert.querySelector('small');
            if (small) {
                small.textContent = `Buffering... ${Math.round(bufferedPercent)}% cargado`;
            }
        }
    },

    /**
     * Oculta el estado de buffering
     * @param {string} videoId - ID del video
     * @param {HTMLElement} container - Contenedor de estado
     */
    hideBufferingStatus(videoId, container) {
        container.style.display = 'none';
        container.innerHTML = '';
    },

    /**
     * Muestra el estado de error
     * @param {string} videoId - ID del video
     * @param {HTMLElement} container - Contenedor de estado
     * @param {Object} errorInfo - Información del error
     */
    showErrorStatus(videoId, container, errorInfo) {
        container.innerHTML = `
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>❌ Error al cargar el video</strong>
                <p class="mb-0 small">
                    ${errorInfo.message}
                    ${errorInfo.suggestion ? `<br><strong>Sugerencia:</strong> ${errorInfo.suggestion}` : ''}
                </p>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        `;
        container.style.display = 'block';
    },

    /**
     * Obtiene información detallada del error del video
     * @param {HTMLVideoElement} video - Elemento de video
     * @returns {Object} Información del error
     */
    getVideoErrorInfo(video) {
        const error = video.error;
        let message = 'No se pudo cargar el video.';
        let suggestion = '';

        if (error) {
            switch (error.code) {
                case error.MEDIA_ERR_ABORTED:
                    message = 'La carga del video fue cancelada.';
                    suggestion = 'Intenta recargar la página o verifica tu conexión a internet.';
                    break;
                case error.MEDIA_ERR_NETWORK:
                    message = 'Error de red al intentar cargar el video.';
                    suggestion = 'Verifica tu conexión a internet y vuelve a intentar.';
                    break;
                case error.MEDIA_ERR_DECODE:
                    message = 'Error al decodificar el video.';
                    suggestion = 'El archivo de video puede estar corrupto o en un formato no compatible.';
                    break;
                case error.MEDIA_ERR_SRC_NOT_SUPPORTED:
                    message = 'El formato de video no es compatible.';
                    suggestion = 'Contacta al administrador para verificar el formato del video.';
                    break;
                default:
                    message = 'Error desconocido al cargar el video.';
                    suggestion = 'Intenta recargar la página. Si el problema persiste, contacta al administrador.';
            }
        }

        return { message, suggestion };
    },

    /**
     * Obtiene los rangos de video que están en buffer
     * @param {HTMLVideoElement} video - Elemento de video
     * @returns {Array} Array de objetos con start y end de los rangos en buffer
     */
    getBufferedRanges(video) {
        const buffered = [];
        if (video.buffered && video.buffered.length > 0) {
            for (let i = 0; i < video.buffered.length; i++) {
                buffered.push({
                    start: video.buffered.start(i),
                    end: video.buffered.end(i)
                });
            }
        }
        return buffered;
    },

    /**
     * Calcula el porcentaje del video que está en buffer
     * @param {HTMLVideoElement} video - Elemento de video
     * @returns {number} Porcentaje (0-100)
     */
    calculateBufferedPercent(video) {
        if (!video.duration || video.duration === 0) return 0;
        
        let bufferedEnd = 0;
        if (video.buffered && video.buffered.length > 0) {
            bufferedEnd = video.buffered.end(video.buffered.length - 1);
        }
        
        return (bufferedEnd / video.duration) * 100;
    },

    /**
     * Registra eventos de video para debugging local
     * @param {HTMLVideoElement} video - Elemento de video
     * @param {string} eventType - Tipo de evento
     * @param {Object} data - Datos adicionales
     */
    logVideoEvent(video, eventType, data) {
        const logData = {
            timestamp: new Date().toISOString(),
            videoId: video.id,
            videoSrc: video.currentSrc || video.src,
            eventType,
            ...data
        };

        // Log en consola para debugging local
        console.log(`[VideoHandler] ${eventType}:`, logData);
        
        // Log detallado para eventos críticos
        if (eventType === 'error' || eventType === 'stalled' || eventType === 'network_slow') {
            console.warn(`[VideoHandler] Problema detectado en video ${video.id}:`, {
                evento: eventType,
                mensaje: eventType === 'error' ? this.getVideoErrorInfo(video).message : 'Problema de conexión o buffering',
                detalles: logData
            });
        }
    }
};

// Exportar
if (typeof module !== 'undefined' && module.exports) {
    module.exports = VideoHandler;
}
