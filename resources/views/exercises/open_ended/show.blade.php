@extends('layouts.app')
@section('main')

<div class="container">
    <div class="d-flex justify-content-between mt-2 p-2">
        <h2>Open Ended activity</h2>
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
        @elseif($exercise->subtype == '991')
            <p>Subtype: Metacognition (Table styled drag and drop)</p>
        @endif
        @isset($exercise->extra_info)<p class="text-info">Additional Information: {{ $exercise->extra_info }}</p>@endisset
        @include('modals.exercises.edit', ['section' => $exercise->section, 'type' => $exercise->exerciseType])
    </div>

    <div class="card p-4 m-2">
        <h4>Activity questions</h4>
        @forelse($exercise->questions as $question)
            @php $question_number = $loop->index + 1; @endphp
            <div class="card mt-1 mb-1 ps-4 pe-4 pt-3 pb-2">
                @if ($exercise->subtype == '99' or $exercise->subtype == null or $exercise->subtype == 1 or $exercose->subtype == '')
                        <div class="row">
                            <div class="col-12">
                                <p>{{ $question_number }}. {{ $question->statement }}</p>
                            </div>
                        </div>
                @elseif ($exercise->subtype == '991')
                    <p>{{ $question_number }}. &nbsp;</p>
                    <h4>{{ $question->correct_answer }}</h4>
                    <table class="table table-bordered">
                        <thead>
                            <th>{{ $question->statement }}</th>
                            <th>{{ $question->answer }}</th>
                        </thead>
                        <tbody>
                            @for ($x = 0; $x <= $question->image_name; $x++)
                            <tr>
                                <td>
                                    <p></p>
                                </td>
                                <td>
                                    <p></p>
                                </td>
                            </tr>
                            @endfor
                        </tbody>
                    </table>
                @endif
                <div class="d-flex justify-content-end">
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