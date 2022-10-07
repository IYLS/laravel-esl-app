{{-- EVALUATING STATEMENT --}}
<form action="">
    @foreach($e->questions as $question)
        <div class="border rounded p-4 mt-3 mb-3 shadow">
            <p>{{ $loop->index + 1 . ". " . $question->statement }}</p>
            <div class="mt-2">
                <ol type="a">
                    <li>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="question-{{ $question->id }}" value="true" >
                            <label class="form-check-label">True</label>
                        </div>
                    </li>
                    <li>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="question-{{ $question->id }}" value="false">
                            <label class="form-check-label">False</label>
                        </div>
                    </li>
                    <li>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="question-{{ $question->id }}" value="not sure">
                            <label class="form-check-label">I'm not sure</label>
                        </div>
                    </li>
                </ol>
            </div>
            @include('feedback.question', ['feedbacks' => $question->feedbacks])
        </div>
    @endforeach
</form>

@include('feedback.exercise')

<div class="m-2 mt-4">
    <button class="btn btn-primary btn-sm" onclick="getMultipleChoiceResults({{ json_encode($e->questions) }}, {{ $e->id }})">Check</button>
</div>

<div class="m-2 mt-1">
    <button class="btn btn-sm btn-primary" type="submit">
        Submit
    </button>
</div>