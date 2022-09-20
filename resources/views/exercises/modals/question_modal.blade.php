@php $type = $exercise->exerciseType->underscore_name; @endphp
<div class="modal fade" id="addQuestionModal" tabindex="-1" aria-labelledby="addQuestionModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addQuestionModal">New Question</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form @if($type == "voice_recognition") enctype="multipart/form-data" @endif action="{{ route('questions.store', [$exercise->id, $exercise->section_id, $exercise->exercise_type_id]) }}" method="POST">
                    @csrf
                    @php
                    $statement_placeholder = "";
                    $answer_placeholder = "";
                    @endphp
                    @switch($type)
                    @case('drag_and_drop')
                        @php 
                            $statement_placeholder = "Word";
                            $answer_placeholder = 'Matching description';
                        @endphp
                        @break
                    @case('fill_in_the_gaps')
                        @php 
                            $statement_placeholder = "Statement";
                            $answer_placeholder = "Concept";
                        @endphp
                        @break
                    @case('multiple_choice')
                        @php  
                            $statement_placeholder = "Question statement";
                        @endphp
                        @break
                    @case('open_ended')
                        @php 
                            $statement_placeholder = "open_ended";
                        @endphp
                        @break
                    @case('voice_recognition')
                        @php 
                            $statement_placeholder = "Item title";
                        @endphp
                        @break
                    @default
                    @endswitch

                    @if($type == 'open_ended')

                        <textarea id="statement" name="statement" type="text" cols="40" class="form-control" placeholder="{{ $statement_placeholder }}"></textarea>
                        <br>

                    @else
                        <input id="statement" name="statement" type="text" class="form-control" placeholder="{{ $statement_placeholder }}">
                        <br>

                        @if($type != 'multiple_choice' && $type != 'open_ended' && $type != 'voice_recognition')
                            <input id="answer" name="answer" type="text" class="form-control" placeholder="{{ $answer_placeholder }}">
                        @elseif($type == 'voice_recognition')
                            <div class="mb-3">
                                <label for="audio" class="form-label">Select audio file</label>
                                <input class="form-control" type="file" name="audio" id="audio" accept="audio/*">
                            </div>
                            <div class="mb-3">
                                <label for="image" class="form-label">Select image file</label>
                                <input class="form-control" type="file" name="image" id="image" accept="image/*">
                            </div>
                        @endif

                        @if($type == 'fill_in_the_gaps')
                            @if($exercise->subtype == 2)
                                <p class="text-secondary"><small>Use a semicolon (;) at the end of each statement. Except the last one.</small></p>
                            @elseif($exercise->subtype == 1)
                                <p class="text-secondary"><small>Use a semicolon (;;) at the end of each statement. Except the last one.</small></p>
                            @endif
                        @endif



                    @endif

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>