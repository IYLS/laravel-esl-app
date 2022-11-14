@extends('layouts.app')
@section('main')

@section('title', 'Student Module')

<style>
    .strikable { text-decoration: line-through }
    .not-strikable { text-decoration: none }
    .modal-backdrop { 
        opacity: 0 !important;
        position: unset !important;
    }
    .clickable {
        cursor: pointer !important;
        background-color: white;
    }

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

    .meta.active {
        color: #f8f9fa !important;
        background-color: #198754 !important;
    }
</style>

<div class="p-4 row w-100 h-100 col-12">
    <h5 class="pl-2">{{ $unit->title }}</h5>
    <div class="row sticky-top p-1" id="sticky-bar" style="background-color: white;">
        <div class="col-12 col-xl-4">
            @forelse($keywords as $keyword)
                @php $modal_id = "keyword_modal-$keyword->id"; @endphp
                <button type="button" id="{{ $modal_id . "_button" }}" class="mt-1 btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#{{ $modal_id }}" onclick="unstick()">{{ $keyword->keyword }}</button>
                @include('modals.keywords.show', ['modal_id' => $modal_id, 'description' => $keyword->description, 'modal_title' => $keyword->keyword])
            @empty
                <p class="text-center text-secondary"><small>No keywords added for this unit.</small></p>
            @endforelse
        </div>
        <div class="col-12 col-xl-8">
            @include('exercises.help_options', ['unit' => $unit])
        </div>
    </div>

    {{-- Video section --}}
    <div class="col-12 col-xl-4">
        @if(isset($unit->video_name) and $unit->video_name != null and $unit->video_name != '')
            <div class="ratio ratio-16x9 mt-3">
                <video title="Video" allowfullscreen controls>
                    <source src="{{ asset('esl/public/storage/files') . "/" . $unit->video_name }}">
                </video>
            </div>
            @if(isset($unit->video_copyright) and $unit->video_copyright != '') <p class="text-secondary"><small>{{ $unit->video_copyright }}</small></p> @endif
        @else
            <div class="text-center">
                <p class="text-secondary"><small>No video set for this unit.</small></p>
            </div>
        @endif
    </div>

    {{-- Exercises and content section --}}
    <div class="col-12 col-xl-8 bg-light mt-2 p-3 rounded shadow" id="top_student_area">
        <ul class="nav nav-tabs" id="sectionsTabs" role="tablist">
            @foreach($unit->sections->sortBy('position') as $section)
                @php $index = $loop->index + 1; @endphp
                <li class="nav-item" role="presentation">
                    @if($index-1 == 0)
                        <button class="nav-link section-btn active" id="{{ $section->underscore_name }}-tab" data-bs-toggle="tab" data-bs-target="#{{ $section->underscore_name}}" type="button" role="tab" aria-controls="{{ $section->underscore_name }}" aria-selected="true">{{ $index . ". " . $section->name }}</button>
                    @else
                        <button class="nav-link section-btn" id="{{ $section->underscore_name }}-tab" data-bs-toggle="tab" data-bs-target="#{{ $section->underscore_name}}" type="button" role="tab" aria-controls="{{ $section->underscore_name }}" aria-selected="false">{{ $index . ". " . $section->name }}</button>
                    @endif
                </li>
            @endforeach
        </ul>
        <div class="tab-content" id="myTabContent">
            @foreach($unit->sections->sortBy('position') as $section)
                @if($loop->index == 0)
                    <div class="tab-pane fade show section-pane active m-2" id="{{ $section->underscore_name }}" role="tabpanel" aria-labelledby="{{ $section->underscore_name }}-tab">
                @else
                    <div class="tab-pane fade section-pane" id="{{ $section->underscore_name }}" role="tabpanel" aria-labelledby="{{ $section->underscore_name }}-tab">
                @endif
                <div class="d-flex align-items-start row mt-2">
                    {{-- (Optional) Additional Information --}}
                    @if(isset($section->instructions) and $section->instructions != '')
                    <div class="card pt-1 mb-2 pb-1 d-flex justify-content-center">
                        <p class="text-primary"><i class="mdi mdi-information-outline text-primary"></i>&nbsp;{{ $section->instructions }}</p>
                    </div>
                    @endif
                    <div class="nav flex-column mt-2 nav-pills col-12 col-xl-2" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        @forelse($section->exercises->sortBy('position') as $e)
                            @php $index = $loop->index; @endphp
                            <button 
                                class="nav-link exercise-btn @if($e->subtype == 99) meta @endif @if($index == 0) active @endif"
                                id="{{ $e->exerciseType->underscore_name . $e->id }}-tab" 
                                data-bs-toggle="pill" 
                                data-bs-target="#{{ $e->exerciseType->underscore_name . $e->id }}" 
                                type="button" 
                                role="tab" 
                                aria-controls="{{ $e->exerciseType->underscore_name . $e->id }}" 
                                @if($index == 0)
                                    aria-selected="true"
                                @else
                                    aria-selected="false"
                                @endif
                                onclick="startTimer();">
                                    @if($e->title == '' or $e->title == null) 
                                        @if(count($completed_exercises) != 0 and in_array($e->id, $completed_exercises)) 
                                            <div class="d-flex justify-content-between">
                                                <div>
                                                    <p class="text-end">Activity #{{ $e->id }}</p>
                                                </div>
                                                <div>
                                                    <p>✅</p>
                                                </div>
                                            </div>
                                        @else
                                            Activity #{{ $e->id }}
                                        @endif
                                    @else 
                                        @if(count($completed_exercises) != 0 and in_array($e->id, $completed_exercises)) 
                                            {{ $e->title }} ✅
                                        @else
                                            {{ $e->title }}
                                        @endif
                                    @endif
                            </button>
                        @empty
                            <p class="text-center text-secondary"><small>No exercises added yet.</small></p>    
                        @endforelse
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
                                <div class="tab-pane exercise-pane fade @if($loop->index == 0) show active @endif" id="{{ $e->exerciseType->underscore_name . $e->id }}" role="tabpanel" aria-labelledby="{{ $e->exerciseType->underscore_name . $e->id }}-tab">
                                    <div class="container">
                                        <h4>{{ $e->title }}</h4>
                                        @include('layouts.tracking.tracking_complete')
                                        @isset($e->extra_info) <p class="text-info"><i class="mdi mdi-information-outline text-info"></i> &nbsp; {{ $e->extra_info }}</p> @endisset
                                        <p class="text-secondary">{{ $e->description }}</p>
                                        @isset($e->instructions) <div class="text-dark">{!! $e->instructions !!}</div> @endisset
                                        @isset($e->translated_instructions) <div class="text-secondary">{!! $e->translated_instructions !!}</div> @endisset
                                        <form action="{{ route('tracking.store', ["$e->id", "$user->id"]) }}" method="POST" id="open_ended_form_{{ $e->id }}" onsubmit="return getResponseData({{ json_encode($e->questions) }}, {{ json_encode($e) }}, 'open_ended')">
                                            @csrf
                                            @if($e->subtype == 1 or $e->subtype == 99)
                                                @include('exercises.open_ended.single_text')
                                            @elseif($e->subtype == 991)
                                                @include('exercises.open_ended.double_text')
                                            @endif
                                            @include('layouts.tracking.tracking_buttons', ['tracking' => $e->tracking, 'questions' => $e->questions, 'exercise_id' => $e->id, 'subtype' => $e->subtype])
                                        </form>
                                    </div>
                                </div>
                                @break
                            @case('voice_recognition')
                                @include('exercises.voice_recognition.asd')
                                @break
                            @case('multiple_choice')
                                <div class="tab-pane fade exercise-pane @if($loop->index == 0) show active @endif" id="{{ $e->exerciseType->underscore_name . $e->id }}" role="tabpanel" aria-labelledby="{{ $e->exerciseType->underscore_name . $e->id }}-tab">
                                    <div class="container">
                                        <h4>{{ $e->title }}</h4>
                                        <p class="text-secondary">{{ $e->description }}</p>
                                        @isset($e->instructions) <div class="text-dark">{!! $e->instructions !!}</div> @endisset
                                        @isset($e->translated_instructions) <div class="text-secondary">{!! $e->translated_instructions !!}</div> @endisset
                                        @isset($e->extra_info) <p class="text-info"><i class="mdi mdi-information-outline text-info"></i> &nbsp; {{ $e->extra_info }}</p> @endisset
                                        @include('layouts.tracking.tracking_complete')

                                        @if(isset($e->video_name) and $e->video_name != null and $e->video_name != '')
                                            <video title="Video" allowfullscreen controls class="ratio ratio-16x9 mt-3 w-75">
                                                <source src="{{ asset('esl/public/storage/files') . "/" . $e->video_name }}">
                                            </video>
                                        @endif

                                        @if(isset($e->image_name) and $e->image_name != null and $e->image_name != '')
                                            <div class="row m-3">
                                                <img src="{{ asset('esl/public/storage/files'. "/" . $e->image_name) }}" class="img-fluid col-12 col-lg-8" alt="img">
                                            </div>
                                        @endif

                                        <form action="{{ route('tracking.store', ["$e->id", "$user->id"]) }}" method="POST" id="multiple_choice_form_{{ $e->id }}">
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
                                            @include('layouts.tracking.tracking_buttons', ['tracking' => $e->tracking, 'questions' => $e->questions, 'exercise_id' => $e->id, 'subtype' => $e->subtype])
                                        </form>
                                    </div>
                                </div>
                                @break
                            @case('fill_in_the_gaps')
                                <div class="tab-pane fade exercise-pane @if($loop->index == 0) show active @endif" id="{{ $e->exerciseType->underscore_name . $e->id }}" role="tabpanel" aria-labelledby="{{ $e->exerciseType->underscore_name . $e->id }}-tab">
                                    <div class="container">
                                        <h4>{{ $e->title }}</h4>
                                        <p class="text-secondary">{{ $e->description }}</p>
                                        @isset($e->instructions) <div class="text-dark">{!! $e->instructions !!}</div> @endisset
                                        @isset($e->translated_instructions) <div class="text-secondary">{!! $e->translated_instructions !!}</div> @endisset
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
                                <div class="tab-pane fade exercise-pane @if($loop->index == 0) show active @endif" id="{{ $e->exerciseType->underscore_name . $e->id }}" role="tabpanel" aria-labelledby="{{ $e->exerciseType->underscore_name . $e->id }}-tab">
                                    <div class="container">
                                        <h4>{{ $e->title }}</h4>
                                        <p class="text-secondary">{{ $e->description }}</p>
                                        @isset($e->instructions) <div class="text-dark">{!! $e->instructions !!}</div> @endisset
                                        @isset($e->translated_instructions) <div class="text-secondary">{!! $e->translated_instructions !!}</div> @endisset
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


{{-- Time spent on exercise --}}
<script>
    var startTime;

    function startTimer() {
        window.startTime = new Date().getTime();
    }
</script>

{{-- Helper function to transform milliseconds to minutes and seconds format --}}
<script>
    function millisToMinutesAndSeconds(millis) {
        var minutes = Math.floor(millis / 60000);
        var seconds = ((millis % 60000) / 1000).toFixed(0);
        return minutes + ":" + (seconds < 10 ? '0' : '') + seconds;
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

{{-- Feedback Visibility  --}}
<script>
    function setFeedbackHidden(value, exercise_id, questions) {
        questions.forEach(function (question) {
            const questionFeedback = document.getElementById(`question-feedback-container-${question.id}`);
            questionFeedback.hidden = value;
        });

        var exerciseFeedback = document.getElementById(`feedback-exercise-details-container-${exercise_id}`);
        exerciseFeedback.hidden = value;
    }
</script>

{{-- Get Response Data --}}
<script>
    function getResponseData(questions, exercise, type) {
        var answers = {};
        switch(type) {
        case 'drag_and_drop':
            answers = getDragAndDropResults(questions, exercise);
            break;
        case 'multiple_choice':
            answers = getMultipleChoiceResults(questions, exercise);
            break;
        case 'fill_in_the_gaps':
            if (exercise.subtype == 2) {
                answers = getFillInTheGapsResults(questions, exercise);
            } else {
                answers = getDictationClozeResults(questions, exercise);
            }
            break;
        case 'open_ended':
            answers = getOpenEndedResults(questions, exercise);
            break;
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

        if (type != 'form' && answers.responses.length > 0) {
            answers.responses.forEach(function (item){
                var responseItem = document.createElement('input');
                responseItem.setAttribute('value', `${item.response}`);
                responseItem.setAttribute('name', `responses[${item.id}]`);
                responseItem.hidden = true;

                form.appendChild(responseItem);
            });
        }
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
                if (document.getElementById(`${alternative.value}-explanatory`) != null) {
                    document.getElementById(`${alternative.value}-explanatory`).hidden = true;
                }
            });

            alternatives.forEach((alternative) => {
                // Alternativa correcta
                if (alternative.checked && question.correct_answer == alternative.value) {
                    responses.push({'id': `${question.id}`, 'response': `${question.correct_answer}`});
                    
                    if(exercise.subtype != 99 && exercise.subtype != 991) {
                        if(question.personal_response == null || !question.personal_response) {
                            document.getElementById(`question-${question.id}-feedback-correct`).hidden = false;
                            document.getElementById(`question-${question.id}-feedback-wrong`).hidden = true;
                        } else {
                            document.getElementById(`question-${question.id}-feedback-correct`).hidden = false;
                            document.getElementById(`question-${question.id}-feedback-wrong`).hidden = true;
                        }
                    }
                    correct_questions += 1;
                // Alternativa incorrecta
                } else if(alternative.checked) {
                    if(exercise.subtype != 99 && exercise.subtype != 991) {
                        if(question.personal_response == null || !question.personal_response) {
                            document.getElementById(`question-${question.id}-feedback-wrong`).hidden = false;
                            document.getElementById(`question-${question.id}-feedback-correct`).hidden = true;
                        } else {
                            document.getElementById(`question-${question.id}-feedback-correct`).hidden = false;
                            document.getElementById(`question-${question.id}-feedback-wrong`).hidden = true;
                            correct_questions += 1;
                        }
    
                        if (document.getElementById(`${alternative.value}-explanatory`) != null) {
                            document.getElementById(`${alternative.value}-explanatory`).hidden = false;
                        }
                    }

                    responses.push({'id': `${question.id}`, 'response': `${alternative.parentNode.children[1].innerHTML.trim()}`});
                }
            });
        });

        wrong_questions = questions_number - correct_questions;

        if (document.getElementsByClassName(`show-on-all-correct-${exercise.id}`).length != 0) {
            var shortMessageB = document.getElementsByClassName(`show-on-all-correct-${exercise.id}`)[0];
            
            if (questions_number == correct_questions) {
                shortMessageB.hidden = false;
            } else {
                shortMessageB.hidden = true;
            }
        }

        if (document.getElementsByClassName(`show-on-any-wrong-${exercise.id}`).length != 0) {
            var shortMessageC = document.getElementsByClassName(`show-on-any-wrong-${exercise.id}`)[0];
            
            if (questions_number != correct_questions) {
                shortMessageC.hidden = false;
            } else {
                shortMessageC.hidden = true;
            }
        }

        console.log(exercise.subtype);
        if(exercise.subtype != 99 && exercise.subtype != 991 && question.personal_response != true) {
            var correctAnswersItem = document.getElementById(`feedback-exercise-correct-${exercise.id}`);
            var wrongAnswersItem = document.getElementById(`feedback-exercise-wrong-${exercise.id}`);
            correctAnswersItem.innerHTML = `<strong>${correct_questions}</strong>  ✅`;
            correctAnswersItem.hidden = false;
            wrongAnswersItem.innerHTML = `<strong>${wrong_questions}</strong>  ❌`;
            wrongAnswersItem.hidden = false;

            setFeedbackHidden(false, exercise.id, questions);
        }

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

            if(final_responses == correct_words) {
                document.getElementById(`question-${question.id}-feedback-correct`).hidden = false;
                document.getElementById(`question-${question.id}-feedback-wrong`).hidden = true;
                correct_questions += 1;
            } else {
                document.getElementById(`question-${question.id}-feedback-correct`).hidden = true;
                document.getElementById(`question-${question.id}-feedback-wrong`).hidden = false;
            }
        });

        wrong_questions = questions_number - correct_questions;

        if (document.getElementsByClassName(`show-on-all-correct-${exercise.id}`).length != 0) {
            var shortMessageB = document.getElementsByClassName(`show-on-all-correct-${exercise.id}`)[0];
            
            if (questions_number == correct_questions) {
                shortMessageB.hidden = false;
            } else {
                shortMessageB.hidden = true;
            }
        }

        if (document.getElementsByClassName(`show-on-any-wrong-${exercise.id}`).length != 0) {
            var shortMessageC = document.getElementsByClassName(`show-on-any-wrong-${exercise.id}`)[0];
            
            if (questions_number != correct_questions) {
                shortMessageC.hidden = false;
            } else {
                shortMessageC.hidden = true;
            }
        }

        correctAnswersItem = document.getElementById(`feedback-exercise-correct-${exercise.id}`);
        wrongAnswersItem = document.getElementById(`feedback-exercise-wrong-${exercise.id}`);
        correctAnswersItem.innerHTML = `<strong></strong> ${correct_questions}  ✅`;
        wrongAnswersItem.innerHTML = `<strong></strong> ${wrong_questions}  ❌`;
        correctAnswersItem.hidden = false;
        wrongAnswersItem.hidden = false;

        setFeedbackHidden(false, exercise.id, questions);

        return { 'correct': correct_questions, 'wrong': wrong_questions, 'responses': responses };
    }
</script>

{{--  Dictation Cloze questions --}}
<script>
    function getDictationClozeResults(questions, exercise) {
        var correct_questions = 0;
        var wrong_questions = 0;
        var questions_number = 0;
        var responses = [];

        questions.forEach(function (question) {
            var correct_words = question.answer;
            var answers = document.getElementsByName(`answer-${question.id}`);
            var question_responses = [];
            var correct_answer = question.answer.split(",");

            answers.forEach(function (answer) {
                if (question.answer.includes(`${answer.value}`) && answer.value != "") {
                    answer.style.setProperty('border-color', 'lime', 'important');
                    correct_questions += 1;
                } else if (!question.answer.includes(`${answer.value}`)) {
                    answer.style.setProperty('border-color', 'red', 'important');
                }

                question_responses.push(answer.value);
            });

            questions_number = answers.length;

            const final_responses = question_responses.join(',');
            responses.push({'id': `${question.id}`, 'response': `${final_responses}` });
        });

        wrong_questions = questions_number - correct_questions;

        if (document.getElementsByClassName(`show-on-all-correct-${exercise.id}`).length != 0) {
            var shortMessageB = document.getElementsByClassName(`show-on-all-correct-${exercise.id}`)[0];
            
            if (questions_number == correct_questions) {
                shortMessageB.hidden = false;
            } else {
                shortMessageB.hidden = true;
            }
        }

        if (document.getElementsByClassName(`show-on-any-wrong-${exercise.id}`).length != 0) {
            var shortMessageC = document.getElementsByClassName(`show-on-any-wrong-${exercise.id}`)[0];
            
            if (questions_number != correct_questions) {
                shortMessageC.hidden = false;
            } else {
                shortMessageC.hidden = true;
            }
        }

        correctAnswersItem = document.getElementById(`feedback-exercise-correct-${exercise.id}`);
        wrongAnswersItem = document.getElementById(`feedback-exercise-wrong-${exercise.id}`);
        correctAnswersItem.innerHTML = `<strong></strong> ${correct_questions}  ✅`;
        wrongAnswersItem.innerHTML = `<strong></strong> ${wrong_questions}  ❌`;
        correctAnswersItem.hidden = false;
        wrongAnswersItem.hidden = false;

        var exerciseFeedback = document.getElementById(`feedback-exercise-details-container-${exercise.id}`);
        exerciseFeedback.hidden = false;

        toggleTryAgainButton("disabled", exercise.id);

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

            if (document.getElementById(`question-${question.id}-feedback-correct`) != null) {
                document.getElementById(`question-${question.id}-feedback-correct`).hidden = false;
            }
        });

        if (document.getElementsByClassName(`show-on-all-correct-${exercise.id}`).length != 0) {
            var shortMessageB = document.getElementsByClassName(`show-on-all-correct-${exercise.id}`)[0];
            
            if (questions_number == correct_questions) {
                shortMessageB.hidden = false;
            } else {
                shortMessageB.hidden = true;
            }
        }

        if (document.getElementsByClassName(`show-on-any-wrong-${exercise.id}`).length != 0) {
            var shortMessageC = document.getElementsByClassName(`show-on-any-wrong-${exercise.id}`)[0];
            
            if (questions_number != correct_questions) {
                shortMessageC.hidden = false;
            } else {
                shortMessageC.hidden = true;
            }
        }

        setFeedbackHidden(false, exercise.id, questions);

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

            if (exercise.subtype != 991 && exercise.subtype != 99) {
                if (definitionContainer.contains(wordContainer)) {
                    document.getElementById(`question-${question.id}-feedback-correct`).hidden = false;
                    document.getElementById(`question-${question.id}-feedback-wrong`).hidden = true;
                    correct_questions += 1;
                } else {
                    document.getElementById(`question-${question.id}-feedback-correct`).hidden = true;
                    document.getElementById(`question-${question.id}-feedback-wrong`).hidden = false;
                    wrong_questions +=1;
                }
            }
        });

        if (exercise.subtype != 991 && exercise.subtype != 99) {

            wrong_questions = questions_number - correct_questions;

            if (document.getElementsByClassName(`show-on-all-correct-${exercise.id}`).length != 0) {
                var shortMessageB = document.getElementsByClassName(`show-on-all-correct-${exercise.id}`)[0];
                
                if (questions_number == correct_questions) {
                    shortMessageB.hidden = false;
                } else {
                    shortMessageB.hidden = true;
                }
            }

            if (document.getElementsByClassName(`show-on-any-wrong-${exercise.id}`).length != 0) {
                var shortMessageC = document.getElementsByClassName(`show-on-any-wrong-${exercise.id}`)[0];
                
                if (questions_number != correct_questions) {
                    shortMessageC.hidden = false;
                } else {
                    shortMessageC.hidden = true;
                }
            }

            correctAnswersItem = document.getElementById(`feedback-exercise-correct-${exercise.id}`);
            wrongAnswersItem = document.getElementById(`feedback-exercise-wrong-${exercise.id}`);
            correctAnswersItem.innerHTML = `<strong></strong> ${correct_questions}  ✅`;
            wrongAnswersItem.innerHTML = `<strong></strong> ${wrong_questions}  ❌`;
            correctAnswersItem.hidden = false;
            wrongAnswersItem.hidden = false;
        

            setFeedbackHidden(false, exercise.id, questions);
        }

        return { 'correct': correct_questions, 'wrong': wrong_questions, 'responses': responses }
    }
</script>

{{-- Resets the exercise's feedback and answers --}}
<script>
    function resetExercise(exercise_id, questions) {
        var elements = document.getElementsByClassName(`multiple-choice-${exercise_id}-check`);
        for (let element of elements) {
            element.checked = false;
        }
        
        setFeedbackHidden(true, exercise_id, questions);
    }
</script>

<script>
    function presentModal(feedback_message, status_message, url, type, current_exercise_url) {
        var modalContainer = document.createElement('div');
        modalContainer.setAttribute('class', 'modal fade');
        modalContainer.setAttribute('id', 'alert-modal');
        modalContainer.setAttribute('tabindex', '-1');
        modalContainer.setAttribute('aria-labelledby', 'alert-modal');
        modalContainer.setAttribute('aria-hidden', 'true');

        var modalDialog = document.createElement('div');
        modalDialog.setAttribute('class', 'modal-dialog modal-dialog-centered');

        var modalContent = document.createElement('div');
        modalContent.setAttribute('class', 'modal-content');

        var modalBody = document.createElement('div');
        modalBody.setAttribute('class', 'modal-body');

        var modalMessageContainer = document.createElement('div');
        modalMessageContainer.setAttribute('class', 'p-2');

        var messageText = document.createElement('p');
        messageText.setAttribute('class', 'text-center text-success');
        messageText.setAttribute('id', 'alert-modal-message');
        messageText.innerHTML = `${feedback_message}`;

        var statusMessage = document.createElement('h4');
        statusMessage.setAttribute('class', 'text-center text-dark');
        statusMessage.setAttribute('id', 'alert-modal-message');
        statusMessage.innerHTML = `${status_message}`;
        
        var statusButtonContainer = document.createElement('div');
        statusButtonContainer.setAttribute('class', 'd-flex justify-content-center p-2');

        var statusButton = document.createElement('button');
        statusButton.setAttribute('class', 'text-center btn btn-primary btn-sm');
        statusButton.setAttribute('type', 'button');
        statusButton.setAttribute('onclick', `goTo('${url}', '${type}', '${current_exercise_url}')`);

        if(type == 'section') {
            statusButton.innerHTML = `Next stage`;
        } else {
            statusButton.innerHTML = `Next ${type}`;
        }

        statusButtonContainer.appendChild(statusButton);
        modalMessageContainer.appendChild(messageText);
        modalMessageContainer.appendChild(statusMessage);
        modalMessageContainer.appendChild(statusButtonContainer);
        modalBody.appendChild(modalMessageContainer);
        modalContent.appendChild(modalBody);
        modalDialog.appendChild(modalContent);
        modalContainer.appendChild(modalDialog);

        if (document.getElementById("alert-modal") != null) {
            var modal = document.getElementById("alert-modal");
            modal.remove();
        }

        document.getElementsByTagName('body')[0].appendChild(modalContainer);

        $(function() {
            $("#alert-modal").modal("show");
        });
    }

    function checkAction(exercise, questions, type, exercise_id, user_id, route) {
        getResponseData(questions, exercise, type);

        event.preventDefault();
        $.ajax({
            url: `${route}`,
            type: 'post',
            data: $(`#${type}_form_${exercise_id}`).serialize(), // Remember that you need to have your csrf token included
            dataType: 'json',
            success: function( _response ) {
                const current_exercise_url = `${type}${exercise.id}`;
                console.log(_response);
                presentModal(_response.feedback_message, _response.status_message, _response.navigation_url, _response.navigation_type, current_exercise_url);
            },
            error: function( _response ) {
                console.log(_response);
            }
        });
    }
</script>

<script>
    function goTo(uri, type, current_exercise_url) {
        if (type == 'unit') {
            console.log(uri);

            if (uri != "") {
                window.location.href = `${uri}`;
            } else {
                window.location.reload();
            }
        } 
        if (type == 'section') {
            var wantedTabButton = document.querySelector(`button#${uri}-tab`);
            var activeTabButton = document.querySelector(`button.${type}-btn.active`);

            var wantedTabPane = document.querySelector(`div#${uri}`);
            var activeTabPane = document.querySelector(`div.${type}-pane.active`);

            activeTabButton.classList.remove('active');
            wantedTabButton.classList.add('active');

            activeTabPane.classList.remove('active');
            activeTabPane.classList.remove('show');
            wantedTabPane.classList.add('show');
            wantedTabPane.classList.add('active');

            wantedTabButton.click();
        }

        if (type == 'exercise') {
            console.log(current_exercise_url);

            var wantedTabButton = document.querySelector(`button#${uri}-tab`);
            var activeTabButton = document.querySelector(`button#${current_exercise_url}-tab`);

            var wantedTabPane = document.querySelector(`div#${uri}`);
            var activeTabPane = document.querySelector(`div#${current_exercise_url}`);

            activeTabButton.classList.remove('active');
            wantedTabButton.classList.add('active');

            activeTabPane.classList.remove('active');
            activeTabPane.classList.remove('show');
            wantedTabPane.classList.add('show');
            wantedTabPane.classList.add('active');

            wantedTabButton.click();
        }

        $('#alert-modal').modal('hide')
    }
</script>

@endsection