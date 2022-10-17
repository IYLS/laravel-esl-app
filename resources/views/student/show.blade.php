@extends('layouts.app')
@section('main')

<style>
    .strikable { text-decoration: line-through }
    .not-strikable { text-decoration: none }
    .modal-backdrop { opacity: 0 !important }
    .clickable { cursor: pointer !important }

    .meta {
        color: green !important;
        background-color: #f8f9fa !important;
    }

    .meta:active {
        color: #f8f9fa !important;
        background-color: #198754 !important;
    }

    .meta:focus {
        color: #f8f9fa !important;
        background-color: #198754 !important;
    }
</style>

<div class="p-4 row w-100 h-100 col-12">
    <h5 class="pl-2">{{ $unit->title }}</h5>
    <div class="row">
        <div class="col-12 col-xl-4">
            <small class="text-secondary">Keywords:</small>
            @forelse($keywords as $keyword)
                @php $modal_id = "keyword_modal-$keyword->id"; @endphp
                <button type="button" id="{{ $modal_id . "_button" }}" class="mt-1 btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#{{ $modal_id }}">{{ $keyword->keyword }}</button>
                @include('modals.keywords.show', ['modal_id' => $modal_id, 'description' => $keyword->description, 'modal_title' => $keyword->keyword])
            @empty
                <p class="text-center text-secondary"><small>No keywords added for this unit.</small></p>
            @endforelse
        </div>
        <div class="col-12 col-xl-8">
            @include('exercises.help_options', ['unit' => $unit])
        </div>
    </div>
    <div class="row" id="keywords_content">
        <div class="col-4" id="keywords_detail"></div>
        <div class="col-8" id="help_option_detail"></div>
    </div>

    {{-- Video section --}}
    <div class="col-12 col-xl-4">
        @if(isset($unit->video_name) and $unit->video_name != null and $unit->video_name != '')
            <div class="ratio ratio-16x9 mt-3">
                <iframe src="{{ asset('esl/public/storage/files') . "/" . $unit->video_name }}" title="Video" allowfullscreen controls></iframe>
            </div>
        @else
            <div class="text-center">
                <p class="text-secondary"><small>No video set for this unit.</small></p>
            </div>
        @endif
    </div>

    {{-- Exercises and content section --}}
    <div class="col-12 col-xl-8 bg-light mt-2 p-3 rounded shadow">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            @foreach($unit->sections as $section)
                <li class="nav-item" role="presentation">
                    @if($loop->index == 0)
                        <button class="nav-link active" id="{{ $section->underscore_name }}-tab" onclick="hideFeedback()" data-bs-toggle="tab" data-bs-target="#{{ $section->underscore_name}}" type="button" role="tab" aria-controls="{{ $section->underscore_name }}" aria-selected="true">{{ $section->name }}</button>
                    @else
                        <button class="nav-link" id="{{ $section->underscore_name }}-tab" onclick="hideFeedback();" data-bs-toggle="tab" data-bs-target="#{{ $section->underscore_name}}" type="button" role="tab" aria-controls="{{ $section->underscore_name }}" aria-selected="false">{{ $section->name }}</button>
                    @endif
                </li>
            @endforeach
        </ul>
        <div class="tab-content" id="myTabContent">
            @foreach($unit->sections as $section)
                @if($loop->index == 0)
                    <div class="tab-pane fade show active m-2" id="{{ $section->underscore_name }}" role="tabpanel" aria-labelledby="{{ $section->underscore_name }}-tab">
                @else
                    <div class="tab-pane fade" id="{{ $section->underscore_name }}" role="tabpanel" aria-labelledby="{{ $section->underscore_name }}-tab">
                @endif
                <div class="d-flex align-items-start row mt-2">
                    {{-- (Optional) Additional Information --}}
                    @if(isset($section->instructions) and $section->instructions != '')
                    <div class="card pt-1 mb-2 pb-1 d-flex justify-content-center">
                        <p class="text-primary"><i class="mdi mdi-information-outline text-primary"></i>&nbsp;{{ $section->instructions }}</p>
                    </div>
                    @endif
                    <div class="nav flex-column mt-2 nav-pills col-12 col-xl-2" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        @foreach($section->exercises as $e)
                            <button class="nav-link @if($e->subtype == 99) meta @endif" id="{{ $e->exerciseType->underscore_name . $e->id }}-tab" data-bs-toggle="pill" data-bs-target="#{{ $e->exerciseType->underscore_name . $e->id }}" type="button" role="tab" aria-controls="{{ $e->exerciseType->underscore_name . $e->id }}" aria-selected="false" onclick="hideFeedback();startTimer();resetIntentCount();">{{ $e->title }}</button>
                        @endforeach
                    </div>
                    <div class="tab-content container-fluid col-12 col-xl-10" id="v-pills-tabContent">
                        @foreach($section->exercises as $e)
                            @php
                                $feedback_content = array(
                                    'ids' => [],
                                    'names' => [],
                                    'text_based' => [],
                                );

                                if($e->feedbacks != null)
                                {
                                    foreach($e->feedbacks as $feedback)
                                    {
                                        array_push($feedback_content['ids'], $feedback->feedbackType->id);
                                        array_push($feedback_content['names'], $feedback->feedbackType->name);
                                        array_push($feedback_content['text_based'], $feedback->feedbackType->text_based);
                                    }
                                }
                            @endphp

                            @switch($e->exerciseType->underscore_name)
                            @case('drag_and_drop')
                                @include('exercises.drag_and_drop.drag_and_drop')
                                @break
                            @case('open_ended')
                                @if($e->subtype == 1 or $e->subtype == 99)
                                    @include('exercises.open_ended.single_text')
                                @elseif($e->subtype == 991)
                                    @include('exercises.open_ended.double_text')
                                @endif
                                @break
                            @case('voice_recognition')
                                @include('exercises.voice_recognition.asd')
                                @break
                            @case('multiple_choice')
                                <div class="tab-pane fade" id="{{ $e->exerciseType->underscore_name . $e->id }}" role="tabpanel" aria-labelledby="{{ $e->exerciseType->underscore_name . $e->id }}-tab">
                                    <div class="container">
                                        <h4>{{ $e->title }}</h4>
                                        <p class="text-secondary">{{ $e->description }}</p>
                                        @isset($e->extra_info) <p class="text-info"><i class="mdi mdi-information-outline text-info"></i> &nbsp; {{ $e->extra_info }}</p> @endisset
                                        @include('partials.tracking_complete')

                                        @if(isset($e->video_name) and $e->video_name != null and $e->video_name != '')
                                            <div class="ratio ratio-16x9 mt-3">
                                                <iframe src="{{ asset('esl/public/storage/files') . "/" . $e->video_name }}" title="Video" allowfullscreen controls></iframe>
                                            </div>
                                        @endif

                                        @if(isset($e->image_name) and $e->image_name != null and $e->image_name != '')
                                            <div class="row m-3">
                                                <img src="{{ asset('esl/public/storage/files'. "/" . $e->image_name) }}" class="img-fluid col-12 col-lg-8" alt="img">
                                            </div>
                                        @endif

                                        <form action="{{ route('tracking.store', ["$e->id", "$user->id"]) }}" onsubmit="return getResponseData({{ json_encode($e->questions) }}, {{ json_encode($e) }}, 'multiple_choice');" method="POST" id="multiple_choice_form_{{ $e->id }}">
                                            @csrf
                                            {{-- Subtype 1 = Predicting --}}
                                            @if($e->subtype == 1)
                                                @include('exercises.multiple_choice.predicting')

                                            {{-- Subtype 2 = What do you hear? --}}
                                            @elseif($e->subtype == 2)
                                                @include('exercises.multiple_choice.what_do_you_hear')

                                            {{-- Subtype 3 = Evaluating statements --}}
                                            @elseif($e->subtype == 3)
                                                @include('exercises.multiple_choice.evaluating_statements')

                                            {{-- Subtype 4 = Multiple Choice --}}
                                            @elseif($e->subtype == 4 or $e->subtype == 99)
                                                @include('exercises.multiple_choice.multiple_choice')
                                            @endif
                                            
                                            <br>
                                            @include('partials.tracking_buttons', ['tracking' => $e->tracking, 'questions' => $e->questions, 'exercise_id' => $e->id, 'subtype' => $e->subtype])
                                        </form>
                                    </div>
                                </div>
                                @break
                            @case('fill_in_the_gaps')
                                <div class="tab-pane fade" id="{{ $e->exerciseType->underscore_name . $e->id }}" role="tabpanel" aria-labelledby="{{ $e->exerciseType->underscore_name . $e->id }}-tab">
                                    <div class="container">
                                        <h4>{{ $e->title }}</h4>
                                        <p class="text-secondary">{{ $e->description }}</p>
                                        @isset($e->extra_info) <p class="text-info"><i class="mdi mdi-information-outline text-info"></i> &nbsp; {{ $e->extra_info }}</p> @endisset

                                        {{--  Dictation Cloze  --}}
                                        @if($e->subtype == 1) 
                                            @include('exercises.fill_in_the_gaps.dictation_cloze')

                                        {{-- Vocabulary Practice --}}
                                        @elseif($e->subtype == 2)
                                            @include('exercises.fill_in_the_gaps.vocabulary_practice')
                                        @endif
                                    </div>
                                </div>
                                @break
                            @case('form')
                                <div class="tab-pane fade" id="{{ $e->exerciseType->underscore_name . $e->id }}" role="tabpanel" aria-labelledby="{{ $e->exerciseType->underscore_name . $e->id }}-tab">
                                    <div class="container">
                                        <h4>{{ $e->title }}</h4>
                                        <p class="text-secondary">{{ $e->description }}</p>
                                        @isset($e->extra_info) <p class="text-info"><i class="mdi mdi-information-outline text-info"></i> &nbsp; {{ $e->extra_info }}</p> @endisset

                                        {{-- Form --}}
                                        @include('exercises.form.dashboard')
                                        
                                    </div>
                                </div>
                                @break
                                @default
                            @endswitch
                        @endforeach
                    </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>


<script>
    var startTime;

    function startTimer() {
        window.startTime = new Date().getTime();
        console.log(window.startTime);
    }
</script>

<script>
    function millisToMinutesAndSeconds(millis) {
        var minutes = Math.floor(millis / 60000);
        var seconds = ((millis % 60000) / 1000).toFixed(0);
        return minutes + ":" + (seconds < 10 ? '0' : '') + seconds;
    }
</script>

<script>
    var intentCount = 0;

    function resetIntentCount() {
        window.intentCount = 0;
    }

    function stepIntentCount() {
        window.intentCount += 1;
    }
</script>

{{-- Drag and Drop --}}
<script>
    function allowDrop(ev) {
      ev.preventDefault();
    }
    
    function drag(ev) {
      ev.dataTransfer.setData("text", ev.target.id);
    }
    
    function drop(ev) {
      ev.preventDefault();
      var data = ev.dataTransfer.getData("text");
      ev.target.appendChild(document.getElementById(data));
    }
</script>

{{-- Fill In the gaps --}}
<script>
    function strikeWord(item) {
        if(!item.classList.contains('strikable')) {
            item.classList.add('strikable');
            item.classList.add('bg-warning');
        } else {
            item.classList.remove('strikable');
            item.classList.remove('bg-warning');
        }
    }
</script>

{{-- Feedback  --}}
<script>
    function showFeedback() {
        const feedbackElements = document.getElementsByClassName('feedback');
        for (const element of feedbackElements) element.hidden = false;
    }

    function hideFeedback() {
        const feedbackElements = document.getElementsByClassName('feedback');
        for (const element of feedbackElements){
            element.hidden = true;
        };
    }
</script>

{{-- Get Response Data --}}
<script>
    function getResponseData(questions, exercise, type) {
        var answers;
        switch(type) {
            case 'drag_and_drop':
                answers = getDragAndDropResults(questions, exercise);
                break;
            case 'multiple_choice':
                answers = getMultipleChoiceResults(questions, exercise);
                break;
            case 'fill_in_the_gaps':
                answers = getFillInTheGapsResults(questions, exercise);
                break;
            case 'open_ended':
                answers = getOpenEndedResults(questions, exercise);
                break;
            case 'form':
                answers = getFormResults(questions, exercise);
        }

        var currentTime = new Date().getTime();
        var timeSpent = millisToMinutesAndSeconds(currentTime - window.startTime);
    
        var form = document.getElementById(`${type}_form_${exercise.id}`);

        if(type != 'open_ended' && type != 'form' && exercise.subtype != 99 && exercise.subtype != 991) {            
            var wrong = document.createElement('input');
            wrong.setAttribute('value', `${answers.wrong}`);
            wrong.setAttribute('name', `wrong`);
            wrong.hidden = true;
            form.appendChild(wrong);
        
            var correct = document.createElement('input');
            correct.setAttribute('value', `${answers.correct}`);
            correct.setAttribute('name', `correct`);
            correct.hidden = true;
            form.appendChild(correct);
        }

        var time = document.createElement('input');
        time.setAttribute('value', `${timeSpent}`);
        time.setAttribute('name', `time`);
        time.hidden = true;
        form.appendChild(time);

        var intentCount = document.createElement('input');
        intentCount.setAttribute('value', `${window.intentCount}`);
        intentCount.setAttribute('name', `intent_number`);
        intentCount.hidden = true;
        form.appendChild(intentCount);

        answers.responses.forEach(function (item){
            var responseItem = document.createElement('input');
            responseItem.setAttribute('value', `${item.response}`);
            responseItem.setAttribute('name', `responses[${item.id}]`);
            responseItem.hidden = true;

            form.appendChild(responseItem);
        });
    }
</script>

{{--  Multiple choice questions --}}
<script>
    function getMultipleChoiceResults(questions, exercise) {
        var correct_questions = 0;
        var wrong_questions = 0;
        var questions_number = questions.length;

        var responses = [];

        questions.forEach(function (question) {
            const alternatives = document.getElementsByName(`question-${question.id}`);            

            alternatives.forEach((alternative) => {
                // Alternativa correcta
                if (alternative.checked && question.correct_answer == alternative.value) {
                    responses.push({'id': `${question.id}`, 'response': `${question.correct_answer}`});
                    
                    document.getElementById(`question-${question.id}-feedback-correct`).hidden = false;
                    document.getElementById(`question-${question.id}-feedback-wrong`).hidden = true;



                    correct_questions += 1;
                // Alternativa incorrecta
                } else if(alternative.checked) {
                    document.getElementById(`question-${question.id}-feedback-wrong`).hidden = false;
                    document.getElementById(`question-${question.id}-feedback-correct`).hidden = true;



                    responses.push({'id': `${question.id}`, 'response': `${alternative.parentNode.children[1].innerHTML.trim()}`});
                }
            });
        });

        wrong_questions = questions_number - correct_questions;

        correctAnswersItem = document.getElementById(`feedback-exercise-correct-${exercise.id}`);
        wrongAnswersItem = document.getElementById(`feedback-exercise-wrong-${exercise.id}`);
        
        exerciseDetailsContainer = document.getElementById(`feedback-exercise-details-container-${exercise.id}`);

        correctAnswersItem.innerHTML = `<strong>Correct answers:</strong> ${correct_questions}  ✅`;
        wrongAnswersItem.innerHTML = `<strong>Wrong answers:</strong> ${wrong_questions}  ❌`;

        correctAnswersItem.hidden = false;
        wrongAnswersItem.hidden = false;
        exerciseDetailsContainer.hidden = false;

        showFeedback();

        return { 'correct': correct_questions, 'wrong': wrong_questions, 'responses': responses };
    }
</script>

{{--  Fill In The Gaps questions --}}
<script>
    function getFillInTheGapsResults(questions, exercise) {
        var correct_questions = 0;
        var wrong_questions = 0;
        var questions_number = questions.length;

        var responses = [];
        questions.forEach(function (question) {
            var correct_words = question.answer;
            var answers = document.getElementsByName(`answer-${question.id}`);
            var question_responses = [];

            answers.forEach(function callback(answerItem, index) {
                question_responses.push(answerItem.value);
            });

            const final_responses = question_responses.join(',');
            responses.push({'id': `${question.id}`, 'response': `${final_responses}` });

            if(final_responses == correct_words) correct_questions += 1;
        });

        wrong_questions = questions_number - correct_questions;

        correctAnswersItem = document.getElementById(`feedback-exercise-correct-${exercise.id}`);
        wrongAnswersItem = document.getElementById(`feedback-exercise-wrong-${exercise.id}`);
        
        exerciseDetailsContainer = document.getElementById(`feedback-exercise-details-container-${exercise.id}`);

        correctAnswersItem.innerHTML = `<strong>Correct answers:</strong> ${correct_questions}  ✅`;
        wrongAnswersItem.innerHTML = `<strong>Wrong answers:</strong> ${wrong_questions}  ❌`;

        correctAnswersItem.hidden = false;
        wrongAnswersItem.hidden = false;

        exerciseDetailsContainer.hidden = false;

        showFeedback();

        return { 'correct': correct_questions, 'wrong': wrong_questions, 'responses': responses };
    }
</script>

{{--  Open Ended questions --}}
<script>
    function getOpenEndedResults(questions, exercise) {
        var responses = [];
        questions.forEach(function (question) {
            var answers = document.getElementsByName(`answer-${question.id}`);
            answers.forEach(function (answer) {
                responses.push({'id': `${question.id}`, 'response': `${answer.value}` });
            });
        });
        
        var exerciseDetailsContainer = document.getElementById(`feedback-exercise-details-container-${exercise.id}`);
        exerciseDetailsContainer.hidden = false;

        showFeedback();

        return { 'responses': responses };
    }
</script>

{{-- Drag And Drop --}}
<script>
    function getDragAndDropResults(questions, exercise) {
        var correct_questions = 0;
        var wrong_questions = 0;
        var empty_questions = 0;
        var questions_number = questions.length;

        var responses = [];

        questions.forEach(function (question) {
            const definitionContainer = document.getElementById(`word-destination-${question.answer}`);
            const wordContainer = document.getElementById(`word-${question.statement}`);

            if(definitionContainer.firstChild != null) {
                const actualResponse = definitionContainer.firstChild.innerHTML.trim();
                responses.push({'id': `${question.id}`, 'response': `${actualResponse}`})
            } else {
                const actualResponse = "";
                return 'missing_responses';
            }

            if (definitionContainer.contains(wordContainer)) {
                correct_questions += 1;
            } else {
                wrong_questions +=1;
            }
        });

        wrong_questions = questions_number - correct_questions;

        correctAnswersItem = document.getElementById(`feedback-exercise-correct-${exercise.id}`);
        wrongAnswersItem = document.getElementById(`feedback-exercise-wrong-${exercise.id}`);

        exerciseDetailsContainer = document.getElementById(`feedback-exercise-details-container-${exercise.id}`);

        correctAnswersItem.innerHTML = `<strong>Correct answers:</strong> ${correct_questions}  ✅`;
        wrongAnswersItem.innerHTML = `<strong>Wrong answers:</strong> ${wrong_questions}  ❌`;

        correctAnswersItem.hidden = false;
        wrongAnswersItem.hidden = false;

        exerciseDetailsContainer.hidden = false;

        showFeedback();

        return { 'correct': correct_questions, 'wrong': wrong_questions, 'responses': responses }
    }
</script>

@endsection