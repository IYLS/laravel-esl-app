{{-- WHAT DO YOU HEAR? --}}
@foreach($e->questions as $question)
    <div class="border rounded p-4 mt-3 mb-3 shadow">
        @php 
        $statement = str_replace(";;","_______", $question->statement)
        @endphp
        <p>{{ $loop->index + 1 . ". " . $statement }}</p>
        <br>
        <audio controls class="col-6">
            <source src="{{ asset('esl/public/storage/files/'.$question->audio_name) }}" type="audio/mpeg">
        </audio>
        <div class="mt-2">
            <ol type="a">
                @foreach($question->alternatives as $a)
                    <li>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="question-{{ $question->id }}" id="{{ $a->id }}" value="{{ $a->title }}">
                            <label class="form-check-label">{{ $a->title }}</label>
                        </div>
                    </li>
                @endforeach
            </ol>
        </div>

        <br>
        @include('feedback.question')
    </div>

@endforeach

@include('feedback.exercise')

<div class="m-2 mt-4">
    <button class="btn btn-primary btn-sm" onclick="getMultipleChoiceResults({{ json_encode($e->questions) }}, {{ $e->id }})">Check</button>
</div>