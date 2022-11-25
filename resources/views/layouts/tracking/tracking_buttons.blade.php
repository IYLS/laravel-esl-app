<div class="row">
    @if($subtype != '99' && $subtype != '991')
        @include('feedback.exercise')
    @endif
</div>

<div class="d-flex">
    @php $url = route("tracking.store", ["$e->id", "$user->id"]); @endphp
    @if($subtype != '99' && $subtype != '991')
        <div class="m-1">
            <button class="btn btn-primary btn-sm" type="button"
            onclick="checkAction({{ json_encode($e) }}, {{ json_encode($e->questions) }}, {{ json_encode($e->exerciseType->underscore_name) }}, {{ json_encode($e->id) }}, {{ json_encode($user->id) }}, {{ json_encode($url) }});"
            id="try_again_button_{{ $e->id }}"
            
            disabled
            >
                Try again
            </button>
        </div>
    @endif

    <div class="m-1">
        <button class="btn btn-primary btn-sm" id="exercise-{{ $e->id }}-check-btn" onclick='checkAction({{ json_encode($e) }}, {{ json_encode($e->questions) }}, {{ json_encode($e->exerciseType->underscore_name) }}, {{ json_encode($e->id) }}, {{ json_encode($user->id) }}, {{ json_encode($url) }});  toggleTryAgainButton("enabled",{{ json_encode($e->id) }});' type="button">Check</button>
    </div>

    @if($e->exerciseType->underscore_name == 'multiple_choice')
        <div class="m-1">
            <button 
                class="btn btn-info btn-sm" 
                onclick="resetExercise({{ json_encode($e->id) }}, {{ json_encode($e->questions) }}); resetFeedbackInteractionsCount({{ json_encode($e->id) }});" 
                type="button"
            >
                Reset
            </button>
        </div>
    @endif
</div>

@section('scripts')
    <script>
        function toggleTryAgainButton(status, exercise_id) {
            if (document.getElementById(`try_again_button_${exercise_id}`) != null) {
                var button = document.getElementById(`try_again_button_${exercise_id}`);
                if (status == "enabled") {
                    button.disabled = false;
                }
                if (status == "disabled") {
                    button.disabled = true
                }
            }
        }
    </script>
@endsection