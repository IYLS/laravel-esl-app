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
            <source src="{{ asset('esl/public/storage/files/'.$question->audio_name) }}" type="audio/mpeg">
        </audio>
        <div class="mt-2">
            <ol type="a">
                @foreach($question->alternatives as $a)
                    <li>
                        <div class="form-check">
                            <input class="form-check-input multiple-choice-{{ $e->id }}-check" type="radio" name="question-{{ $question->id }}" id="{{ $a->id }}" value="{{ $a->title }}">
                            <label class="form-check-label" for="{{ $a->id }}">{{ $a->title }}</label>
                        </div>
                    </li>
                @endforeach
            </ol>
        </div>

        <br>
        @include('feedback.question', ['feedbacks' => $question->feedbacks])
    </div>

@endforeach