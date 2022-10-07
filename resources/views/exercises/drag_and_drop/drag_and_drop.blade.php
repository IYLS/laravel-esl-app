<div class="tab-pane fade" id="{{ $e->exerciseType->underscore_name . $e->id }}" role="tabpanel" aria-labelledby="{{ $e->exerciseType->underscore_name . $e->id }}-tab">
    <div class="">
        <h4>{{ $e->title }}</h4>
        <p class="text-secondary">{{ $e->description }}</p>
        @isset($e->extra_info) <p class="text-info"><i class="mdi mdi-information-outline text-info"></i> &nbsp; {{ $e->extra_info }}</p> @endisset
        @php
            $words = array();
            $definitions = array();

            foreach($e->questions as $question)
            {
                array_push($words, $question->statement);
                array_push($definitions, $question->answer);
            }

            shuffle($words);
            shuffle($definitions);

            $components = array_combine($words, $definitions);
        @endphp
        <div class="row pt-2 pb-2">
            <form action="">
                @foreach($e->questions as $question)
                    <div class="col-5 col-lg-2 mt-1">
                        <div ondrop="drop(event)" style="height:30px; width: 140px;" id="word-origin-{{ $question->statement }}" ondragover="allowDrop(event)">
                            <div class="border pe-2 ps-2 text-primary" id="word-{{ $question->statement }}" ondragstart="drag(event)" draggable="true" style="display: inline-block; border-style: dashed !important; height:30px;">
                                {{ $question->statement }}
                            </div>
                        </div>
                    </div>
                    <div class="col-7 col-lg-10 row mt-1">
                        <div class="col-12 col-lg-4 border" style="height:30px; width: 140px;" id="word-destination-{{ $components[$question->statement] }}" ondrop="drop(event)" ondragover="allowDrop(event)"></div>
                        <div class="col-12 col-lg-8" id="word-definition-{{ $components[$question->statement] }}">{{ $components[$question->statement] }}</div>
                    </div>
                    @if($e->subtype != '99' && $e->subtype != '991')
                        @include('feedback.question', ['feedbacks' => isset($question->feedbacks) ? $question->feedbacks : null])
                    @endif
                @endforeach
            </form>
        </div>

        @if($e->subtype != '99' && $e->subtype != '991')
            @include('feedback.exercise')
            <div class="m-2 mt-4 row">
                <button class="btn btn-primary btn-sm col-12 col-lg-4" onclick="getDragAndDropResults({{ json_encode($e->questions) }}, {{ $e->id }})">Check</button>
            </div>
        @endif
    </div>
</div>

<script>
    function getDragAndDropResults(questions, exercise_id) {
        var correct_questions = 0;
        var wrong_questions = 0;
        var questions_number = questions.length;

        questions.forEach(function (question) {
            const definitionContainer = document.getElementById(`word-destination-${question.answer}`);
            const wordContainer = document.getElementById(`word-${question.statement}`);

            if (definitionContainer.contains(wordContainer)) {
                correct_questions += 1;
            } else {
                wrong_questions +=1;
            }
        });

        wrong_questions = questions_number - correct_questions;

        correctAnswersItem = document.getElementById(`feedback-exercise-correct-${exercise_id}`);
        wrongAnswersItem = document.getElementById(`feedback-exercise-wrong-${exercise_id}`);

        exerciseDetailsContainer = document.getElementById(`feedback-exercise-details-container-${exercise_id}`);

        correctAnswersItem.innerHTML = `<strong>Correct answers:</strong> ${correct_questions}  ✅`;
        wrongAnswersItem.innerHTML = `<strong>Wrong answers:</strong> ${wrong_questions}  ❌`;

        correctAnswersItem.hidden = false;
        wrongAnswersItem.hidden = false;

        exerciseDetailsContainer.hidden = false;

        showFeedback();
    }
</script>
