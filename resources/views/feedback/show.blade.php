<div class="card m-2 p-4">
    <h5>Feedback</h5>
    @if(isset($exercise->feedbacks) and count($exercise->feedbacks) > 0)
        <div class="col-12 col-md-8">
            <h5 class="mt-3">Exercise based feedback:</h5> 
            @forelse($exercise->feedbacks as $fb)
                @if($fb->feedbackType->level == "exercise")
                    <p>💡 {{ $fb->feedbackType->name }}</p>
                @endif
            @empty
                <p class="text-secondary text-center"><small>Nothing to show</small></p>
            @endforelse
        </div>
        <div class="col-12 col-md-8">
            <h5 class="mt-3">Question based feedback:</h5>
            @foreach($exercise->questions as $question)
                @foreach($question->feedbacks as $fb)
                    <p>{{ $question->statement }} -> {{ $fb->message }}</p>
                    @if($fb->feedbackType->text_based) <p>{{ $question->statement }} -> {{ $fb->audio_name }}</p>@endif
                    @if($fb->feedbackType->id == 5)
                        @foreach($question->alternatives as $alternative)
                            <p class=""><small>{{ $alternative->title }}: {{ $alternative->feedback }}</small></p>
                        @endforeach
                    @endif
                @endforeach
            @endforeach
        </div>
        @include('alerts.confirmation', ['title' => 'Confirmation request', 'body' => "Please confirm you want to delete feedback settings for exercise with id $exercise->id.", 'button_target_id' => 'delete_feedback_modal', 'route' => route("feedback.destroy", $exercise->id)])
        <div class="ms-1 me-1">
            <button type="button" id="add_feedback_button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#delete_feedback_modal">
                Delete feedback settings <i class="mdi mdi-delete"></i>
            </button> 
        </div>
    @else
        <p class="text-center p-2 text-secondary"><small>No feedback added yet.</small></p>
        <div class="ms-1 me-1">
            <button type="button" id="add_feedback_button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#add_feedback_modal">
                Add feedback settings
            </button>
        </div>

    @endisset
</div>

@include('exercises.modals.feedback_modal')