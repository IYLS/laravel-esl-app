<div class="card m-2 p-4">
    <h4>Feedback</h4>
    @isset($exercise->feedback)
        <p>Type: {{ $exercise->feedback->feedbackType->name }}</p>
        <p>Description: {{ $exercise->feedback->feedbackType->description }}</p>
        @include('alerts.confirmation', ['title' => 'Confirmation request', 'body' => "Please confirm you want to delete feedback settings for exercise with id $exercise->id.", 'button_target_id' => 'delete_feedback_modal', 'route' => route("feedback.destroy", $exercise->feedback->id)])
    @else
        <p class="text-center p-2 text-secondary"><small>No feedback added yet.</small></p>
    @endisset
    <div class="ms-1 me-1">
        @isset($exercise->feedback)
            <button type="button" id="add_feedback_button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#delete_feedback_modal">
                <i class="mdi mdi-delete"></i>
            </button> 
        @else
            <button type="button" id="add_feedback_button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#add_feedback_modal">
                Add feedback settings
            </button>
        @endif
        <a href="#" class="btn btn-sm btn-success">
            Details
        </a>
    </div>
    
</div>

@include('exercises.modals.feedback_modal')