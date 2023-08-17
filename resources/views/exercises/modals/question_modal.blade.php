@php
    $type = $exercise->exerciseType->underscore_name;
    $type_name = $exercise->exerciseType->name;
    $subtype = $exercise->subtype;
@endphp

<div class="modal fade" id="addQuestionModal" tabindex="-1" aria-labelledby="addQuestionModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addQuestionModal">New {{ $type_name }} Question</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form enctype="multipart/form-data" action="{{ route('questions.store', [$exercise->id, $exercise->section_id, $exercise->exercise_type_id]) }}" method="POST">
                    @csrf
                    @switch($type)
                    @case('multiple_choice')
                        @switch($subtype)
                        @case('1')
                            <p><small>Question settings:</small></p>
                            <input id="statement" name="statement" type="text" class="form-control" placeholder="Statements">
                            <p class="text-secondary"><small>Use a semicolon (;) at the end of each statement. Except the last one.</small></p>
                            <p><small>Alternatives settings:</small></p>
                            <div class="mb-3">
                                <input name="correct_alt" class="form-control" type="text" placeholder="Correct Alternative (only if applicable)">
                                <textarea name="alternatives" class="form-control" rows="3" placeholder="Type alternatives separated by semicolon (;) except for the last one"></textarea>
                            </div>
                            @break
                        @case('2')
                            <p><small>Question settings:</small></p>
                            <input id="statement" name="statement" type="text" class="form-control" placeholder="Statement to complete">
                            <p class="text-secondary"><small>Use double semicolon (;;) to indicate where the gap to fill will be placed.</small></p>
                            <p><small>Alternatives settings:</small></p>
                            <div class="mb-3">
                                <input name="correct_alt" class="form-control mb-1" type="text" placeholder="Correct words">
                                <p class="text-secondary"><small>Use semicolon (;) to separate each correct response</small></p>
                                <textarea name="alternatives" class="form-control" rows="3" placeholder="Type alternatives separated by semicolon (;) except for the last one"></textarea>
                                <div class="row">
                                    <p class="text-secondary col-12"><small>e.g:  Enter the following: <strong>afraid/affordable;reliable/relieved</strong></small></p>
                                    <p class="text-secondary"><small>To get this result:</small></p>
                                    <p class="text-secondary"><small><i>"I’ve just always been so <strong>afraid / affordable</strong> that you would say I wasn’t your real mum, and now you’ve actually said it, I’m almost <strong>reliable / relieved."</strong></i></small></p>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="audio" class="form-label">Select audio file</label>
                                <input class="form-control" type="file" name="audio" id="audio" accept="audio/*">
                            </div>
                            @break
                        @case('3')
                            <p><small>Question settings:</small></p>
                            <input id="statement" name="statement" type="text" class="form-control" placeholder="Statement">
                            <input id="answer" name="answer" type="text" class="form-control" placeholder="Correct Answer">
                            @break
                        @case('4')
                            <p><small>Question settings:</small></p>
                            <input id="statement" name="statement" type="text" class="form-control" placeholder="Statement">
                            <p><small>Alternatives settings:</small></p>
                            <div class="mb-3">
                                <input name="correct_alt" class="form-control" type="text" placeholder="Correct Alternative (only if applicable)">
                                <textarea name="alternatives" class="form-control" rows="3" placeholder="Type alternatives separated by semicolon (;) except for the last one"></textarea>
                            </div>
                            <p class="text-secondary"><small>Use a semicolon (;) at the end of each statement. Except the last one.</small></p>
                            @break
                        @case('99')
                            <p><small>Question settings:</small></p>
                            <input id="statement" name="statement" type="text" class="form-control" placeholder="Statement">
                            <p><small>Alternatives settings:</small></p>
                            <div class="mb-3">
                                <input name="correct_alt" class="form-control" type="text" placeholder="Correct Alternative (only if applicable)">
                                <textarea name="alternatives" class="form-control" rows="3" placeholder="Type alternatives separated by semicolon (;) except for the last one"></textarea>
                            </div>
                            <p class="text-secondary"><small>Use a semicolon (;) at the end of each statement. Except the last one.</small></p>
                            @break
                        @endswitch
                        @break
                    @case('voice_recognition')
                        <input id="statement" name="statement" type="text" class="form-control" placeholder="Item Title">
                        <br>
                        <div class="mb-3">
                            <label for="audio" class="form-label">Select audio file</label>
                            <input class="form-control" type="file" name="audio" id="audio" accept="audio/*">
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">Select image file</label>
                            <input class="form-control" type="file" name="image" id="image" accept="image/*">
                        </div>
                        @break
                    @case('drag_and_drop')
                        <input id="statement" name="statement" type="text" class="form-control" placeholder="Word">
                        <br>
                        <input id="answer" name="answer" type="text" class="form-control" placeholder="Definition">
                        <br>
                        @break
                    @case('fill_in_the_gaps')
                        @switch($subtype)
                        @case('1')
                            <input id="statement" name="statement" type="text" class="form-control" placeholder="Statement to fill">
                            <p class="text-secondary"><small>Use double semicolon (;;) to indicate where the gap to fill will be placed.</small></p>
                            <br>
                            <input id="answer" name="answer" type="text" class="form-control" placeholder="Correct words">
                            <p class="text-secondary"><small>List the correct word for each gap separating them by a single comma.</small></p>
                            <div class="mb-3">
                                <label for="audio" class="form-label">Select audio file</label>
                                <input class="form-control" type="file" name="audio" id="audio" accept="audio/*">
                            </div>
                            @break
                        @case('2')
                            <input id="statement" name="statement" type="text" class="form-control" placeholder="Statement to fill">
                            <p class="text-secondary"><small>Use double semicolon (;;) to indicate where the gap to fill will be placed.</small></p>
                            <br>
                            <input id="answer" name="answer" type="text" class="form-control" placeholder="Matching Word">
                            <br>
                            @break
                        @endswitch
                        @break
                    @case('open_ended')
                        @switch($subtype)
                            @case ('1')
                            @case ('99')
                            @case (null)
                            @case ('')
                                <textarea id="statement" name="statement" type="text" cols="40" class="form-control" placeholder="Question statement"></textarea>
                                <br>
                                @break
                            @case ('991')
                                <div>
                                    <label class="form-label mb-1">Question statement:</label>
                                    <input class="form-control mb-2" name="title" type="text" placeholder="Question statement">
                                    <label class="form-label mb-1">Title for column 1:</label>
                                    <input class="form-control mb-2" name="statement" type="text" placeholder="Column 1 title">
                                    <label class="form-label mb-1">Title for column 2:</label>
                                    <input class="form-control mb-2" name="answer" type="text" placeholder="Column 2 title">
                                    <label class="form-label mb-1">Number of text input spaces for student:</label>
                                    <input class="form-control" type="number" name="boxes_number" min="1" max="20" value="1">
                                </div>
                                <br>
                                @break
                        @endswitch
                        @break
                    @case('form')
                        <div class="row p-2 d-flex justify-content-center" id="col-selection-form">
                            <div class="col-12">
                                <label class="form-label d-flex justify-content-center">
                                    <p class="text-center">How many columns do you want for this activity?</p>
                                </label>
                            </div>
                            <div class="col-4">
                                <input class="form-control" type="number" placeholder="CANTIDAD DE COLUMNAS (1-2)" min="1" max="2" value="1" id="col-number">
                            </div>
                            <div class="col-4">
                                <a class="btn btn-primary" onclick="showSelectedForm()">Show form</a>
                            </div>
                        </div>

                        <div id="single-col-form" class="p-1" hidden>
                            <input class="form-control mb-1" name="title" type="text" placeholder="Activity title">
                            <input class="form-control mb-1" name="statement" type="text" placeholder="Column title">
                            <a class="btn btn-primary btn-sm" onclick="addColumn()">Add question</a>
                        </div>

                        <div id="double-col-form" class="p-1" hidden>
                            <input class="form-control mb-1" name="title" type="text" placeholder="Activity title">
                            <input class="form-control mb-1" name="statement" type="text" placeholder="Column 1 title">
                            <input class="form-control mb-1" name="answer" type="text" placeholder="Column 2 title">
                            <a class="btn btn-primary btn-sm" onclick="addColumn()">Add question</a>
                        </div>

                        <div id="questions-form" class="mt-2 p-1"></div>

                    @endswitch

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary close-modal" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary close-modal">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function showSelectedForm() {
        const columnNumber = document.getElementById('col-number').value;
        const singleColumnContainer = document.getElementById('single-col-form');
        const doubleColumnContainer = document.getElementById('double-col-form');
        const columnSelectionForm = document.getElementById('col-selection-form');

        if (columnNumber == 1) {
            singleColumnContainer.hidden = false;
            doubleColumnContainer.remove();
            columnSelectionForm.remove();
        } else if (columnNumber == 2) {
            doubleColumnContainer.hidden = false;
            singleColumnContainer.remove();
            columnSelectionForm.remove();
        }
    }

    function addColumn() {
        const questionsContainer = document.getElementById('questions-form');

        var number = document.createElement('p');
        number.setAttribute('class', "text-center mt-1");
        number.innerHTML = `${numberOfQuestions() + 1}.`;
        var numContainer = document.createElement('div');
        numContainer.setAttribute('class', "col-1 text-center d-flex justify-content-center align-items-center");
        numContainer.appendChild(number);

        var input = document.createElement('input');
        input.setAttribute('type', "text");
        input.setAttribute('class', "form-control");
        input.setAttribute('placeholder', "Statement");
        input.setAttribute('name', "alternatives[]");
        var inputContainer = document.createElement('div');
        inputContainer.setAttribute('class', "col-9");
        inputContainer.appendChild(input);

        var deleteIcon = document.createElement('i');
        deleteIcon.setAttribute('class', 'mdi mdi-delete');
        var deleteButton = document.createElement('a');
        deleteButton.setAttribute('class', "btn btn-danger");
        deleteButton.setAttribute('onclick', `deleteFormQuestion('form-question-${numberOfQuestions() + 1}')`);
        deleteButton.appendChild(deleteIcon);
        var deleteContainer = document.createElement('div');
        deleteContainer.setAttribute('class', "col-2");
        deleteContainer.appendChild(deleteButton);

        var container = document.createElement('div');
        container.setAttribute('class', "row form-question-title");
        container.setAttribute('id', `form-question-${numberOfQuestions() + 1}`);
        container.appendChild(numContainer);
        container.appendChild(inputContainer);
        container.appendChild(deleteContainer);

        questionsContainer.appendChild(container);
    }

    function numberOfQuestions() { return document.getElementsByClassName('form-question-title').length; }
    function deleteFormQuestion(id) { document.getElementById(id).remove(); }
</script>