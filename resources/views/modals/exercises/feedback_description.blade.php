<!-- Multiple choice modal -->
<div class="modal fade" id="feedback_description_{{ $id }}_modal" tabindex="-1" aria-labelledby="feedback_description_{{ $id }}_modal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-info"><i class="mdi mdi-information-outline"></i> Feedback Description</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h5>{{ $type }}</h5>
                <p class="p-2">{{ $description }}</p>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>