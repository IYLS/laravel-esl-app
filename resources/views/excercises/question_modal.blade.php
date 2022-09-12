<div class="modal fade" id="addQuestionModal" tabindex="-1" aria-labelledby="addQuestionModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addQuestionModal">New Question</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('questions.store', [$excercise->id, $excercise->section_id, $excercise->excercise_type_id]) }}" method="POST">
                    @csrf
                    @switch($excercise->excerciseType->underscore_name)
                    @case('drag_and_drop')
                        @php 
                            $statement_placeholder = "drag_and_drop";
                            $answer_placeholder = "drag_and_drop";
                        @endphp
                        @break
                    @case('fill_in_the_gaps')
                        @php 
                            $statement_placeholder = "fill_in_the_gaps";
                            $answer_placeholder = "fill_in_the_gaps";
                        @endphp
                        @break
                    @case('multiple_choice')
                        @php 
                            $statement_placeholder = "multiple_choice";
                            $answer_placeholder = "multiple_choice";
                        @endphp
                        @break
                    @case('open_ended')
                        @php 
                            $statement_placeholder = "open_ended";
                            $answer_placeholder = "open_ended";
                        @endphp
                        @break
                    @case('voice_recognition')
                        @php 
                            $statement_placeholder = "voice_recognition";
                            $answer_placeholder = "voice_recognition";
                        @endphp
                        @break
                    @default
                        @php 
                            $statement_placeholder = "asd";
                            $answer_placeholder = "asd";
                        @endphp
                        @break
                    @endswitch

                    <input id="statement" name="statement" type="text" class="form-control" placeholder={{ $statement_placeholder }}>
                    <input id="answer" name="answer" type="text" class="form-control" placeholder={{ $answer_placeholder }}>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>