@extends('layouts.app')
@section('main')

<div class="container">
    <div class="m-2">
        <h2>{{ $unit->title . " Unit" }}</h2>
    </div>
    @foreach($unit->sections as $section)
    <div class="card p-4 m-4 shadow border-0">
        <div class="row">
            <div class="card-body d-flex justify-content-between">
                <div>
                    <h4>{{ $section->name }} section</h4>
                </div>
            </div>
        </div>

        <table class="table">
            <thead>
                <th>Activity title</th>
                <th>Description</th>
                <th>Type</th>
                <th>Actions</th>
            </thead>
            <tbody>
                @forelse($section->exercises as $exercise)
                    <tr>
                        <td class="col-2">
                            {{ $exercise->title }}
                        </td>
                        <td class="col-6">
                            {{ $exercise->description }}
                        </td>
                        <td class="col-2">
                            {{ $exercise->exerciseType->name }}
                        </td>
                        <td class="col-2">
                            <div class="d-flex">
                                <form action="{{ route("exercises.destroy", [$exercise->section->unit_id, $exercise->exercise_type_id, $exercise->id]) }}" method="POST">
                                    @method('DELETE')
                                    @csrf
                                    <button type="submit" class="btn-sm btn btn-danger"><i class="mdi mdi-delete" aria-hidden="true"></i></button>
                                </form>
    
                                <a href="{{ route("exercises.show", $exercise->id) }}" class="btn-sm btn btn-success me-1 ms-1"><i class="mdi mdi-magnify" aria-hidden="true"></i></a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td>
                            <p class="text-secondary">Nothing yet</p>  
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-3 d-flex justify-content-center">
            <div class="mt-1 ms-1 me-1"><h6>Add exercise:</h6></div>
            @forelse($types as $type)
            <div class="ms-1 me-1">
                <button type="button" id="add_{{ $type->underscore_name }}_button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#add_{{ $type->underscore_name}}_exercise_modal">
                    {{ $type->name }}
                </button>
                @include('exercises.modals.exercise_modal', ['section_id' => $exercise->section->id, 'type' => $type])
            </div>
            @empty
            @endforelse
        </div>
        <div class="mt-3 d-flex justify-content-center">
            <div class="mt-1 ms-1 me-1"><h6>Add Metacognition:</h6></div>
            <div class="ms-1 me-1">
                <button type="button" id="addPreListeningDragAndDropButton" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#addDragAndDropExerciseModal">Choosing</button>
            </div>
            <div class="ms-1 me-1">
                <button type="button" id="addPreListeningOpenEndedButton" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#addOpenEndedExerciseModal">Open Ended</button>
            </div>
            <div class="ms-1 me-1">
                <button type="button" id="addPreListeningMultipleChoiceButton" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#addMultipleChoiceExerciseModal">Form</button>
            </div>
            <div class="ms-1 me-1">
                <button type="button" id="addPreListeningVoiceRecognitionButton" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#addVoiceRecognitionExerciseModal">Voice Recognition</button>
            </div>
        </div>

    </div>

    @endforeach
</div>

@endsection