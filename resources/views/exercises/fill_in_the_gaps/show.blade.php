@extends('layouts.app')
@section('main')

<div class="container">
    <div class="d-flex justify-content-between mt-2 p-2">
        <h2>Fill in the gaps activity</h2>
        <a href="{{ route('exercises.index', $exercise->section->unit_id) }}" class="btn btn-link">Go back</a>
    </div>

    <div class="card p-4 m-2">
        <div class="row">
            <h4 class="col-10 col-md-11">Activity Details</h4>
            <button type="button" id="add_{{ $exercise->exerciseType->underscore_name }}_button" class="btn btn-sm btn-warning col-2 col-md-1" data-bs-toggle="modal" data-bs-target="#add_{{ $exercise->exerciseType->underscore_name}}_exercise_modal">Edit</button>
            @include('modals.exercises.edit', ['section' => $exercise->section, 'type' => $exercise->exerciseType])
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
        @isset($exercise->extra_info)<p class="text-info">Additional Information: {{ $exercise->extra_info }}</p>@endisset
        @isset($exercise->instructions)<p>Instructions: {{ $exercise->instructions }}</p>@endisset
        @isset($exercise->translated_instructions)<p>Translated Instructions: {{ $exercise->translated_instructions }}</p>@endisset
    </div>

    <div class="card p-4 m-2">
        <h4>Activity questions</h4>
        @forelse($exercise->questions as $question)
            @php $question_number = $loop->index + 1; @endphp
            <div class="card mt-1 mb-1 p-3">
                <div class="row">
                    @if($exercise->subtype == 1)
                        <div class="col-12 col-md-12">
                            <p>{{ $question_number }}. &nbsp;</p>
                            @php
                            $sentence = $question->statement;
                            $sentence_words = explode(' ', $sentence);
                            $words = explode(',', $question->answer);
                            $count = 0;
                            
                            if (count($words) > 0 and $sentence_words > 0)
                            {
                                foreach($sentence_words as $key=>$word) 
                                {
                                    if($word == ";;")
                                    {
                                        $sentence_words[$key] = "<strong class='text-primary border-primary ms-2 me-2 d-inline'>&nbsp;".$words[$count]."&nbsp;</strong>";
                                        $count += 1;
                                    }
                                }
                                $result = implode(' ', $sentence_words);
                            }
                            else
                            {
                                $result = "";
                            }

                            @endphp

                            <p style="white-space: pre-wrap;">{!! $result !!}</p>
                        </div>
                        <div class="col-12 col-md-12">
                            <audio controls>
                                <source src="{{ asset('esl/public/storage/files/'.$question->audio_name) }}" type="audio/mpeg">
                            </audio> 
                        </div>
                        <div class="col-12 col-md-2 mt-2 mt-md-0 justify-content-end">
                            <button type="button" id="delete_question_button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#delete_question_{{ $question->id }}">
                                <i class="mdi mdi-delete"></i>
                            </button>
                            @include('modals.questions.delete_confirmation', ['title' => 'Confirmation request', 'body' => "Please confirm you want to delete question number $question_number.", 'button_target_id' => "delete_question_$question->id", 'route' => route('questions.destroy', [$exercise->id, $question->id])])
                            <button type="button" id="edit_question_button" class="btn btn-sm btn-warning ms-1" data-bs-toggle="modal" data-bs-target="#edit_question_{{ $question->id }}">
                                <i class="mdi mdi-pencil"></i>
                            </button>
                            @include('modals.questions.edit', ['button_target_id' => "edit_question_$question->id", 'alternatives' => $question->alternatives])
                        </div>
                    @elseif($exercise->subtype == 2)
                        @php $statements = explode(";;", $question->statement) @endphp
                        <div class="col-12 col-md-10 d-flex">
                            <p>{{ $question_number }}. &nbsp;</p>
                            <p style="height: 20px;"> {{ $statements[0] }} </p>
                            
                            <input style="height: 20px; width: 100px; text-align: center; border-bottom: solid 0.7px lightgrey; border-top: none; border-left: none; border-right: none;" class="ms-2 me-2 text-primary fw-bold" type="text" value="{{ $question->answer }}" disabled>

                            <p style="height: 20px;">{{ $statements[1] }}</p>
                        </div>
                        <div class="col-12 col-md-2 mt-5 mt-md-0 d-flex justify-content-end">
                            <button type="button" id="delete_question_button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#delete_question_{{ $question->id }}">
                                <i class="mdi mdi-delete"></i>
                            </button>
                            @include('modals.questions.delete_confirmation', ['title' => 'Confirmation request', 'body' => "Please confirm you want to delete question number $question_number.", 'button_target_id' => "delete_question_$question->id", 'route' => route('questions.destroy', [$exercise->id, $question->id])])
                            <button type="button" id="edit_question_button" class="btn btn-sm btn-warning ms-1" data-bs-toggle="modal" data-bs-target="#edit_question_{{ $question->id }}">
                                <i class="mdi mdi-pencil"></i>
                            </button>
                            @include('modals.questions.edit', ['button_target_id' => "edit_question_$question->id", 'alternatives' => $question->alternatives])
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
        <a class="btn btn-primary m-1" href="{{ route('exercises.index', [$exercise->section->unit_id]) }}">Done</a>
    </div>
</div>

@include('modals.questions.add')

@endsection