{{-- WHAT DO YOU HEAR? --}}
@foreach($e->questions->sortBy('position') as $question)
    <div class="border rounded p-4 mt-3 mb-3 shadow">
        @php 
        $statement = str_replace(";;","_______", $question->statement)
        @endphp
        <div class="d-flex">
            <p>{{ $loop->index + 1 . ".  " }}&nbsp;</p>
            {!! $statement !!}
        </div>
        <br>
        <audio controls class="col-6">
            <source src="{{ asset('storage/files/'.$question->audio_name) }}" type="audio/mpeg">
        </audio>
        <div class="mt-2">
            <div class="alternatives-list">
                @foreach($question->alternatives as $a)
                    <div class="d-flex align-items-center mb-2">
                        <span class="bullet me-3">{{ chr(97 + $loop->index) }}.</span>
                        <input class="form-check-input multiple-choice-{{ $e->id }}-check me-3" type="radio" name="question-{{ $question->id }}" id="{{ $a->id }}" value="{{ $a->title }}">
                        <label class="form-check-label mb-0" for="{{ $a->id }}">{{ $a->title }}</label>
                    </div>
                @endforeach
            </div>
        </div>

        <br>
        @include('feedback.question', ['feedbacks' => $question->feedbacks])
    </div>
@endforeach
