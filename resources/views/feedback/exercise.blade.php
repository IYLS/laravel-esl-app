@php
    $exerciseLevelFeedbacks = ($e->feedbacks ?? collect())->whereNull('question_id');
@endphp

<div class="m-1 p-2 border" id="feedback-exercise-details-container-{{ $e->id }}" hidden>
    <p class="text-success text-center" id="feedback-exercise-correct-{{ $e->id }}" hidden></p>
    <p class="text-danger text-center" id="feedback-exercise-wrong-{{ $e->id }}" hidden></p>

    @if($exerciseLevelFeedbacks->isNotEmpty())

        @if($exerciseLevelFeedbacks->where('feedback_type_id', 1)->first() != null)
            <p class="text-center" id="feedback-exercise-short-message-a-{{ $e->id }}" hidden>{{ $exerciseLevelFeedbacks->where('feedback_type_id', 1)->first()->message }}</p>
        @endif

        @if($exerciseLevelFeedbacks->where('feedback_type_id', 4)->first() != null)
            <p class="text-center show-on-any-wrong-{{ $e->id }}">{{ $exerciseLevelFeedbacks->where('feedback_type_id', 4)->first()->message }}</p>
        @endif

        @if($exerciseLevelFeedbacks->where('feedback_type_id', 2)->first() != null)
            <p class="text-center show-on-all-correct-{{ $e->id }}" hidden>{{ $exerciseLevelFeedbacks->where('feedback_type_id', 2)->first()->message }} 🎉</p>
        @endif

    @endif
</div>
