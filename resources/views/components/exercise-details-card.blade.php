{{-- Componente reutilizable para mostrar detalles de ejercicio --}}
{{-- Parámetros: exercise, showEditButton (default: true) --}}
@php
    $showEditButton = $showEditButton ?? true;
@endphp

<div class="card p-4 m-2">
    @if($showEditButton)
        <div class="row">
            <h4 class="col-10 col-md-11">Activity Details</h4>
            <button type="button" id="add_{{ $exercise->exerciseType->underscore_name }}_button" class="btn btn-sm btn-warning col-2 col-md-1" data-bs-toggle="modal" data-bs-target="#add_{{ $exercise->exerciseType->underscore_name}}_exercise_modal">Edit</button>
        </div>
    @else
        <h4>Activity Details</h4>
    @endif

    <h5>Title: {{ $exercise->title }}</h5>
    <p>Description: {{ $exercise->description }}</p>

    @if(isset($exercise->subtype) && $exercise->subtype)
        <p>
            Subtype:
            @switch($exercise->subtype)
                @case(1)
                    @if(isset($exerciseType) && $exerciseType->underscore_name == 'poll')
                        Likert 1-7
                    @elseif(isset($exerciseType) && $exerciseType->underscore_name == 'fill_in_the_gaps')
                        Dictation Cloze
                    @else
                        Predicting
                    @endif
                    @break
                @case(2)
                    @if(isset($exerciseType) && $exerciseType->underscore_name == 'fill_in_the_gaps')
                        Vocabulary Practice
                    @else
                        What do you hear?
                    @endif
                    @break
                @case(3)
                    Evaluating Statements
                    @break
                @case(4)
                    Multiple choice
                    @break
                @case(99)
                    Metacognition
                    @break
            @endswitch
        </p>
    @endif

    @isset($exercise->extra_info)
        <p class="text-info">Additional Information: {{ $exercise->extra_info }}</p>
    @endisset

    @isset($exercise->instructions)
        <p>Instructions: {!! $exercise->instructions !!}</p>
    @endisset

    @isset($exercise->translated_instructions)
        <p>Translated Instructions: {!! $exercise->translated_instructions !!}</p>
    @endisset
</div>

@include('modals.exercises.edit', ['section' => $exercise->section, 'type' => $exercise->exerciseType])