<div class="modal fade" id="selectGroupForDataExportModal" tabindex="-1" aria-labelledby="selectGroupForDataExportModal" aria-hidden="true" data-bs-focus="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="selectGroupForDataExportModal">Exportar Datos de Tracking</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('tracking.export_data') }}" method="POST" id="export_data_form" onchange="validateExportForm();">
                    @csrf
                    @method('POST')
                    <input type="hidden" name="download_token" id="export_download_token">
                    <div class="mb-3">
                        <label for="export_data_modal_select_group" class="form-label">Grupo</label>
                        <select name="group" class="form-select form-select-sm" id="export_data_modal_select_group" onchange="groupsSelectChanged()">
                            <option value="">Seleccione un grupo (opcional)</option>
                            @foreach($groups as $group)
                                <option value="{{ $group->id }}">{{ $group->name }}</option>
                            @endforeach
                        </select>
                        <small class="text-muted">Seleccione un grupo para exportar todos sus estudiantes, o deje vacío y seleccione un estudiante específico</small>
                    </div>
                    <div class="mb-3">
                        <label for="export_data_modal_select_student" class="form-label">Estudiante</label>
                        <select name="student" class="form-select form-select-sm" id="export_data_modal_select_student" onchange="validateExportForm()">
                            <option value="">Seleccione un estudiante (opcional)</option>
                        </select>
                        <small class="text-muted">Seleccione un estudiante específico para exportar solo sus datos</small>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" id="generate_file_btn" disabled>Generar archivo</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div id="export_loading_overlay" class="export-loading-overlay d-none" role="status" aria-live="polite">
    <div class="export-loading-box">
        <div class="spinner-border text-primary mb-3" style="width: 3rem; height: 3rem;" aria-hidden="true"></div>
        <h5 class="mb-1">Generando archivo…</h5>
        <p class="text-muted mb-0">Con grupos grandes puede tardar unos minutos. No cierre esta página.</p>
    </div>
</div>

<style>
    .export-loading-overlay {
        position: fixed;
        inset: 0;
        z-index: 2000;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 16px;
        background: rgba(0, 0, 0, 0.45);
    }
    .export-loading-overlay.d-none {
        display: none !important;
    }
    .export-loading-box {
        max-width: 360px;
        padding: 2rem 1.5rem;
        border-radius: 0.5rem;
        background: #fff;
        text-align: center;
        box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.2);
    }
</style>

<script>
    const exportDataModalSelectGroup = document.getElementById("export_data_modal_select_group");
    const exportDataModalSelectStudent = document.getElementById("export_data_modal_select_student");
    const submitButton = document.getElementById("generate_file_btn");

    function getSelectedGroupId() {
        return exportDataModalSelectGroup.value;
    }

    function validateExportForm() {
        // Permitir exportar si se seleccionó un grupo O un estudiante
        const hasGroup = exportDataModalSelectGroup.value !== "";
        const hasStudent = exportDataModalSelectStudent.value !== "";
        
        if (hasGroup || hasStudent) {
            submitButton.classList.remove("btn-disabled");
            submitButton.classList.add("btn-primary");
            submitButton.disabled = false;
        } else {
            submitButton.classList.add("btn-disabled");
            submitButton.classList.remove("btn-primary");
            submitButton.disabled = true;
        }
    }

    function groupsSelectChanged() {
        var selectedGroupId = exportDataModalSelectGroup.value;
        const studentsList = @json($students);

        // Limpiar opciones de estudiantes
        var length = exportDataModalSelectStudent.options.length;
        for (i = length-1; i >= 0; i--) {
            exportDataModalSelectStudent.options[i] = null;
        }

        // Agregar opción base
        var baseItem = document.createElement('option');
        baseItem.value = "";
        baseItem.innerHTML = "Seleccione un estudiante (opcional)";
        exportDataModalSelectStudent.appendChild(baseItem);

        // Si hay un grupo seleccionado, agregar sus estudiantes
        if (selectedGroupId !== "") {
            studentsList.forEach(function(student) {
                if (student.group_id == selectedGroupId) {
                    var newOption = document.createElement('option');
                    newOption.value = student.id;
                    newOption.innerHTML = student.name;
                    exportDataModalSelectStudent.appendChild(newOption);
                }
            });
        } else {
            // Si no hay grupo seleccionado, mostrar todos los estudiantes
            studentsList.forEach(function(student) {
                var newOption = document.createElement('option');
                newOption.value = student.id;
                newOption.innerHTML = student.name;
                exportDataModalSelectStudent.appendChild(newOption);
            });
        }

        // Validar formulario después de cambiar el grupo
        validateExportForm();
    }

    // Pantalla de carga del export. La descarga no cambia de página, así que el
    // servidor devuelve el token del formulario en la cookie export_download_token
    // y aquí se espera a verla para cerrar la pantalla.
    const exportLoadingOverlay = document.getElementById("export_loading_overlay");
    const exportDownloadTokenInput = document.getElementById("export_download_token");
    // Algo más que el set_time_limit(300) del controlador.
    const EXPORT_LOADING_TIMEOUT_MS = 6 * 60 * 1000;
    let exportLoadingTimer = null;

    function readExportTokenCookie() {
        const match = document.cookie.match(/(?:^|;\s*)export_download_token=([^;]*)/);
        return match ? decodeURIComponent(match[1]) : null;
    }

    function clearExportTokenCookie() {
        document.cookie = "export_download_token=; Max-Age=0; path=/";
    }

    function hideExportLoading() {
        clearInterval(exportLoadingTimer);
        exportLoadingTimer = null;
        exportLoadingOverlay.classList.add("d-none");
        validateExportForm();
    }

    document.getElementById("export_data_form").addEventListener("submit", function () {
        const token = Date.now().toString(36) + Math.random().toString(36).slice(2);
        const startedAt = Date.now();

        exportDownloadTokenInput.value = token;
        clearExportTokenCookie();

        bootstrap.Modal.getOrCreateInstance(document.getElementById("selectGroupForDataExportModal")).hide();
        submitButton.disabled = true;
        exportLoadingOverlay.classList.remove("d-none");

        exportLoadingTimer = setInterval(function () {
            if (readExportTokenCookie() === token) {
                clearExportTokenCookie();
                hideExportLoading();
            } else if (Date.now() - startedAt > EXPORT_LOADING_TIMEOUT_MS) {
                hideExportLoading();
                alert("La exportación está tardando más de lo esperado. Intente nuevamente o exporte un estudiante a la vez.");
            }
        }, 1000);
    });

    // Al volver con el botón "atrás" el navegador puede restaurar la página con la pantalla visible.
    window.addEventListener("pageshow", function (event) {
        if (event.persisted) {
            hideExportLoading();
        }
    });

</script>