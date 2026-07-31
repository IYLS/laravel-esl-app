<div class="modal fade" id="selectGroupForDataExportModal" tabindex="-1" aria-labelledby="selectGroupForDataExportModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="selectGroupForDataExportModal">Select Group for Data Export</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('tracking.export_data') }}" method="POST" onchange="validateSelectedStudent();">
                    @csrf
                    @method('POST')
                    <div class="ms-2 me-2 row">
                        <select name="group" class="form-select form-select-sm" id="export_data_modal_select_group" onchange="groupsSelectChanged()">
                            <option value="">Seleccione un grupo</option>
                            @foreach($groups as $group)
                                <option value="{{ $group->id }}">{{ $group->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="ms-2 me-2 mt-2 row">
                        <select name="student" class="form-select form-select-sm" id="export_data_modal_select_student">
                            <option value="">Seleccione un estudiante</option>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-disabled" id="generate_file_btn">Generate file</button>
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

    function validateSelectedStudent() {
        if (exportDataModalSelectGroup.value === "" || exportDataModalSelectStudent.value === "") {
            if (!submitButton.classList.contains("btn-disabled")) {
                submitButton.classList.add("btn-disabled");
            }
            submitButton.classList.remove("btn-primary");
            submitButton.disabled = true;
        } else {
            submitButton.classList.remove("btn-disabled");
            submitButton.classList.add("btn-primary");
            submitButton.disabled = false;
        }
    }

    function groupsSelectChanged() {
        var selectedGroupId = exportDataModalSelectGroup.value;
        const studentsList = @json($students);


        var length = exportDataModalSelectStudent.options.length;
        for (i = length-1; i >= 0; i--) {
            exportDataModalSelectStudent.options[i] = null;
        }

        var baseItem = document.createElement('option');
        baseItem.value = "";
        baseItem.innerHTML = "Seleccione un estudiante";
        exportDataModalSelectStudent.appendChild(baseItem);

        studentsList.forEach(function(student) {
            if (student.group_id == selectedGroupId) {
                var newOption = document.createElement('option');
                newOption.value = student.id;
                newOption.innerHTML = student.name;
                exportDataModalSelectStudent.appendChild(newOption);
            }
        });
    }

</script>