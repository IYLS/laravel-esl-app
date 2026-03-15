<div class="modal fade" id="selectGroupForDataExportModal" tabindex="-1" aria-labelledby="selectGroupForDataExportModal" aria-hidden="true" data-bs-focus="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="selectGroupForDataExportModal">Exportar Datos de Tracking</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('tracking.export_data') }}" method="POST" onchange="validateExportForm();">
                    @csrf
                    @method('POST')
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

</script>