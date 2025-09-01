{{-- EVALUATING STATEMENT --}}
@foreach($e->questions->sortBy('position') as $question)
    <div class="border rounded p-4 mt-3 mb-3 shadow">
        <div class="d-flex">
            <p>{{ $loop->index + 1 . ".  " }}&nbsp;</p>
            {!! $question->statement !!}
        </div>
        <div class="mt-2">
            <div class="alternatives-list">
                @forelse($question->alternatives as $alt)
                    <div class="d-flex align-items-center mb-2">
                        <span class="me-3">{{ chr(97 + $loop->index) }}.</span>
                        <input class="form-check-input multiple-choice-{{ $e->id }}-check me-3" name="question-{{ $question->id }}" id="{{ $alt->id }}" type="radio" value="{{ $alt->title }}">
                        <label class="form-check-label mb-0" for="{{ $alt->id }}">{{ $alt->title }}</label>
                    </div>
                @empty
                @endforelse
            </div>
        </div>
        @include('feedback.question', ['feedbacks' => $question->feedbacks])
    </div>
@endforeach