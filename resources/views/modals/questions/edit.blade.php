@php
    $type = $exercise->exerciseType->underscore_name;
    $type_name = $exercise->exerciseType->name;
    $subtype = $exercise->subtype;
@endphp

<div class="modal fade" id="{{ $button_target_id }}" tabindex="-1" aria-labelledby="{{ $button_target_id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="update_question_modal_{{ $question->id }}">Edit {{ $type_name }} Question</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form enctype="multipart/form-data" action="{{ route('questions.update', $question->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    @switch($type)
                    @case('multiple_choice')
                        @switch($subtype)
                        @case('2')
                            <p><small>Question settings:</small></p>
                            <textarea id="statement" class="mce-editor" name="statement" type="text">{!! $question->statement !!}</textarea>
                            <p><small>Alternatives settings:</small></p>
                            <button type="button" class="btn btn-primary btn-sm mb-2" onclick="addAlternative({{ json_encode($question->id) }})">Add alternative</button>
                            <div class="mb-2" id="question-{{ $question->id }}-alternatives">
                                @forelse($question->alternatives as $alt)
                                    <div id="question-{{ $question->id }}-alternative-{{ $loop->index }}" class="row ms-1 me-1 question-{{ $question->id }}-alternative mb-1 d-flex justify-content-center align-items-center">
                                        <div class="col-1 form-check">
                                            <input class='form-check-input' type='radio' value="{{ $loop->index }}" name='correct_answer' @if($alt->correct_alt == true) checked @endif>
                                        </div>
                                        <div class="col-9">
                                            <input type='text' class='form-control' placeholder='Alternative title' name='alternatives[]' value="{{ $alt->title }}">
                                        </div>
                                        <div class="col-1">
                                            <button class="btn btn-sm btn-danger" type="button" onclick="removeAlternative({{ json_encode($question->id) }}, {{ json_encode($loop->index) }})">
                                                <i class="mdi mdi-delete"></i>
                                            </button>
                                        </div>
                                    </div>
                                @empty
                                @endforelse
                            </div>
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
                            <textarea id="statement" class="mce-editor" name="statement" type="text">{!! $question->statement !!}</textarea>
                            <p><small>Alternatives settings:</small></p>
                            <button type="button" class="btn btn-primary btn-sm mb-2" onclick="addAlternative({{ json_encode($question->id) }})">Add alternative</button>
                            <div class="mb-2" id="question-{{ $question->id }}-alternatives">
                                @forelse($question->alternatives as $alt)
                                    <div id="question-{{ $question->id }}-alternative-{{ $loop->index }}" class="row ms-1 me-1 question-{{ $question->id }}-alternative mb-1 d-flex justify-content-center align-items-center">
                                        <div class="col-1 form-check">
                                            <input class='form-check-input' type='radio' value="{{ $loop->index }}" name='correct_answer' @if($alt->correct_alt == true) checked @endif>
                                        </div>
                                        <div class="col-9">
                                            <input type='text' class='form-control' placeholder='Alternative title' name='alternatives[]' value="{{ $alt->title }}">
                                        </div>
                                        <div class="col-1">
                                            <button class="btn btn-sm btn-danger" type="button" onclick="removeAlternative({{ json_encode($question->id) }}, {{ json_encode($loop->index) }})">
                                                <i class="mdi mdi-delete"></i>
                                            </button>
                                        </div>
                                    </div>
                                @empty
                                @endforelse
                            </div>
                            @break
                        @endswitch
                        <div>
                            <input type="checkbox" value="true" name="personal_response" class="form-check-input" @if(isset($question->personal_response) and $question->personal_response == true) checked @endif id="personal_response_check_{{ $exercise->id }}">
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
                        <input id="statement" name="statement" type="text" class="form-control" placeholder="Word" value="{{ $question->statement }}">
                        <br>
                        <input id="answer" name="answer" type="text" class="form-control" placeholder="Definition" value="{{ $question->answer }}">
                        <br>
                        @break
                    @case('fill_in_the_gaps')
                        @switch($subtype)
                        @case('1')
                            <textarea id="statement" name="statement" class="mce-editor" placeholder="Statement to fill"> {!! $question->statement !!} </textarea>
                            <p class="text-secondary"><small>Use double semicolon (;;) to indicate where the gap to fill will be placed.</small></p>
                            <input id="answer" name="answer" type="text" class="form-control" placeholder="Correct words" value="{{ $question->answer }}">
                            <p class="text-secondary"><small>List the correct word for each gap separating them by a single comma.</small></p>
                            <div class="mb-3">
                                <label for="audio" class="form-label">Select audio file</label>
                                <input class="form-control" type="file" name="audio" id="audio" accept="audio/*">
                            </div>
                            @break
                        @case('2')
                            <input id="statement" name="statement" type="text" class="form-control" placeholder="Statement to fill" value="{{ $question->statement }}">
                            <p class="text-secondary"><small>Use double semicolon (;;) to indicate where the gap to fill will be placed.</small></p>
                            <br>
                            <input id="answer" name="answer" type="text" class="form-control" placeholder="Matching Word" value="{{ $question->answer }}">
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
                                <textarea id="statement" name="statement" class="mce-editor" placeholder="Question statement">{!! $question->statement !!}</textarea>
                                <br>
                                @break
                            @case ('991')
                                <div>
                                    <label class="form-label mb-1">Question statement:</label>
                                    <input class="form-control mb-2" name="title" type="text" placeholder="Question statement" value="{{ $question->correct_answer }}">
                                    <label class="form-label mb-1">Title for column 1:</label>
                                    <input class="form-control mb-2" name="statement" type="text" placeholder="Column 1 title" value="{{ $question->statement }}">
                                    <label class="form-label mb-1">Title for column 2:</label>
                                    <input class="form-control mb-2" name="answer" type="text" placeholder="Column 2 title" value="{{ $question->answer }}">
                                    <label class="form-label mb-1">Number of text input spaces for student:</label>
                                    <input class="form-control" type="number" name="boxes_number" min="1" max="20" value="1" value="{{ $question->image_name }}">
                                </div>
                                <br>
                                @break
                        @endswitch
                        @break
                    @case('form')
                        @php 
                            $id = "".count($exercise->questions)."-$question->id";
                        @endphp
                        <div id="double-col-form" class="p-1">
                            <input class="form-control mb-1" name="title" type="text" placeholder="Activity title" value="{{ $question->correct_answer }}">
                            <input class="form-control mb-1" name="heading" type="text" placeholder="Heading title" value="{{ $question->heading_title }}">
                            <input class="form-control mb-1" name="statement" type="text" placeholder="Column 1 title" value="{{ $question->statement }}">
                            <input class="form-control mb-1" name="answer" type="text" placeholder="(Optional) Column 2 title" value="{{ $question->answer }}">
                            <p class="text-secondary mb-1"><small>If you only need a single column leave this field empty.</small></p>
                            <div class="form-check mb-2">
                                <input class="form-check-input" name="exclusive_responses" type="checkbox" value="true" @if($question->exclusive_responses) checked @endif id="exclusive_response_check_{{ $exercise->id }}">
                                <label class="form-check-label" for="exclusive_response_check_{{ $exercise->id }}">Exclusive responses</label>
                            </div>
                            <button type="button" class="btn btn-primary btn-sm" onclick="addNewColumn({{ json_encode($id) }})">Add question</button>

                            <div id="questions-form-{{ $id }}" class="mt-2 p-1">
                                @foreach($question->alternatives as $alt)
                                    <div class="row form-question-title-{{ $id }} mt-1 mb-1" id="form-question-{{ $id }}">
                                        <div class="col-1">
                                            <p>{{ $loop->index + 1 }}.</p>
                                        </div>
                                        <div class="col-9">
                                            <input type="text" class="form-control" name="alternatives[]" placeholder="Statement" value="{{ $alt->title }}">
                                        </div>
                                        <div class="col-1">
                                            <button type="button" class="btn btn-danger" onclick="deleteFormQuestion(`form-question-{{ $id }}`)"><i class="mdi mdi-delete"></i></button>
                                        </div>
                                    </div>
                                @endforeach 
                            </div>
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