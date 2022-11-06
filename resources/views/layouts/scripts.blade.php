@if(Session::get('success'))
@include('modals.exercises.message', ['message' => Session::get('success'), 'type' => 'success'])
<script>
    setTimeout(function(){
        $('#alert-modal').modal('hide')
    }, 1500);

    $(function() {
        $("#alert-modal").modal("show");
    });
</script>
@elseif(Session::get('error'))
@include('modals.exercises.message', ['message' => Session::get('error'), 'type' => 'error'])
<script>
    setTimeout(function(){
        $('#alert-modal').modal('hide')
    }, 1500);

    $(function() {
        $("#alert-modal").modal("show");
    });
</script>
@endif

<!-- Lottie -->
<script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>

<!-- Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>

<script>
    var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
    var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
        return new bootstrap.Popover(popoverTriggerEl)
    })
</script>

<script>
    function addColumn(id) {
        const questionsContainer = document.getElementById(`questions-form-${id}`);

        var input = document.createElement('input');
        input.setAttribute('type', "text");
        input.setAttribute('class', "form-control");
        input.setAttribute('placeholder', "Question statement");
        input.setAttribute('name', "alternatives[]");
        var inputContainer = document.createElement('div');
        inputContainer.setAttribute('class', "col-10");
        inputContainer.appendChild(input);

        var deleteIcon = document.createElement('i');
        deleteIcon.setAttribute('class', 'mdi mdi-delete');
        var deleteButton = document.createElement('a');
        deleteButton.setAttribute('class', "btn btn-danger");
        deleteButton.setAttribute('onclick', `deleteFormQuestion('form-question-${numberOfQuestions()}')`);
        deleteButton.appendChild(deleteIcon);
        var deleteContainer = document.createElement('div');
        deleteContainer.setAttribute('class', "col-2");
        deleteContainer.appendChild(deleteButton);

        var container = document.createElement('div');
        container.setAttribute('class', "row form-question-title mb-1");
        container.setAttribute('id', `form-question-${numberOfQuestions()}`);
        container.appendChild(inputContainer);
        container.appendChild(deleteContainer);

        questionsContainer.appendChild(container);
    }

    function numberOfQuestions() { return document.getElementsByClassName('form-question-title').length + 1; }
    function deleteFormQuestion(id) { document.getElementById(id).remove(); }
    
    function addAlternative(id) {
        const alternativesContainer = document.getElementById(`question-${id}-alternatives`);

        var inputContainer = document.createElement('div');
        inputContainer.setAttribute('class', "col-9");
        inputContainer.innerHTML = "<input type='text' class='form-control' placeholder='Alternative title' name='alternatives[]'>";

        var checkContainer = document.createElement('div');
        checkContainer.setAttribute('class', "col-1 form-check");
        checkContainer.innerHTML = `<input class='form-check-input' value='${numberOfAlternatives(id)}' type='radio' name='correct_answer'>`;

        var deleteContainer = document.createElement('div');
        deleteContainer.setAttribute('class', "col-1");
        deleteContainer.innerHTML = `<button type='button' class='btn btn-danger btn-sm' onclick='removeAlternative("${id}", ${numberOfAlternatives(id)})'><i class='mdi mdi-delete'></i></button>`;

        var container = document.createElement('div');
        container.setAttribute('class', `row ms-1 me-1 question-${id}-alternative mb-1 d-flex justify-content-center align-items-center`);
        container.setAttribute('id', `question-${id}-alternative-${numberOfAlternatives(id)}`);
        container.appendChild(checkContainer);
        container.appendChild(inputContainer);
        container.appendChild(deleteContainer);

        alternativesContainer.appendChild(container);
    }

    function numberOfAlternatives(id) { return document.getElementsByClassName(`question-${id}-alternative`).length; }
    function removeAlternative(id, index) { document.getElementById(`question-${id}-alternative-${index}`).remove(); }
</script>