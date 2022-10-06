@extends('layouts.app')
@section('main')

<div class="container">
    <div class="d-flex justify-content-between mt-2 p-2">
        <h2>Multiple choice activity</h2>
        <a href="{{ route('exercises.index', $exercise->section->unit_id) }}" class="btn btn-link">Go back</a>
    </div>

    <div class="card p-4 m-2">
        <div class="row">
            <h4 class="col-10 col-md-11">Activity Details</h4>
            <button type="button" id="add_{{ $exercise->exerciseType->underscore_name }}_button" class="btn btn-sm btn-warning col-2 col-md-1" data-bs-toggle="modal" data-bs-target="#add_{{ $exercise->exerciseType->underscore_name}}_exercise_modal">Edit</button>
        </div>
        <h5>Title: {{ $exercise->title }}</h5>
        <p>Description: {{ $exercise->description }}</p>
        @include('alerts.edit', ['section' => $exercise->section, 'type' => $exercise->exerciseType])
        <p>
            Subtype:
            @switch($exercise->subtype)
            @case(1)
                Predicting
                @break
            @case(2)
                What do you hear?
                @break
            @case(3)
                Evaluating Statements
                @break
            @case(4)
                Multiple choice
                @break
            @case(99)
                Metacognition
                @break
            @endswitch
        </p>
        @isset($exercise->extra_info)<p class="text-info">Additional Information: {{ $exercise->extra_info }}</p>@endisset
    </div>

    <div class="card p-4 m-2">
        <h4>Activity questions</h4>
        @forelse($exercise->questions as $question)
            @if($exercise->subtype == 1 || $exercise->subtype == 4)
                <div class="card mt-1 mb-1 p-4">
                    <div class="row">
                        <div class="col-12 col-md-10">
                            <p>Statements</p>
                            <ol type="I">
                                @php 
                                    $statements = explode(";", $question->statement);
                                @endphp
                                @foreach($statements as $statement)
                                <li>
                                    {{ $statement }}
                                </li>
                                @endforeach
                            </ol>
                            <p>Alternatives</p>
                            <ol type="a">
                                @foreach($question->alternatives as $alt)
                                <li>{{ $alt->title }}</li>
                                @endforeach
                            </ol>
                        </div>
                        <div class="col-12 col-md-2 d-flex justify-content-center">
                            <br>
                            <button type="button" id="add_feedback_button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#delete_exercise_modal">
                                <i class="mdi mdi-delete"></i>
                            </button> 
                            @include('alerts.confirmation', ['title' => 'Confirmation request', 'body' => "Please confirm you want to delete $exercise->title exercise.", 'button_target_id' => 'delete_exercise_modal', 'route' => route('questions.destroy', [$exercise->id, $question->id])])
                        </div>
                    </div>
                </div>
            @elseif($exercise->subtype == 2)
                <div class="card mt-1 mb-1 p-4">
                    <div class="row">
                        <div class="col-12 col-md-12">
                            @php
                                $alts = array();
                                foreach($question->alternatives as $alt)
                                {
                                    array_push($alts, $alt->title);
                                }

                                $statement_array = explode(" ", $question->statement);

                                $found_words = 0;
                                $final_word = "";

                                $words_to_add = array();
                                foreach($statement_array as $word)
                                {
                                    if($word == ";;" or $word == ";;." or $word == ";;," or $word == ";;!" or $word == ";;?")
                                    {   
                                        $new_word = $alts[$found_words];
                                        $final_word = $final_word . " " . "<strong class='text-primary'>$new_word</strong>";
                                        $found_words += 1;
                                    }

                                    $final_word = $final_word . " " . $word;
                                }

                                $final_word = str_replace([";;", ";;.", ";;,", ";;!", ";;?", "\n"], '', $final_word);
                            @endphp
                            
                            <p>{{ $loop->index + 1 . ". " }} {!! $final_word !!}</p>
                            <div class="col-12 mt-2 mb-1">
                                <p>Correct answer(s):</p>
                                <ul>
                                    @foreach(explode(";", $question->correct_answer) as $answer)
                                        <li>{{ $answer }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        {{ $question->audio_name }}
                        <div class="row">
                            <audio controls style="width: 350px;">
                                <source src="{{ asset('esl/public/storage/files/'.$question->audio_name) }}" type="audio/mpeg">
                            </audio> 
                        </div>
                        <div class="col-12 col-md-2 d-flex justify-content-start mt-1">
                            <br>
                            <button type="button" id="add_feedback_button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#delete_exercise_modal">
                                <i class="mdi mdi-delete"></i>
                            </button> 
                            @include('alerts.confirmation', ['title' => 'Confirmation request', 'body' => "Please confirm you want to delete $exercise->title exercise.", 'button_target_id' => 'delete_exercise_modal', 'route' => route('questions.destroy', [$exercise->id, $question->id])])
                        </div>
                    </div>
                </div>
            @elseif($exercise->subtype == 3)
                <div class="card mt-1 mb-1 p-4">
                    <div class="row">
                        <div class="col-12 col-md-10">
                            <p>Statement:</p>
                            <ul>
                                <li>
                                    <p>{{ $question->statement }}</p>
                                </li>
                            </ul>
                            <p>Correct answer:</p>
                            <ul>
                                @if(strtolower(trim($question->correct_answer)) == 'true')
                                    <li>
                                        <p class="text-primary"><strong>True</strong></p>
                                    </li>
                                    <li>
                                        <p class="text-primary">False</p>
                                    </li>
                                @elseif(strtolower(trim($question->correct_answer)) == 'false')
                                    <li>
                                        <p class="text-primary">True</p>
                                    </li>
                                    <li>
                                        <p class="text-primary"><strong>False</strong></p>
                                    </li>
                                @endif
                            </ul>
                        </div>
                        <div class="col-12 col-md-2 d-flex justify-content-center">
                            <br>
                            <button type="button" id="add_feedback_button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#delete_exercise_modal">
                                <i class="mdi mdi-delete"></i>
                            </button> 
                            @include('alerts.confirmation', ['title' => 'Confirmation request', 'body' => "Please confirm you want to delete $exercise->title exercise.", 'button_target_id' => 'delete_exercise_modal', 'route' => route('questions.destroy', [$exercise->id, $question->id])])
                        </div>
                    </div>
                </div>
            @endif
        @empty
            <div class="text-center p-3">
                <p class="text-center text-secondary">No questions added.</p>
            </div>
        @endforelse

        <div>
            <button type="button" id="addQuestionButton" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addQuestionModal">Add question</button>
        </div>
    </div>

    @if($exercise->subtype != '99' and $exercise->subtype != '991')
        @include('feedback.show')
    @endif

    <div class="d-flex justify-content-center">
        <a class="btn btn-secondary m-1" href="{{ route('exercises.index', [$exercise->section->unit_id]) }}">Save</a>
        <a class="btn btn-secondary m-1" href="{{ route('exercises.index', [$exercise->section->unit_id]) }}">Cancel</a>
    </div>
</div>

@include('exercises.modals.question_modal')

@endsection