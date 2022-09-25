<!-- Multiple choice modal -->
<div class="modal fade" id="add_feedback_modal" tabindex="-1" aria-labelledby="add_feedback_modal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Feedback</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('feedback.create', [$exercise->id]) }}" method="POST">
                    @csrf
                    <select id="type" name="type" class="form-select">
                        <option value="" selected disabled>Select a type of feedback</option>
                        @forelse($feedback_types as $type)
                            <option value="{{ $type->id }}">{{ $type->name }}</option>
                        @empty
                        @endforelse
                    </select>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>