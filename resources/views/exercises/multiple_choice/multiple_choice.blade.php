{{-- MULTIPLE CHOICE --}}
@foreach($e->questions->sortBy('position') as $question)
    <div class="border rounded p-4 mt-3 mb-3 shadow">
        <p>{!! $loop->index + 1 . ". "  . $question->statement !!}</p>
        <div class="mt-2">
            <ol type="a">
                @foreach($question->alternatives as $a)
                <li>
                    <div class="form-check">
                        <input class="form-check-input multiple-choice-{{ $e->id }}-check" type="radio" name="question-{{ $question->id }}" id="{{ $a->id }}" value="{{ $a->title }}">
                        <label class="form-check-label">{{ $a->title }}</label>
                    </div>
                </li>
                @endforeach
            </ol>
        </div>
        @if($e->subtype != '99' && $e->subtype != '991')
            @include('feedback.question', ['feedbacks' => $question->feedbacks])
        @endif
    </div>
@endforeach