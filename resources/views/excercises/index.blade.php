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
                @forelse($section->excercises as $excercise)
                    <tr>
                        <td class="col-2">
                            {{ $excercise->title }}
                        </td>
                        <td class="col-6">
                            {{ $excercise->description }}
                        </td>
                        <td class="col-2">
                            {{ $excercise->excerciseType->name }}
                        </td>
                        <td class="col-2">
                            <div class="d-flex">
                                <form action="{{ route("excercises.destroy", [$unit->id, $excercise->excercise_type_id, $excercise->id]) }}" method="POST">
                                    @method('DELETE')
                                    @csrf
                                    <button type="submit" class="btn-sm btn btn-danger"><i class="mdi mdi-delete" aria-hidden="true"></i></button>
                                </form>
    
                                <a href="{{ route("excercises.show", [$unit->id, $excercise->excerciseType->underscore_name, $excercise->section_id, $excercise->id]) }}" class="btn-sm btn btn-success me-1 ms-1"><i class="mdi mdi-magnify" aria-hidden="true"></i></a>
                            </div>
                        </td>
                    </tr>
                    @include('excercises.excercise_modal', ['section_id' => $excercise->section->id, 'type' => $excercise->excercise_type_id])
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
            <div class="mt-1 ms-1 me-1"><h6>Add excercise:</h6></div>

            <div class="ms-1 me-1">
                <button type="button" id="addPreListeningDragAndDropButton" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addDragAndDropExcerciseModal">
                    Drag and Drop
                </button>
            </div>
            <div class="ms-1 me-1">
                <button type="button" id="addPreListeningOpenEndedButton" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addOpenEndedExcerciseModal">
                    Open Ended
                </button>
            </div>
            <div class="ms-1 me-1">
                <button type="button" id="addPreListeningMultipleChoiceButton" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addMultipleChoiceExcerciseModal">
                    Multiple Choice
                </button>
            </div>
            <div class="ms-1 me-1">
                <button type="button" id="addPreListeningVoiceRecognitionButton" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addVoiceRecognitionExcerciseModal">
                    Voice Recognition
                </button>
            </div>
            <div class="ms-1 me-1">
                <button type="button" id="addPreListeningFillInTheGapsButton" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addPreListeningFillInTheGapsExcerciseModal">
                    Fill-in The Gaps
                </button>
            </div>
        </div>
        <div class="mt-3 d-flex justify-content-center">
            <div class="mt-1 ms-1 me-1"><h6>Add Metacognition:</h6></div>
            <div class="ms-1 me-1">
                <button type="button" id="addPreListeningDragAndDropButton" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#addDragAndDropExcerciseModal">Choosing</button>
            </div>
            <div class="ms-1 me-1">
                <button type="button" id="addPreListeningOpenEndedButton" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#addOpenEndedExcerciseModal">Open Ended</button>
            </div>
            <div class="ms-1 me-1">
                <button type="button" id="addPreListeningMultipleChoiceButton" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#addMultipleChoiceExcerciseModal">Form</button>
            </div>
            <div class="ms-1 me-1">
                <button type="button" id="addPreListeningVoiceRecognitionButton" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#addVoiceRecognitionExcerciseModal">Voice Recognition</button>
            </div>
        </div>

    </div>

    @endforeach
</div>

@endsection