@extends('layouts.app')
@section('main')

<div class="container">
    <div class="mt-2 p-2">
        <h2>Fill-in the gaps activity</h2>
    </div>

    <div class="card p-4 m-2">
        <div class="row">
            <h4 class="col-10 col-md-11">Activity Details</h4>
            <button type="button" id="add_{{ $exercise->exerciseType->underscore_name }}_button" class="btn btn-sm btn-warning col-2 col-md-1" data-bs-toggle="modal" data-bs-target="#add_{{ $exercise->exerciseType->underscore_name}}_exercise_modal">Edit</button>
            @include('alerts.edit', ['section' => $exercise->section, 'type' => $exercise->exerciseType])
        </div>
        <h5>Title: {{ $exercise->title }}</h5>
        <p>Description: {{ $exercise->description }}</p>
        <p>
            Subtype:
            @switch($exercise->subtype)
            @case(1)
                Dictation Cloze
                @break;
            @case(2)
                Vocabulary Practice
                @break;
            @endswitch
        </p>
    </div>

    <div class="card p-4 m-2">
        <h4>Activity questions</h4>
        @forelse($exercise->questions as $question)
            <div class="card mt-1 mb-1 p-3">
                <div class="row">
                    @if($exercise->subtype == 1)
                        <div class="col-12 col-md-12">
                            <p>{{ $loop->index + 1 }}. &nbsp;</p>
                            {{ $question }}
                            @php
                            $words = ["hola", "como", "estas", "bien", "tu"];
                            $semicolons = array();
                            
                            foreach($words as $word) { array_push($semicolons, ";;"); }

                            $value = str_replace([";;", ";;", ";;", ";;", ";;"], $words, $question->statement);
                            @endphp

                            <p>{{ $value }}</p>
                        </div>
                        <div class="col-12 col-md-12">
                            <audio controls>
                                <source src="{{ asset('storage/files/'.$question->audio_name) }}" type="audio/mpeg">
                            </audio> 
                        </div>
                        <div class="col-12 col-md-2 mt-2 mt-md-0 justify-content-end">
                            <br>
                            <button type="button" id="add_feedback_button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#delete_exercise_modal">
                                <i class="mdi mdi-delete"></i>
                            </button> 
                            <button class="btn btn-warning btn-sm ms-1">Edit</button>
                            @include('alerts.confirmation', ['title' => 'Confirmation request', 'body' => "Please confirm you want to delete $exercise->title exercise.", 'button_target_id' => 'delete_exercise_modal', 'route' => route('questions.destroy', [$exercise->id, $question->id])])
                        </div>
                    @elseif($exercise->subtype == 2)
                        @php $statements = explode(";;", $question->statement) @endphp
                        <div class="col-12 col-md-10 d-flex">
                            <p>{{ $loop->index + 1 }}. &nbsp;</p>
                            <p style="height: 20px;"> {{ $statements[0] }} </p>
                            
                            <input style="height: 20px; width: 100px; text-align: center; border-bottom: solid 0.7px lightgrey; border-top: none; border-left: none; border-right: none;" class="ms-2 me-2 text-primary fw-bold" type="text" value="{{ $question->answer }}" disabled>

                            <p>{{ $question->answer }}</p>

                            <p style="height: 20px;">{{ $statements[1] }}</p>
                        </div>
                        <div class="col-12 col-md-2 mt-5 mt-md-0 d-flex justify-content-end">
                            <br>
                            <button type="button" id="add_feedback_button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#delete_exercise_modal">
                                <i class="mdi mdi-delete"></i>
                            </button> 
                            <button class="btn btn-warning btn-sm ms-1">Edit</button>
                            @include('alerts.confirmation', ['title' => 'Confirmation request', 'body' => "Please confirm you want to delete $exercise->title exercise.", 'button_target_id' => 'delete_exercise_modal', 'route' => route('questions.destroy', [$exercise->id, $question->id])])
                        </div>
                    @endif

                </div>
            </div>
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