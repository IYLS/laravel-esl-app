<div class="m-1 p-2 border" id="feedback-exercise-details-container-{{ $e->id }}" hidden>
    <p class="text-success text-center" id="feedback-exercise-correct-{{ $e->id }}" hidden></p>
    <p class="text-danger text-center" id="feedback-exercise-wrong-{{ $e->id }}" hidden></p>
    
    @if(isset($e->feedbacks) and count($e->feedbacks) > 0)

        {{-- @if(in_array('1', $feedback_content["ids"]))
            <p class="text-center show-on-open-submit" hidden>{{ $e->feedbacks->where('feedback_type_id', 1)->first()->message }}</p>
        @endif --}}

        @if(in_array('4', $feedback_content["ids"]))
            <p class="text-center show-on-any-wrong-{{ $e->id }}">{{ $e->feedbacks->where('feedback_type_id', 4)->first()->message }}</p>
        @endif

        {{-- Show on Check if correct response --}}
        @if($e->feedbacks->where('feedback_type_id', 2)->first() != null)
            <p class="text-center show-on-all-correct-{{ $e->id }}" hidden>{{ $e->feedbacks->where('feedback_type_id', 2)->first()->message }} 🎉</p>
        @endif

    @endif
</div>