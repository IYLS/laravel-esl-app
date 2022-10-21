<div class="card m-2 p-4">
    <h5>💡 Feedback</h5>
    @if(isset($exercise->feedbacks) and count($exercise->feedbacks) > 0)
        <br>
        <p>Types configured:</p>
        <div class="col-12 col-md-8">
            @php
                $types = array();

                foreach($exercise->feedbacks as $fb) {
                    $type_name = $fb->feedbackType->name;
                    if(!in_array($type_name, $types)) array_push($types, $type_name);
                }

                foreach($question->feedbacks as $fb) {
                    $type_name = $fb->feedbackType->name;
                    if(!in_array($type_name, $types)) array_push($types, $type_name);
                }

            @endphp

            <ul>
                @forelse($types as $fb)
                    <li>
                        <p>{{ $fb }}</p>
                    </li>
                @empty
                    <p class="text-secondary text-center"><small>Nothing to show</small></p>
                @endforelse            
            </ul>

        </div>
        @include('modals.questions.delete_confirmation', ['title' => 'Confirmation request', 'body' => "Please confirm you want to delete feedback settings for exercise with id $exercise->id.", 'button_target_id' => 'delete_feedback_modal', 'route' => route("feedback.destroy", $exercise->id)])
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

@include('modals.exercises.feedback_modal')