{{-- MULTIPLE CHOICE --}}
@foreach($e->questions->sortBy('position') as $question)
    <div class="border rounded p-4 mt-3 mb-3 shadow">
        <div class="d-flex">
            <p>{{ $loop->index + 1 . ".  " }}&nbsp;</p>
            {!! $question->statement !!}
        </div>
        <div class="mt-2">
            <div class="alternatives-list">
                @foreach($question->alternatives as $a)
                <div class="d-flex align-items-center mb-2">
                    <input class="form-check-input multiple-choice-{{ $e->id }}-check me-3" type="radio" name="question-{{ $question->id }}" id="{{ $a->id }}" value="{{ $a->title }}">
                    <span class="me-3">{{ chr(97 + $loop->index) }}.</span>
                    <label class="form-check-label mb-0" for="{{ $a->id }}">{{ $a->title }}</label>
                </div>
                @endforeach
            </div>
        </div>
        @include('feedback.question', ['feedbacks' => $question->feedbacks])
    </div>
@endforeach