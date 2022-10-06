@foreach($e->questions as $question)
<div class="border rounded p-4">
    <p>{{ $loop->index + 1 }}. &nbsp;</p>
    <div class="row mt-2 mb-2">
        <audio controls class="col-12">
            <source src="{{ asset('esl/public/storage/files/'.$question->audio_name) }}" type="audio/mpeg">
        </audio> 
    </div>
    <div class="mt-4 mb-4">
        @php
        $gaps_count = substr_count($question->statement, ";;");
        $strips = explode(";;", $question->statement);
        @endphp

        @foreach($strips as $strip)
        {{ $strip }} @if($loop->index < $gaps_count) <input class="mt-1 mb-1 me-1 ms-1" type="text"" style="height: 24px; border-radius: 4px; border: 0.5px solid #ccc; padding: 8px;"> @endif
        @endforeach
    </div>
    @include('feedback.question')
</div>
@endforeach
<br>

@include('feedback.exercise')

<button class="btn btn-sm btn-primary" onclick="showFeedback()">
    Check
</button>