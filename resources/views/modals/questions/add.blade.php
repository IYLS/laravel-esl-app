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
                        @case('2')
                            <p><small>Question settings:</small></p>
                            <textarea id="statement" class="mce-editor" name="statement" type="text" placeholder="Statement"></textarea>
                            <p><small>Alternatives settings:</small></p>
                            <button type="button" class="btn btn-primary btn-sm mb-2" onclick="addAlternative('new')">Add alternative</button>
                            <div class="mb-2" id="question-new-alternatives"></div>
                            <div class="mb-3">
                                <label for="audio" class="form-label">Select audio file</label>
                                <input class="form-control" type="file" name="audio" id="audio" accept="audio/*">
                            </div>
                            @break
                        @case('1')
                        @case('3')
                        @case('4')
                        @case('99')
                            <p><small>Question settings:</small></p>
                            <textarea id="statement" class="mce-editor" name="statement" type="text" placeholder="Statement"></textarea>
                            <p><small>Alternatives settings:</small></p>
                            <button type="button" class="btn btn-primary btn-sm mb-2" onclick="addAlternative('new')">Add alternative</button>
                            <div class="mb-2" id="question-new-alternatives"></div>
                            @break
                        @endswitch
                        <div>
                            <input type="checkbox" value="true" name="personal_response" id="personal_response_check_{{ $exercise->id }}" class="form-check-input">
                            <label class="form-check-label" for="personal_response_check_{{ $exercise->id }}">Is personal response</label>
                            <p class="text-secondary"><small>Check this if this question does not have a correct answer.</small></p>
                        </div>
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
                            <textarea id="statement" name="statement" class="mce-editor" placeholder="Statement to fill"></textarea>
                            <p class="text-secondary"><small>Use double semicolon (;;) to indicate where the gap to fill will be placed.</small></p>
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
                                <textarea id="statement" name="statement" class="mce-editor" placeholder="Question statement"></textarea>
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
                        @php  $id = count($exercise->questions); @endphp
                        <div id="double-col-form" class="p-1">
                            <input class="form-control mb-1" name="title" type="text" placeholder="Activity title">
                            <input class="form-control mb-1" name="heading" type="text" placeholder="Heading title">
                            <input class="form-control mb-1" name="statement" type="text" placeholder="Column 1 title">
                            <input class="form-control mb-1" name="answer" type="text" placeholder="(Optional) Column 2 title">
                            <p class="text-secondary mb-1"><small>If you only need a single column leave this field empty.</small></p>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" value="true" id="exclusive_response_check_{{ $exercise->id }}">
                                <label class="form-check-label" for="exclusive_response_check_{{ $exercise->id }}">Exclusive responses</label>
                            </div>
                            <button type="button" class="btn btn-primary btn-sm" onclick="addColumn({{ json_encode($id) }})">Add question</button>

                            <div id="questions-form-{{ $id }}" class="mt-2 p-1"></div>
                        </div>
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