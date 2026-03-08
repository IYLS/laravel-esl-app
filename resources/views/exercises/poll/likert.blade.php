{{-- Vista estudiante: escala Likert 1-7 --}}
@include('layouts.tracking.tracking_complete')
<form action="{{ route('tracking.store', ["$e->id", "$user->id"]) }}" method="POST" id="poll_form_{{ $e->id }}">
    @csrf
    @foreach($e->questions->sortBy('position') as $question)
        <div class="border rounded p-4 mt-3 mb-3 shadow">
            <div class="mb-3">
                <p class="mb-2 fw-medium">{{ $loop->index + 1 }}. {!! $question->statement !!}</p>
                <div class="d-flex flex-wrap align-items-center gap-2 gap-md-3">
                    @foreach($question->alternatives->sortBy('title') as $alt)
                        <div class="form-check form-check-inline">
                            <input 
                                class="form-check-input poll-{{ $e->id }}-check" 
                                type="radio" 
                                name="question-{{ $question->id }}" 
                                id="poll-{{ $question->id }}-{{ $alt->id }}" 
                                value="{{ $alt->title }}"
                                required
                            >
                            <label class="form-check-label" for="poll-{{ $question->id }}-{{ $alt->id }}">{{ $alt->title }}</label>
                        </div>
                    @endforeach
                </div>
                <small class="text-muted d-block mt-1">1 = strongly disagree — 7 = strongly agree</small>
            </div>
        </div>
    @endforeach

    <br>
    @include('layouts.tracking.tracking_buttons', ['tracking' => $e->tracking, 'questions' => $e->questions, 'exercise_id' => $e->id, 'subtype' => $e->subtype])
</form>
