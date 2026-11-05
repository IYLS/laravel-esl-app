<div class="modal fade" id="exportTimelineModal" tabindex="-1" aria-labelledby="exportTimelineModalLabel" aria-hidden="true" data-bs-focus="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exportTimelineModalLabel">Exportar Interacciones</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('tracking.export_timeline') }}" method="POST" id="export_timeline_form">
                    @csrf
                    <input type="hidden" name="download_token" id="export_timeline_download_token">
                    <div class="mb-3">
                        <label for="export_timeline_select_group" class="form-label">Grupo</label>
                        <select name="group" class="form-select form-select-sm" id="export_timeline_select_group" required>
                            <option value="" selected disabled>Seleccione un grupo</option>
                            @foreach($groups as $group)
                                <option value="{{ $group->id }}">{{ $group->name }}</option>
                            @endforeach
                        </select>
                        <small class="text-muted">
                            Genera un Excel con una fila por estudiante e intento, con sus respuestas y aperturas de
                            feedback en los ejercicios Checking understanding y Dictation cloze.
                        </small>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" id="export_timeline_btn" disabled>Generar archivo</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Reutiliza la pantalla de carga (#export_loading_overlay) de export_data.blade.php.
    (function () {
        const form = document.getElementById("export_timeline_form");
        const select = document.getElementById("export_timeline_select_group");
        const button = document.getElementById("export_timeline_btn");
        const tokenInput = document.getElementById("export_timeline_download_token");
        const overlay = document.getElementById("export_loading_overlay");
        const TIMEOUT_MS = 6 * 60 * 1000;
        let timer = null;

        function readTokenCookie() {
            const match = document.cookie.match(/(?:^|;\s*)export_download_token=([^;]*)/);
            return match ? decodeURIComponent(match[1]) : null;
        }

        function clearTokenCookie() {
            document.cookie = "export_download_token=; Max-Age=0; path=/";
        }

        function hideLoading() {
            clearInterval(timer);
            timer = null;
            if (overlay) {
                overlay.classList.add("d-none");
            }
            button.disabled = select.value === "";
        }

        select.addEventListener("change", function () {
            button.disabled = select.value === "";
        });

        form.addEventListener("submit", function () {
            const token = Date.now().toString(36) + Math.random().toString(36).slice(2);
            const startedAt = Date.now();

            tokenInput.value = token;
            clearTokenCookie();

            bootstrap.Modal.getOrCreateInstance(document.getElementById("exportTimelineModal")).hide();
            button.disabled = true;
            if (overlay) {
                overlay.classList.remove("d-none");
            }

            timer = setInterval(function () {
                if (readTokenCookie() === token) {
                    clearTokenCookie();
                    hideLoading();
                } else if (Date.now() - startedAt > TIMEOUT_MS) {
                    hideLoading();
                    alert("La exportación está tardando más de lo esperado. Intente nuevamente.");
                }
            }, 1000);
        });

        window.addEventListener("pageshow", function (event) {
            if (event.persisted) {
                hideLoading();
            }
        });
    })();
</script>
