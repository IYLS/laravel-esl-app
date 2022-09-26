<div class="m-1 p-4 border" id="feedback-exercise-details-container-{{ $e->id }}" hidden>
    <h5 class="text-center">💡 Activity Feedback</h5>

    @isset($e->feedbacks)
        @if(in_array('1', $feedback_content["ids"]))
            <p class="text-secondary text-center">💡 Short Message A</p>
            <p class="text-center">{{ $e->feedbacks->where('feedback_type_id', 1)->first()->message }}</p>
        @endif

        @if(in_array('2', $feedback_content["ids"]))
            <p class="text-secondary text-center">💡 Short Message B</p>
            <p class="text-center">{{ $e->feedbacks->where('feedback_type_id', 2)->first()->message }}</p>
        @endif

        @if(in_array('3', $feedback_content["ids"]))
            <p class="text-secondary text-center">💡 Elaborative</p>
            <p class="text-center">{{ $e->feedbacks->where('feedback_type_id', 3)->first()->message }}</p>
        @endif

        @if(in_array('4', $feedback_content["ids"]))
            <p class="text-secondary text-center">💡 Short Message C</p>
            <p class="text-center">{{ $e->feedbacks->where('feedback_type_id', 4)->first()->message }}</p>
        @endif

        @if(in_array('5', $feedback_content["ids"]))
            <p class="text-secondary text-center">💡 Explainatory</p>
            <p class="text-center">{{ $e->feedbacks->where('feedback_type_id', 5)->first()->message }}</p>
        @endif

        @if(in_array('6', $feedback_content["ids"]))
            <p class="text-secondary text-center">💡 Directive</p>
            <p class="text-center">{{ $e->feedbacks->where('feedback_type_id', 6)->first()->message }}</p>
        @endif

        @if(in_array('7', $feedback_content["ids"]))
            <p class="text-secondary text-center">💡  Knowledge of correct response</p>
            <p class="text-center">{{ $e->feedbacks->where('feedback_type_id', 7)->first()->message }}</p>
        @endif
    @endisset

    <p class="text-success text-center" id="feedback-exercise-correct-{{ $e->id }}" hidden></p>
    <p class="text-danger text-center" id="feedback-exercise-wrong-{{ $e->id }}" hidden></p>
</div>