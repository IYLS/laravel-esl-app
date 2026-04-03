<div class="row">
    @include('feedback.exercise')
</div>

@php
    $url = route('tracking.store', [$e->id, $user->id]);
    $useMorphingSubmit = isset($subtype) && $subtype != '99' && $subtype != '991';
@endphp

<div class="d-flex">
    <div class="m-1">
        @if(isset($type) && $type == 'voice_recognition')
            <button type="button" class="btn btn-primary btn-sm" id="exercise-{{ $e->id }}-check-btn"
                @if($useMorphingSubmit) data-can-morph="1" @endif
                onclick="exerciseSubmitClick(this, {{ json_encode($e) }}, {{ json_encode($e->questions) }}, {{ json_encode('voice_recognition') }}, {{ json_encode($e->id) }}, {{ json_encode($user->id) }}, {{ json_encode($url) }});"
            >Check</button>
        @else
            <button type="button" class="btn btn-primary btn-sm" id="exercise-{{ $e->id }}-check-btn"
                @if($useMorphingSubmit) data-can-morph="1" @endif
                onclick="exerciseSubmitClick(this, {{ json_encode($e) }}, {{ json_encode($e->questions) }}, {{ json_encode($e->exerciseType->underscore_name) }}, {{ json_encode($e->id) }}, {{ json_encode($user->id) }}, {{ json_encode($url) }});"
            >Check</button>
        @endif
    </div>

    <div class="m-1">
        <button
            id="reset-button-{{ $e->id }}"
            class="btn btn-info btn-sm"
            onclick="resetExercise({{ json_encode($e->id) }}, {{ json_encode($e->questions) }}, {{ json_encode($e->exerciseType->underscore_name) }}); resetFeedbackInteractionsCount({{ json_encode($e->id) }});"
            type="button"
        >
            Reset
        </button>
    </div>
</div>
