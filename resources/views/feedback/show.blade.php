<div class="card m-2 p-4">
    <h4>Feedback</h4>
    @isset($excercise->feedback)
        <p>Type: {{ $excercise->feedback->message }}</p>
    @else
        <p class="text-center p-2 text-secondary"><small>No feedback added yet.</small></p>
    @endisset
    <div class="ms-1 me-1">
        <button type="button" id="add_feedback_button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#add_feedback_modal">
            Add feedback
        </button>
    </div>
</div>

@include('excercises.modals.feedback_modal')