@if($tracking == null)
    @if($subtype != '99' && $subtype != '991')
        @include('feedback.exercise')
        <div class="m-2 mt-4 row">
            <a class="btn btn-primary btn-sm col-12 col-lg-4" 
            @if($e->exerciseType->underscore_name == "drag_and_drop") onclick="getDragAndDropResults({{ json_encode($questions) }}, {{ json_encode($e) }}); stepIntentCount();" @endif
            @if($e->exerciseType->underscore_name == "multiple_choice") onclick="getMultipleChoiceResults({{ json_encode($questions) }}, {{ json_encode($e) }}); stepIntentCount();" @endif
            @if($e->exerciseType->underscore_name == "fill_in_the_gaps") onclick="getFillInTheGapsResults({{ json_encode($questions) }}, {{ json_encode($e) }}); stepIntentCount();" @endif
            @if($e->exerciseType->underscore_name == "open_ended") onclick="getOpenEndedResults({{ json_encode($questions) }}, {{ json_encode($e) }}); stepIntentCount();" @endif
            @if($e->exerciseType->underscore_name == "form") onclick="getFormResults({{ json_encode($questions) }}, {{ json_encode($e) }}); stepIntentCount();" @endif
            >
                Try again
            </a>
        </div>
    @endif
    <div class="m-2 mt-4 row">
        <button class="btn btn-primary btn-sm col-12 col-lg-4" type="submit">Check</button>
    </div>
@endif