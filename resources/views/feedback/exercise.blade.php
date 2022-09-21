@isset($e->feedback)
    @php 
        $level = $e->feedback->feedbackType->level;
        $text_based = $e->feedback->feedbackType->text_based;
        $message = $e->feedback->message;
        $audio = $e->feedback->audio_name;
    @endphp

    @if($level == 'exercise')
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
    @endif
@endisset