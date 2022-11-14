{{-- EVALUATING STATEMENT --}}
@foreach($e->questions->sortBy('position') as $question)
    <div class="border rounded p-4 mt-3 mb-3 shadow">
        <div class="d-flex">
            <p>{{ $loop->index + 1 . ".  " }}&nbsp;</p>
            {!! $question->statement !!}
        </div>
        <div class="mt-2">
            <ol type="a">
                @forelse($question->alternatives as $alt)
                    <li>
                        <div class="form-check">
                            <input class="form-check-input multiple-choice-{{ $e->id }}-check" name="question-{{ $question->id }}" id="{{ $alt->id }}" type="radio" value="{{ $alt->title }}">
                            <label class="form-check-label" for="{{ $alt->id }}">{{ $alt->title }}</label>
                        </div>
                    </li>
                @empty
                @endforelse
            </ol>
        </div>
        @include('feedback.question', ['feedbacks' => $question->feedbacks])
    </div>
@endforeach