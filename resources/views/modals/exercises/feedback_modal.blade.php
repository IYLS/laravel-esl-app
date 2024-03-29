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
                    @foreach($feedback_types as $type)
                        <div class="d-flex justify-content-between">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="{{ $type->id }}" name="types[]" id="feedback-types-{{ $type->id }}">
                                <label class="form-check-label" for="feedback-types-{{ $type->id }}">{{ $type->name }}</label>
                            </div>
                            <div class="mt-2">
                                <button class="btn btn-link btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#feedback_description_{{ $type->id }}_modal">
                                    <i class="mdi mdi-information-outline" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $type->description }}"></i>
                                </button>
                            </div>
                        </div>
                    @endforeach
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>