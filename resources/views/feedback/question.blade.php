@isset($e->feedback)
    @php 
        $level = $e->feedback->feedbackType->level;
        $text_based = $e->feedback->feedbackType->text_based;
    @endphp

    @if($level == 'question')
        @if($text_based)
            <div class="m-1 p-1 feedback border border-success" hidden>
                <p class="text-secondary">💡 Feedback  - {{ $question->feedback->feedbackType->name }}</p>
                <p>💡 {{ $question->feedback->message }}</p>
                {{-- <p>✅</p>
                <p>❌</p> --}}
            </div>
        @else
            <div class="m-1 p-1 feedback border border-warning" hidden>
                <p class="text-secondary">💡 Feedback  - {{ $question->feedback->feedbackType->name }}</p>
                <div class="row">
                    <audio controls class="col-12">
                        <source src="{{ asset('storage/files/'.$question->feedback->audio_name) }}" type="audio/mpeg">
                    </audio> 
                </div>
            </div>
        @endif
    @endif
@endisset

<script>

function getAlts(question_id) {
    
}

</script>

