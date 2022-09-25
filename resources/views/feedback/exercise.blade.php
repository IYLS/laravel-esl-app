<div class="m-1 p-4 border" id="feedback-exercise-details-container-{{ $e->id }}" hidden>
    <h5 class="text-center">💡 Activity Feedback</h5>
    @isset($e->feedbacks)
        @php 
            // $level = $e->feedbacks->feedbackType->level;
            // $text_based = $e->feedback->feedbackType->text_based;
            // $message = $e->feedback->message;
            // $audio = $e->feedback->audio_name;

            echo($e->feedbacks);

            // array_column($e->feedbacks, '');

        @endphp
    
    
        {{-- @if($level == 'exercise')
            @if($text_based)
                <div class="m-1 feedback" hidden>
                    <p class="text-secondary"><small>Feedback &#128172;</small></p>
                    <p>{{ $message }}</p>
                </div>
            @else
                <div class="m-1 feedback" hidden>
                    <p class="text-secondary"><small>Feedback &#128172;</small></p>
                    <div class="row">
                        <audio controls class="col-10">
                            <source src="{{ asset('storage/files/'.$audio) }}" type="audio/mpeg">
                        </audio> 
                    </div>
                </div>
            @endif
        @endif --}}

    @endisset
    <p class="text-success text-center" id="feedback-exercise-correct-{{ $e->id }}" hidden></p>
    <p class="text-danger text-center" id="feedback-exercise-wrong-{{ $e->id }}" hidden></p>
</div>