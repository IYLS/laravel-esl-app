<div class="modal fade" id="addSectionModal" tabindex="-1" aria-labelledby="addSectionModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addSectionModal">New Keyword</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('sections.store', $unit_id) }}" method="POST">
                    @csrf
                    <input id="word" name="name" type="text" class="form-control" placeholder="Enter section title" required>
                    <br>
                    <input id="description" name="instructions" type="text" class="form-control" placeholder="Add any relevant information for this section. e.g. context, instructions, etc.">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>