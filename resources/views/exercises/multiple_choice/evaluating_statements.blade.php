{{-- EVALUATING STATEMENT --}}
@foreach($e->questions->sortBy('position') as $question)
    <div class="border rounded p-4 mt-3 mb-3 shadow">
        <p>{!! $loop->index + 1 . ". " . $question->statement !!}</p>
        <div class="mt-2">
            <ol type="a">
                @forelse($question->alternatives as $alt)
                    <li>
                        <div class="form-check">
                            <input class="form-check-input multiple-choice-{{ $e->id }}-check" name="question-{{ $question->id }}" type="radio" value="{{ $alt->title }}">
                            <label class="form-check-label">{{ $alt->title }}</label>
                        </div>
                    </li>
                @empty
                @endforelse
            </ol>
        </div>
        @include('feedback.question', ['feedbacks' => $question->feedbacks])
    </div>
@endforeach