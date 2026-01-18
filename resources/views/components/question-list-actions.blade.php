{{-- Componente reutilizable para botones de acciones en listas de preguntas --}}
{{-- Parámetros: exercise, addModalId (default: 'addQuestionModal'), positionsModalId (default: 'questions_positions_modal') --}}
@php
    $addModalId = $addModalId ?? 'addQuestionModal';
    $positionsModalId = $positionsModalId ?? 'questions_positions_modal';
@endphp

<div>
    <button type="button" id="addQuestionButton" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#{{ $addModalId }}">Add question</button>
    <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#{{ $positionsModalId }}">
        Positions  <span class="material-symbols-outlined">sort</span>
    </button>
    @include('modals.questions.set_positions', [
        "modal_id" => $positionsModalId, 
        "questions" => $exercise->questions
    ])
</div>