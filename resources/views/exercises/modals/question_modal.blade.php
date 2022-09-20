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
                <form @if($type == "voice_recognition") enctype="multipart/form-data" @endif action="{{ route('questions.store', [$exercise->id, $exercise->section_id, $exercise->exercise_type_id]) }}" method="POST">
                    @csrf

                    @switch($type)
                    @case('multiple_choice')
                        @switch($subtype)
                        @case(1)
                            <p><small>Question settings:</small></p>
                            <input id="statement" name="statement" type="text" class="form-control" placeholder="Statements">
                            <p class="text-secondary"><small>Use a semicolon (;) at the end of each statement. Except the last one.</small></p>
                            <p><small>Alternatives settings:</small></p>
                            <div class="mb-3">
                                <input name="correct_alt" class="form-control" type="text" placeholder="Correct Alternative">
                                <textarea name="alternatives" class="form-control" rows="3" placeholder="Type alternatives separated by semicolon (;) except for the last one"></textarea>
                            </div>
                            @break
                        @case(2)
                            <p><small>Question settings:</small></p>
                            <input id="statement" name="statement" type="text" class="form-control" placeholder="Statement to complete">
                            <p class="text-secondary"><small>Use double semicolon (;;) to indicate where the gap to fill will be placed.</small></p>
                            <p><small>Alternatives settings:</small></p>
                            <div class="mb-3">
                                <input name="correct_alt" class="form-control" type="text" placeholder="Correct Alternative">
                                <textarea name="alternatives" class="form-control" rows="3" placeholder="Type alternatives separated by semicolon (;) except for the last one"></textarea>
                            </div>
                            @break
                        @case(3)
                            <p><small>Question settings:</small></p>
                            <input id="statement" name="statement" type="text" class="form-control" placeholder="Statement">
                            <input id="answer" name="answer" type="text" class="form-control" placeholder="Correct Answer">
                            @break
                        @case(4)
                            <p><small>Question settings:</small></p>
                            <input id="statement" name="statement" type="text" class="form-control" placeholder="Statement">
                            <p><small>Alternatives settings:</small></p>
                            <div class="mb-3">
                                <input name="correct_alt" class="form-control" type="text" placeholder="Correct Alternative">
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
                        @case(1)
                            <input id="statement" name="statement" type="text" class="form-control" placeholder="Statement to fill">
                            <br>
                            <input id="answer" name="answer" type="text" class="form-control" placeholder="Matching Word">
                            <p class="text-secondary"><small>Use double semicolon (;;) to indicate where the gap to fill will be placed.</small></p>
                            <div class="mb-3">
                                <label for="audio" class="form-label">Select audio file</label>
                                <input class="form-control" type="file" name="audio" id="audio" accept="audio/*">
                            </div>
                            @break
                        @case(2)
                            <input id="statement" name="statement" type="text" class="form-control" placeholder="Statement to fill">
                            <p class="text-secondary"><small>Use double semicolon (;;) to indicate where the gap to fill will be placed.</small></p>
                            <br>
                            <input id="answer" name="answer" type="text" class="form-control" placeholder="Matching Word">
                            <br>
                            @break
                        @endswitch
                        @break
                    @case('open_ended')
                        <textarea id="statement" name="statement" type="text" cols="40" class="form-control" placeholder="Question statement"></textarea>
                        <br>
                        @break
                    @endswitch

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>