@extends('layouts.app')
@section('main')

<div class="container">
    <div class="d-flex justify-content-between mt-2 p-2">
        <h2>Form activity</h2>
        <a href="{{ route('exercises.index', $exercise->section->unit_id) }}" class="btn btn-link">Go back</a>
    </div>

    <div class="card p-4 m-2">
        <div class="row">
            <h4 class="col-10 col-md-11">Activity Details</h4>
            <button type="button" id="add_{{ $exercise->exerciseType->underscore_name }}_button" class="btn btn-sm btn-warning col-2 col-md-1" data-bs-toggle="modal" data-bs-target="#add_{{ $exercise->exerciseType->underscore_name}}_exercise_modal">Edit</button>
        </div>
        <h5>Title: {{ $exercise->title }}</h5>
        <p>Description: {{ $exercise->description }}</p>
        @if($exercise->subtype == '99')
            <p>Subtype: Metacognition</p>
        @endif
        @isset($exercise->extra_info)<p class="text-info">Additional Information: {{ $exercise->extra_info }}</p>@endisset
        @isset($exercise->instructions)<p>Instructions: {!! $exercise->instructions !!}</p>@endisset
        @isset($exercise->translated_instructions)<p>Translated Instructions: {!! $exercise->translated_instructions !!}</p>@endisset
        @include('modals.exercises.edit', ['section' => $exercise->section, 'type' => $exercise->exerciseType])
    </div>

    <div class="card p-4 m-2">
        <h4>Activity items</h4>
        @forelse($exercise->questions as $question)
        <div class="card mt-2 p-3 mb-1">
            @php $question_number = $loop->index + 1;  @endphp
            <h6>{{ "Item " . $question_number }} - {{ $question->correct_answer }}</h6>
            @if(isset($question->exclusive_responses) and $question->exclusive_responses) 
            <p>Exclusive responses: True</p>
            @else
            <p>Exclusive responses: False</p>
            @endif
            <table class="table table-bordered">
                <thead>
                    <th>
                        <p class="text-center">{{ $question->heading_title }}</p>
                    </th>
                    <th>
                        <p class="text-center ms-2">{{ $question->statement }}</p>
                    </th>
                    @isset($question->answer)
                    <th>
                        <p class="text-center ms-2">{{ $question->answer }}</p>
                    </th>
                    @endisset                        
                </thead>
                <tbody>
                    @foreach($question->alternatives as $alt)
                    <tr>
                        <td>
                            <p>
                                {{ $alt->title }}
                            </p>
                        </td>
                        <td></td>
                        @isset($question->answer)
                        <td></td>
                        @endisset
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="d-flex justify-content-end">
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
        @empty
            <div class="text-center p-3">
                <p class="text-center text-secondary">No items added.</p>
            </div>
        @endforelse

        <div>
            <button type="button" id="addQuestionButton" class="btn btn-primary open-modal" data-bs-toggle="modal" data-bs-target="#addQuestionModal">Add question</button>
            @include('modals.questions.add')
        </div>
    </div>

    <div class="d-flex justify-content-center">
        <a class="btn btn-primary m-1" href="{{ route('exercises.index', [$exercise->section->unit_id]) }}">Done</a>
    </div>
</div>

@endsection