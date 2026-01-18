{{-- Componente reutilizable para botones de acción de preguntas --}}
{{-- Parámetros: question, questionNumber, exercise, showEdit (default: true), showDelete (default: true) --}}
@php
    $showEdit = $showEdit ?? true;
    $showDelete = $showDelete ?? true;
@endphp

<div class="d-flex justify-content-end">
    @if($showDelete)
        <button type="button" id="delete_question_button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#delete_question_{{ $question->id }}">
            <span class="material-symbols-outlined">delete</span>
        </button>
        @include('modals.questions.delete_confirmation', [
            'title' => 'Confirmation request', 
            'body' => "Please confirm you want to delete question number $questionNumber.", 
            'button_target_id' => "delete_question_$question->id", 
            'route' => route('questions.destroy', [$exercise->id, $question->id])
        ])
    @endif
    
    @if($showEdit)
        <button type="button" id="edit_question_button" class="btn btn-sm btn-warning ms-1" data-bs-toggle="modal" data-bs-target="#edit_question_{{ $question->id }}">
            <span class="material-symbols-outlined">edit</span>
        </button>
        @include('modals.questions.edit', [
            'button_target_id' => "edit_question_$question->id", 
            'alternatives' => $question->alternatives ?? []
        ])
    @endif
</div>