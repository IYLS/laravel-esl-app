@extends('layouts.app')
@section('main')

<div class="container">
    <div class="row d-flex align-items-center">
        <div class="mt-3 mb-1 col-10">
            <h3>{{ $unit->title }}</h3>
        </div>
        <div class="col-2">
            <a href="{{ route('units.show', $unit->id) }}">
                Go back
            </a>
        </div>
    </div>
    @forelse($unit->sections as $section)
        <div class="card p-4 m-4 shadow border-0">
            <div class="row">
                <div class="card-body d-flex justify-content-between">
                    <div>
                        <h4>{{ $section->name }} section</h4>
                        <p>{{ $section->instructions }}</p>
                    </div>
                </div>
            </div>

            <table class="table">
                <thead>
                    <th class="d-none d-md-table-cell">#</th>
                    <th>Activity title</th>
                    <th class="d-none d-md-table-cell">Description</th>
                    <th class="d-none d-md-table-cell">Type</th>
                    <th class="d-none d-md-table-cell">Position</th>
                    <th>Actions</th>
                </thead>
                <tbody>
                    @forelse($section->exercises->sortBy('position') as $exercise)
                        <tr @if($exercise->subtype == 99 or $exercise->subtype == 991) style="background-color: #5fde72;" @endif>
                            <td class="col-1">
                                {{ $loop->index+1 }}.
                            </td>
                            <td class="col-1">
                                {{ $exercise->title }}
                            </td>
                            <td class="col-7 d-none d-md-table-cell">
                                {{ $exercise->description }}
                            </td>
                            <td class="col-2 d-none d-md-table-cell">
                                {{ $exercise->exerciseType->name }}
                            </td>
                                @csrf
                                <td class="col-1 d-none d-md-table-cell">
                                    <form action="{{ route('exercises.position', ["$unit->id", "$exercise->id"]) }}" method="POST">
                                        @csrf
                                        <select class="form-select" name="position" id="position" onchange="this.form.submit()">
                                            @forelse($section->exercises as $e)
                                                <option value="{{ $loop->index + 1 }}" @if($exercise->position == $loop->index+1) selected @endif>{{ $loop->index + 1 }}</option>
                                            @empty
                                                <p class="text-secondary text-center"><small>No exercises to sort.</small></p>
                                            @endforelse
                                        </select>
                                    </form>
                                </td>
                            <td class="col-1">
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
                            <td colspan="4 mt-3 mb-3">
                                <p class="text-secondary text-center"><small>Nothing yet</small></p>  
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="row">
                <div class="col-6 d-flex justify-content-center">
                    <button class="btn btn-primary btn-sm col-12 col-md-4 mt-2" data-bs-toggle="collapse" href="#collapsableAddExercise{{ $section->id }}" role="button" aria-expanded="false" aria-controls="collapsableAddExercise{{ $section->id }}">Add exercise <i class="mdi mdi-arrow-down"></i></button>
                </div>

                <div class="col-6 d-flex justify-content-center">
                    <button class="btn btn-success btn-sm col-12 col-md-4 mt-2" data-bs-toggle="collapse" href="#collapsableAddMetacognition{{ $section->id }}" role="button" aria-expanded="false" aria-controls="collapsableAddMetacognition{{ $section->id }}">Add metacognition  <i class="mdi mdi-arrow-down"></i></button>
                </div>

                <div class="col-6 d-flex justify-content-center">
                    <div class="collapse" id="collapsableAddExercise{{ $section->id }}">
                        @forelse($types as $type)
                            <div>
                                <button type="button" id="add_{{ $type->underscore_name }}_button" class="btn btn-sm btn-primary mt-1" data-bs-toggle="modal" data-bs-target="#add_{{ $type->underscore_name}}_exercise_modal_{{ $section->id }}">
                                    {{ $type->name }}
                                </button>
                                @include('modals.exercises.add', ['section_id' => $section->id, 'type' => $type])
                            </div>
                        @empty
                        @endforelse
                    </div>
                </div>
                
                <div class="col-6 d-flex justify-content-center">
                    <div class="collapse" id="collapsableAddMetacognition{{ $section->id }}">
                        <div class="ms-1 me-1">
                            <button type="button" id="add_multiple_choice_button" class="btn btn-sm btn-success mt-1" data-bs-toggle="modal" data-bs-target="#add_meta_multiple_choice_exercise_modal_{{ $section->id }}">
                                Multiple choice
                            </button>
                            @include('modals.exercises.metacognition', ['section' => $section, 'underscore_type' => 'multiple_choice', 'type' => 'Multiple Choice'])
                        </div>
                        <div class="ms-1 me-1">
                            <button type="button" id="add_drag_and_drop_button" class="btn btn-sm btn-success mt-1" data-bs-toggle="modal" data-bs-target="#add_meta_drag_and_drop_exercise_modal_{{ $section->id }}">
                                Drag and Drop
                            </button>
                            @include('modals.exercises.metacognition', ['section' => $section, 'underscore_type' => 'drag_and_drop', 'type' => 'Drag and Drop'])
                        </div>
                        <div class="ms-1 me-1">
                            <button type="button" id="add_open_ended_metacognition_button" class="btn btn-sm btn-success mt-1" data-bs-toggle="modal" data-bs-target="#add_meta_open_ended_exercise_modal_{{ $section->id }}">
                                Open-ended
                            </button>
                            @include('modals.exercises.metacognition', ['section' => $section, 'underscore_type' => 'open_ended', 'type' => 'Open Ended'])
                        </div>
                        <div class="ms-1 me-1">
                            <button type="button" id="add_form_button" class="btn btn-sm btn-success mt-1" data-bs-toggle="modal" data-bs-target="#add_meta_form_exercise_modal_{{ $section->id }}">
                                Form
                            </button>
                            @include('modals.exercises.metacognition', ['section' => $section, 'underscore_type' => 'form', 'type' => 'Form'])
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="d-flex justify-content-center align-items-center card p-5">
            <p class="text-secondary text-center"><small>Looks like you haven't configured any section yet. Try adding at least one <a href="{{ route('sections.index', $unit) }}">here</a>.</small></p>
        </div>
    @endforelse
</div>

@endsection