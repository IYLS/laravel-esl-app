{{-- EVALUATING STATEMENT --}}
@foreach($e->questions as $question)
    <div class="border rounded p-4 mt-3 mb-3 shadow">
        <p>{{ $loop->index + 1 . ". " . $question->statement }}</p>
        <div class="mt-2">
            <ol type="a">
                <li>
                    <div class="form-check">
                        <input class="form-check-input" name="question-{{ $question->id }}" type="radio" value="true" >
                        <label class="form-check-label" value="True">True</label>
                    </div>
                </li>
                <li>
                    <div class="form-check">
                        <input class="form-check-input" name="question-{{ $question->id }}" type="radio" value="false">
                        <label class="form-check-label" value="False">False</label>
                    </div>
                </li>
                <li>
                    <div class="form-check">
                        <input class="form-check-input" name="question-{{ $question->id }}" type="radio" value="not sure">
                        <label class="form-check-label" value="I'm not sure">I'm not sure</label>
                    </div>
                </li>
            </ol>
        </div>
        @include('feedback.question', ['feedbacks' => $question->feedbacks])
    </div>
@endforeach