<div class="modal fade" id="addGlossedWordModal" tabindex="-1" aria-labelledby="addGlossedWordModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addGlossedWordModal">New Glossed Word</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('glossed_words.store', $unit_id) }}" method="POST">
                    @csrf
                    <input id="word" name="word" type="text" class="form-control" placeholder="Enter glossed word">
                    <br>
                    <input id="description" name="description" type="text" class="form-control" placeholder="Enter description">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>