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
        @include('alerts.edit', ['section' => $exercise->section, 'type' => $exercise->exerciseType])
    </div>

    <div class="card p-4 m-2">
        <h4>Activity items</h4>
        @forelse($exercise->questions as $question)
        <div class="card mt-2 p-3 mb-1">
            <h6>{{ "Item " . $loop->index + 1 }} - {{ $question->correct_answer }}</h6>
            <table class="table table-bordered">
                <thead>
                    <th>
                        <p class="text-center">Statemenets</p>
                    </th>
                    <th>
                        <p class="text-center">{{ $question->statement }}</p>
                    </th>
                    @isset($question->answer)
                    <th>
                        <p class="text-center">{{ $question->answer }}</p>
                    </th>
                    @endisset                        
                </thead>
                <tbody>
                    @foreach($question->alternatives as $alt)
                    <tr>
                        <td>
                            <p class="text-center">
                                {{ $loop->index + 1 . ". " .  $alt->title }}
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
                <form action="{{ route('questions.destroy', [$exercise->id, $question->id] ) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger mt-1">
                        <i class="mdi mdi-delete"></i>
                    </button>
                </form>
            </div>
        </div>
        @empty
            <div class="text-center p-3">
                <p class="text-center text-secondary">No items added.</p>
            </div>
        @endforelse

        <div>
            <button type="button" id="addQuestionButton" class="btn btn-primary open-modal" data-bs-toggle="modal" data-bs-target="#addQuestionModal">Add question</button>
        </div>
    </div>

    <div class="d-flex justify-content-center">
        <a class="btn btn-secondary m-1" href="{{ route('exercises.index', [$exercise->section->unit_id]) }}">Save</a>
        <a class="btn btn-secondary m-1" href="{{ route('exercises.index', [$exercise->section->unit_id]) }}">Cancel</a>
    </div>
</div>

@include('exercises.modals.question_modal');

@endsection