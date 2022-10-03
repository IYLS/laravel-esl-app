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
        <div class="col-12 col-lg-4">
            <small class="text-secondary">Keywords:</small>
            @foreach($keywords as $keyword)
            @php $modal_id = "keywordModal"; @endphp
            <button type="button" id="{{ $modal_id . "Button" }}" class="mt-1 btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#{{ $modal_id }}">{{ $keyword->keyword }}</button>
            @include('modals.keywords.show', ['modal_id' => $modal_id, 'description' => $keyword->description, 'modal_title' => $keyword->keyword])
            @endforeach
        </div>
        <div class="col-12 col-lg-8">
            @include('exercises.help_options', ['unit' => $unit])
        </div>
    </div>
    <div class="row" id="keywords_content">
        <div class="col-4" id="keywords_detail"></div>
        <div class="col-8" id="help_option_detail"></div>
    </div>

    {{-- Video section --}}
    <div class="col-12 col-xl-5">
        <div class="ratio ratio-16x9 mt-3">
            <iframe src="{{ asset('/storage/files') . "/" . $unit->video_name }}" title="Video" allowfullscreen controls></iframe>
        </div>
    </div>

    {{-- Exercises and content section --}}
    <div class="col-12 col-xl-7 bg-light mt-2 p-3 rounded shadow">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            @foreach($unit->sections as $section)
                <li class="nav-item" role="presentation">
                    @if($loop->index == 0)
                        <button class="nav-link active" id="{{ $section->underscore_name }}-tab" onclick="hideFeedback()" data-bs-toggle="tab" data-bs-target="#{{ $section->underscore_name}}" type="button" role="tab" aria-controls="{{ $section->underscore_name }}" aria-selected="true">{{ $section->name }}</button>
                    @else
                        <button class="nav-link" id="{{ $section->underscore_name }}-tab" onclick="hideFeedback()" data-bs-toggle="tab" data-bs-target="#{{ $section->underscore_name}}" type="button" role="tab" aria-controls="{{ $section->underscore_name }}" aria-selected="false">{{ $section->name }}</button>
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
                    <div class="nav flex-column nav-pills col-12 col-xl-2" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        @foreach($section->exercises as $e)
                            <button class="nav-link @if($e->subtype == 99) meta @endif" id="{{ $e->exerciseType->underscore_name . $e->id }}-tab" data-bs-toggle="pill" data-bs-target="#{{ $e->exerciseType->underscore_name . $e->id }}" type="button" role="tab" aria-controls="{{ $e->exerciseType->underscore_name . $e->id }}" aria-selected="false" onclick="hideFeedback()">{{ $e->title }}</button>
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
                                @include('exercises.drag_and_drop.dds')
                                @break
                            @case('open_ended')
                                @include('exercises.open_ended.subtype')
                                @break
                            @case('voice_recognition')
                                @include('exercises.voice_recognition.asd')
                                @break
                            @case('multiple_choice')
                                <div class="tab-pane fade" id="{{ $e->exerciseType->underscore_name . $e->id }}" role="tabpanel" aria-labelledby="{{ $e->exerciseType->underscore_name . $e->id }}-tab">
                                    <div class="container">
                                        <h4>{{ $e->title }}</h4>
                                        <p class="text-secondary">{{ $e->description }}</p>

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
                                        @elseif($e->subtype == 4)
                                            @include('exercises.multiple_choice.multiple_choice')
                                        @endif
                                    </div>
                                </div>
                                @break
                            @case('fill_in_the_gaps')
                                <div class="tab-pane fade" id="{{ $e->exerciseType->underscore_name . $e->id }}" role="tabpanel" aria-labelledby="{{ $e->exerciseType->underscore_name . $e->id }}-tab">
                                    <div class="container">
                                        <h4>{{ $e->title }}</h4>
                                        <p class="text-secondary">{{ $e->description }}</p>

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
                                        <p class="text-secondary">{{ $e->title }}</p>

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

    function strikeWord(item) {
        if(!item.classList.contains('strikable')) {
            item.classList.add('strikable');
            item.classList.add('bg-warning');
        } else {
            item.classList.remove('strikable');
            item.classList.remove('bg-warning');
        }
    }

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

<script>
    function getMultipleChoiceResults(questions, exercise_id) {
        var correct_questions = 0;
        var wrong_questions = 0;
        var questions_number = questions.length;

        questions.forEach(function (question) {
            console.log(question);
            const alternatives = document.getElementsByName(`question-${question.id}`);
            alternatives.forEach((alternative) => {
                if (alternative.checked && question.correct_answer == alternative.value) correct_questions += 1;
            });
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

@endsection