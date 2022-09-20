@extends('layouts.app')
@section('main')

<div class="container">
    <div class="mt-2 p-2">
        <h2>Multiple Choice questions activity</h2>
    </div>

    <div class="card p-4 m-2">
        <div class="row">
            <h4 class="col-11">Activity Details</h4>
            <button type="button" id="add_{{ $exercise->exerciseType->underscore_name }}_button" class="btn btn-sm btn-warning col-1" data-bs-toggle="modal" data-bs-target="#add_{{ $exercise->exerciseType->underscore_name}}_exercise_modal">Edit</button>
        </div>
        <h5>Title: {{ $exercise->title }}</h5>
        <p>Description: {{ $exercise->description }}</p>
        @include('alerts.edit', ['section' => $exercise->section, 'type' => $exercise->exerciseType])
        <p>
            Subtype: 
            @switch($exercise->subtype)
            @case(1)
                Predicting
                @break;
            @case(2)
                What do you hear?
                @break;
            @case(3)
                Evaluating Statements
                @break;
            @case(4)
                Multiple choice
                @break;
            @endswitch
        </p>
    </div>

    <div class="card p-4 m-2">
        <h4>Activity questions</h4>
        @forelse($exercise->questions as $question)
            @if($exercise->subtype == 1 || $exercise->subtype == 4)
                <div class="card mt-1 mb-1 p-4">
                    <div class="row">
                        <div class="col-10">
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
                        <div class="col-2 d-flex justify-content-center">
                            <br>
                            <button type="button" id="add_feedback_button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#delete_exercise_modal">
                                Delete
                            </button> 
                            <button class="btn btn-warning btn-sm m-1">Edit</button>
                            @include('alerts.confirmation', ['title' => 'Confirmation request', 'body' => "Please confirm you want to delete $exercise->title exercise.", 'button_target_id' => 'delete_exercise_modal', 'route' => route('questions.destroy', [$exercise->id, $question->id])])
                        </div>
                    </div>
                </div>
            @elseif($exercise->subtype == 2)
                <div class="card mt-1 mb-1 p-4">
                    <div class="row">
                        <div class="col-10">
                            @php 
                                $statements = explode(";;", $question->statement);
                                $alternatives = $question->alternatives
                            @endphp
                            <div class="d-flex">
                                <p>{{ $loop->index + 1 }}. &nbsp;</p>
                                @if($statements[0] != "" and $statements[0] != null)<p>{{ $statements[0] }}</p>@endif
                                <p class="text-primary">&nbsp;
                                    @if($alternatives[0]->correct_alt == true)
                                        <strong>{{ $alternatives[0]->title }}</strong>
                                        /
                                        {{ $alternatives[1]->title }}
                                    @elseif($alternatives[1]->correct_alt == true)
                                        {{ $alternatives[0]->title }}
                                        /
                                        <strong>{{ $alternatives[1]->title }}</strong>
                                    @endif
                                    &nbsp;
                                </p>
                                @if($statements[1] != "" and $statements[1] != null)<p>{{ $statements[1] }}</p>@endif
                            </div>
                        </div>
                        <div class="col-2 d-flex justify-content-center">
                            <br>
                            <button type="button" id="add_feedback_button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#delete_exercise_modal">
                                Delete
                            </button> 
                            <button class="btn btn-warning btn-sm m-1">Edit</button>
                            @include('alerts.confirmation', ['title' => 'Confirmation request', 'body' => "Please confirm you want to delete $exercise->title exercise.", 'button_target_id' => 'delete_exercise_modal', 'route' => route('questions.destroy', [$exercise->id, $question->id])])
                        </div>
                    </div>
                </div>
            @elseif($exercise->subtype == 3)
                <div class="card mt-1 mb-1 p-4">
                    <div class="row">
                        <div class="col-10">
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
                        <div class="col-2 d-flex justify-content-center">
                            <br>
                            <button type="button" id="add_feedback_button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#delete_exercise_modal">
                                Delete
                            </button> 
                            <button class="btn btn-warning btn-sm m-1">Edit</button>
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

    @include('feedback.show')

    <div class="d-flex justify-content-center">
        <a class="btn btn-secondary m-1" href="{{ route('exercises.index', [$exercise->section->unit_id]) }}">Save</a>
        <a class="btn btn-secondary m-1" href="{{ route('exercises.index', [$exercise->section->unit_id]) }}">Cancel</a>
    </div>
</div>

@include('exercises.modals.question_modal')

@endsection