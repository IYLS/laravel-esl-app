<div class="row mt-3">
    @if($subtype != '99' && $subtype != '991')
        @include('feedback.exercise')
        <div class="col-2 ms-1 me-1">
            <button class="btn btn-primary btn-sm" type="button"
            @if($e->exerciseType->underscore_name == "drag_and_drop") onclick="getDragAndDropResults({{ json_encode($questions) }}, {{ json_encode($e) }}); stepIntentCount();" @endif
            @if($e->exerciseType->underscore_name == "multiple_choice") onclick="getMultipleChoiceResults({{ json_encode($questions) }}, {{ json_encode($e) }}); stepIntentCount();" @endif
            
            @if($e->exerciseType->underscore_name == "fill_in_the_gaps" and $e->subtype == "2") 
                onclick="getFillInTheGapsResults({{ json_encode($questions) }}, {{ json_encode($e) }}); stepIntentCount();"
            @elseif($e->exerciseType->underscore_name == "fill_in_the_gaps" and $e->subtype == "1") 
                onclick="getDictationClozeResults({{ json_encode($questions) }}, {{ json_encode($e) }}); stepIntentCount();"
            @endif

            @if($e->exerciseType->underscore_name == "open_ended") onclick="getOpenEndedResults({{ json_encode($questions) }}, {{ json_encode($e) }}); stepIntentCount();" @endif
           id="try_again_button_{{ $e->id }}"
            
            disabled
            >
                Try again
            </button>
        </div>
    @endif

    <div class="col-2 ms-1 me-1">
        @php $url = route("tracking.store", ["$e->id", "$user->id"]); @endphp
        <button class="btn btn-primary btn-sm" id="exercise-{{ $e->id }}-check-btn" onclick='checkAction({{ json_encode($e) }}, {{ json_encode($e->questions) }}, {{ json_encode($e->exerciseType->underscore_name) }}, {{ json_encode($e->id) }}, {{ json_encode($user->id) }}, {{ json_encode($url) }}); stepIntentCount(); toggleTryAgainButton("enabled",{{ json_encode($e->id) }});' type="button">Check</button>
    </div>

    @if($e->exerciseType->underscore_name == 'multiple_choice')
        <div class="col-2 ms-1 me-1">
            <button class="btn btn-info btn-sm" onclick="resetExercise({{ json_encode($e->id) }}, {{ json_encode($e->questions) }});" type="button">Reset</button>
        </div>
    @endif
</div>

@section('scripts')

<script>
    function toggleTryAgainButton(status, exercise_id) {
        var button = document.getElementById(`try_again_button_${exercise_id}`);
        if (status == "enabled") {
            button.disabled = false;
        }

        if (status == "disabled") {
            button.disabled = true
        }
    }
</script>

@endsection