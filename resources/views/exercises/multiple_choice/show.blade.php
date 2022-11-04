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
        @isset($exercise->extra_info)<p class="text-info">Additional Information: {{ $exercise->extra_info }}</p>@endisset
        @isset($exercise->instructions)<p>Instructions: {!! $exercise->instructions !!}</p>@endisset
        @isset($exercise->translated_instructions)<p>Translated Instructions: {!! $exercise->translated_instructions !!}</p>@endisset
        @include('modals.exercises.edit', ['section' => $exercise->section, 'type' => $exercise->exerciseType])
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
    </div>

    <div class="card p-4 m-2">
        <h4>Activity questions</h4>
        @forelse($exercise->questions as $question)
            @php $question_number = $loop->index + 1; @endphp

            @if($exercise->subtype == 1 or $exercise->subtype == 4 or $exercise->subtype == 99 or $exercise->subtype == 3)
                <div class="card mt-1 mb-1 p-4">
                    @if(isset($e->video_name) and $e->video_name != null)
                        <video title="Video" allowfullscreen controls>
                            <source src="{{ asset('esl/public/storage/files') . "/" . $e->video_name }}">
                        </video>
                    @endif
                    <div class="row">
                        <div class="col-12 col-md-10">
                            {!! $question->statement !!}
                            <ol type="a">
                                @foreach($question->alternatives as $alt)
                                    <li>
                                        @if($alt->correct_alt) <strong class="text-primary">{{ $alt->title }}</strong>
                                        @else {{ $alt->title }}
                                        @endif
                                    </li>
                                @endforeach
                            </ol>
                        </div>
                        <div class="col-12 col-md-2 d-flex justify-content-center">
                            <div>
                                <button type="button" id="add_feedback_button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#delete_exercise_modal">
                                    <i class="mdi mdi-delete"></i>
                                </button>
                            </button> 
                                </button>
                            </button> 
                                </button>
                                @include('modals.questions.delete_confirmation', ['title' => 'Confirmation request', 'body' => "Please confirm you want to delete $exercise->title exercise.", 'button_target_id' => 'delete_exercise_modal', 'route' => route('questions.destroy', [$exercise->id, $question->id])])
                                <button type="button" id="edit_question_button" class="btn btn-sm btn-warning ms-1" data-bs-toggle="modal" data-bs-target="#edit_question_{{ $question->id }}">
                                    <i class="mdi mdi-pencil"></i>
                                </button>
                                @include('modals.questions.edit', ['button_target_id' => "edit_question_$question->id", 'alternatives' => $question->alternatives])
                            </div>
                        </div>
                    </div>
                </div>
            @elseif($exercise->subtype == 2)
                <div class="card mt-1 mb-1 p-4">
                    <div class="row">
                        <div class="col-12 col-md-12">
                            @php
                                $correct_words = explode('/', $question->correct_answer);
                                $words = explode(' ', $question->statement);
                                
                                foreach($words as $key=>$word) {
                                    if($word == ";;" ) {
                                        $words[$key] = "<strong>_________</strong>";
                                    }
                                }

                                $final_string = implode(' ', $words);
                            @endphp
                            
                            <p>{!! $final_string !!}</p>
                            <ol type="a">
                                @forelse($question->alternatives as $alt)
                                    <li>
                                        @if($alt->correct_alt)
                                            <p><strong class="text-primary">{{ $alt->title }}</strong></p>
                                        @else
                                            <p>{{ $alt->title }}</p>
                                        @endif
                                    </li>
                                @empty
                                @endforelse
                            </ol>
                        </div>
                        <div class="row">
                            <audio controls style="width: 350px;">
                                <source src="{{ asset('esl/public/storage/files/'.$question->audio_name) }}" type="audio/mpeg">
                            </audio> 
                        </div>
                        <div class="col-12 col-md-2 d-flex justify-content-start mt-1">
                            <br>
                            <button type="button" id="delete_question_button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#delete_question_{{ $question->id }}">
                                <i class="mdi mdi-delete"></i>
                            </button>
                            @include('modals.questions.delete_confirmation', ['title' => 'Confirmation request', 'body' => "Please confirm you want to delete question number $question_number.", 'button_target_id' => "delete_question_$question->id", 'route' => route('questions.destroy', [$exercise->id, $question->id])])
                            <button type="button" id="edit_question_button" class="btn btn-sm btn-warning ms-1" data-bs-toggle="modal" data-bs-target="#edit_question_{{ $question->id }}">
                                <i class="mdi mdi-pencil"></i>
                            </button>
                            @include('modals.questions.edit', ['button_target_id' => "edit_question_$question->id", 'alternatives' => $question->alternatives])
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
        <a class="btn btn-primary m-1" href="{{ route('exercises.index', [$exercise->section->unit_id]) }}">Done</a>
    </div>
</div>

@include('modals.questions.add')

@endsection