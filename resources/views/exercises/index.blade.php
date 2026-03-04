@extends('layouts.app')
@section('main')

<div class="container">
    <div class="row d-flex align-items-center me-3 ms-3">
        <div class="mt-3 mb-1 col-11">
            <h3>{{ $unit->title }}</h3>
        </div>
        <div class="col-1">
            <a href="{{ route('units.show', $unit->id) }}">
                Go back
            </a>
        </div>
    </div>
    @forelse($unit->sections->sortBy('position') as $section)
        <div class="card p-4 m-4 shadow border-0">
            <div class="row">
                <div class="card-body d-flex justify-content-between">
                    <div>
                        <h4>{{ $section->name }} section</h4>
                        <div class="d-flex">
                            <div class="m-1">
                                <p>@if($section->instructions != "") {{ $section->instructions }} @else Empty instructions @endif</p>
                            </div>
                            <div class="m-1">
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#positions_modal_{{ $section->id }}">
                                    Positions  <span class="material-symbols-outlined">sort</span>
                                </button>
                                @include('modals.exercises.set_positions', ["modal_id" => "positions_modal_$section->id"])
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <table class="table">
                <thead>
                    <th>Activity title</th>
                    <th class="d-none d-md-table-cell">Description</th>
                    <th class="d-none d-md-table-cell">Type</th>
                    <th>Actions</th>
                </thead>
                <tbody>
                    @forelse($section->exercises->sortBy('position') as $exercise)
                        <tr @if($exercise->subtype == 99 or $exercise->subtype == 991) style="background-color: #D1FAE5;" @endif>

                            <td class="col-1">
                                {{ $exercise->title }}
                            </td>
                            <td class="col-7 d-none d-md-table-cell">
                                {{ $exercise->description }}
                            </td>
                            <td class="col-2 d-none d-md-table-cell">
                                {{ $exercise->exerciseType->name }}
                            </td>
                            <td class="col-1">
                                <div class="d-flex">
                                    <button type="button" class="btn-sm btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteExerciseModal{{ $exercise->id }}" title="Delete exercise">
                                        <span class="material-symbols-outlined" aria-hidden="true">delete</span>
                                    </button>
        
                                    <a href="{{ route("exercises.show", $exercise->id) }}" class="btn-sm btn btn-success me-1 ms-1"><span class="material-symbols-outlined" aria-hidden="true">search</span></a>
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
                    <button class="btn btn-primary btn-sm col-12 col-md-4 mt-2" data-bs-toggle="collapse" href="#collapsableAddExercise{{ $section->id }}" role="button" aria-expanded="false" aria-controls="collapsableAddExercise{{ $section->id }}">Add exercise <span class="material-symbols-outlined">arrow_downward</span></button>
                </div>

                <div class="col-6 d-flex justify-content-center">
                    <button class="btn btn-success btn-sm col-12 col-md-4 mt-2" data-bs-toggle="collapse" href="#collapsableAddMetacognition{{ $section->id }}" role="button" aria-expanded="false" aria-controls="collapsableAddMetacognition{{ $section->id }}">Add metacognition  <span class="material-symbols-outlined">arrow_downward</span></button>
                </div>

                <div class="col-6 d-flex justify-content-center">
                    <div class="collapse" id="collapsableAddExercise{{ $section->id }}">
                        @forelse($types as $type)
                            <div>
                                <button type="button" class="btn btn-sm btn-primary mt-1 btn-add-exercise" data-unit-id="{{ $unit->id }}" data-type-id="{{ $type->id }}" data-type-name="{{ $type->name }}" data-section-id="{{ $section->id }}">
                                    {{ $type->name }}
                                </button>
                            </div>
                        @empty
                        @endforelse
                    </div>
                </div>
                
                <div class="col-6 d-flex justify-content-center">
                    <div class="collapse" id="collapsableAddMetacognition{{ $section->id }}">
                        <div class="ms-1 me-1">
                            <button type="button" class="btn btn-sm btn-success mt-1 btn-add-metacognition" data-unit-id="{{ $unit->id }}" data-section-id="{{ $section->id }}" data-underscore-type="multiple_choice" data-type-name="Multiple Choice">
                                Multiple choice
                            </button>
                        </div>
                        <div class="ms-1 me-1">
                            <button type="button" class="btn btn-sm btn-success mt-1 btn-add-metacognition" data-unit-id="{{ $unit->id }}" data-section-id="{{ $section->id }}" data-underscore-type="drag_and_drop" data-type-name="Drag and Drop">
                                Drag and Drop
                            </button>
                        </div>
                        <div class="ms-1 me-1">
                            <button type="button" class="btn btn-sm btn-success mt-1 btn-add-metacognition" data-unit-id="{{ $unit->id }}" data-section-id="{{ $section->id }}" data-underscore-type="open_ended" data-type-name="Open Ended">
                                Open-ended
                            </button>
                        </div>
                        <div class="ms-1 me-1">
                            <button type="button" class="btn btn-sm btn-success mt-1 btn-add-metacognition" data-unit-id="{{ $unit->id }}" data-section-id="{{ $section->id }}" data-underscore-type="form" data-type-name="Form">
                                Form
                            </button>
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

{{-- Un solo modal para Add Exercise (contenido cargado por AJAX) --}}
<div class="modal fade" id="addExerciseModal" tabindex="-1" aria-hidden="true" data-bs-focus="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addExerciseModalTitle">New activity</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="addExerciseModalBody">
                <div class="text-center py-4">
                    <div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Un solo modal para Add Metacognition (contenido cargado por AJAX) --}}
<div class="modal fade" id="addMetacognitionModal" tabindex="-1" aria-hidden="true" data-bs-focus="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addMetacognitionModalTitle">New activity</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="addMetacognitionModalBody">
                <div class="text-center py-4">
                    <div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div>
                </div>
            </div>
        </div>
    </div>
</div>

@foreach($unit->sections->sortBy('position') as $section)
    @foreach($section->exercises->sortBy('position') as $exercise)
        @include('components.delete-confirmation-modal', [
            'modalId' => 'deleteExerciseModal' . $exercise->id,
            'title' => 'Delete Exercise',
            'itemName' => $exercise->title,
            'route' => route('exercises.destroy', [$exercise->section->unit_id, $exercise->exercise_type_id, $exercise->id]),
            'deleteButtonText' => 'Delete Exercise'
        ])
    @endforeach
@endforeach

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    var unitId = {{ $unit->id }};
    var baseUrl = '/units/' + unitId + '/exercises';

    // Prevenir que eventos wheel sobre el modal disparen scroll en el body
    document.querySelectorAll('.modal').forEach(function(modal) {
        modal.addEventListener('wheel', function(e) {
            if (modal.classList.contains('show')) {
                e.stopPropagation();
            }
        }, { passive: false });
    });

    // TinyMCE lazy: init al abrir, destroy al cerrar
    var mceConfig = {
        statusbar: false,
        license_key: 'gpl',
        plugins: 'advlist lists link',
        toolbar: 'undo redo | bold italic underline | link | checklist numlist bullist',
        menubar: false,
        height: 200,
        relative_urls: false,
    };

    function initTinyMCEInModal(modal) {
        var textarea = modal.querySelector('textarea.mce-editor-lazy');
        if (textarea && typeof tinymce !== 'undefined' && !tinymce.get(textarea.id)) {
            tinymce.init(Object.assign({ target: textarea }, mceConfig));
        }
    }

    function destroyTinyMCEInModal(modal) {
        var textarea = modal.querySelector('textarea.mce-editor-lazy');
        if (textarea && typeof tinymce !== 'undefined') {
            var ed = tinymce.get(textarea.id);
            if (ed) ed.remove();
        }
    }

    // Add Exercise: cargar formulario por AJAX
    document.querySelectorAll('.btn-add-exercise').forEach(function(btn) {
        btn.addEventListener('click', function() {
            var typeId = this.dataset.typeId;
            var typeName = this.dataset.typeName;
            var sectionId = this.dataset.sectionId;
            var modal = document.getElementById('addExerciseModal');
            var body = document.getElementById('addExerciseModalBody');
            var title = document.getElementById('addExerciseModalTitle');

            body.innerHTML = '<div class="text-center py-4"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div>';
            title.textContent = 'New ' + typeName + ' activity';

            fetch(baseUrl + '/add-form/' + typeId + '/' + sectionId + '?_=' + Date.now(), {
                headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'text/html' }
            })
            .then(function(r) { return r.text(); })
            .then(function(html) {
                body.innerHTML = html;
                var bsModal = bootstrap.Modal.getOrCreateInstance(modal);
                modal.addEventListener('shown.bs.modal', function onShown() {
                    modal.removeEventListener('shown.bs.modal', onShown);
                    initTinyMCEInModal(modal);
                }, { once: true });
                bsModal.show();
            })
            .catch(function() {
                body.innerHTML = '<p class="text-danger">Error loading form. Please try again.</p>';
            });
        });
    });

    var addExerciseModal = document.getElementById('addExerciseModal');
    if (addExerciseModal) {
        addExerciseModal.addEventListener('hidden.bs.modal', function() { destroyTinyMCEInModal(addExerciseModal); });
    }

    // Add Metacognition: cargar formulario por AJAX
    document.querySelectorAll('.btn-add-metacognition').forEach(function(btn) {
        btn.addEventListener('click', function() {
            var sectionId = this.dataset.sectionId;
            var underscoreType = this.dataset.underscoreType;
            var typeName = this.dataset.typeName;
            var modal = document.getElementById('addMetacognitionModal');
            var body = document.getElementById('addMetacognitionModalBody');
            var title = document.getElementById('addMetacognitionModalTitle');

            body.innerHTML = '<div class="text-center py-4"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div>';
            title.textContent = 'New ' + typeName + ' activity';

            fetch(baseUrl + '/metacognition-form/' + sectionId + '/' + underscoreType + '?_=' + Date.now(), {
                headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'text/html' }
            })
            .then(function(r) { return r.text(); })
            .then(function(html) {
                body.innerHTML = html;
                var bsModal = bootstrap.Modal.getOrCreateInstance(modal);
                bsModal.show();
            })
            .catch(function() {
                body.innerHTML = '<p class="text-danger">Error loading form. Please try again.</p>';
            });
        });
    });
});
</script>
@endsection