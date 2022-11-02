{{--  PREDICTING --}}
@foreach($e->questions->sortBy('position') as $question)
    <div class="border rounded p-4 mt-3 mb-3 shadow">
        {!! $question->statement !!}
        <ol type="a">
            @foreach($question->alternatives as $a)
                <li>
                    <div class="form-check">
                        <input class="form-check-input multiple-choice-{{ $e->id }}-check" type="radio" name="question-{{ $question->id }}" id="{{ $question->id }}-{{ $a->id }}" value="{{ $a->title }}">
                        <label class="form-check-label">{{ $a->title }}</label>
                    </div>
                </li>
            @endforeach
        </ol>
        @include('feedback.question', ['feedbacks' => $question->feedbacks])
    </div>
@endforeach