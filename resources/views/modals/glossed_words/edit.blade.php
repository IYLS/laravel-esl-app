<!-- Modal -->
<div class="modal fade" id="editGlossedWordModal-{{ $word->id}}" tabindex="-1" aria-labelledby="editGlossedWordModal-{{ $word->id}}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editGlossedWordModal">Edit Glossed Word</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('glossed_words.update', [$unit_id, $word->id]) }}" method="POST">
                    @csrf
                    <input id="word" name="word" type="text" class="form-control" placeholder="Enter word" value="{{ $word->word }}">
                    <br>
                    <input id="description" name="description" type="text" class="form-control" placeholder="Enter description" value="{{ $word->description }}">
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>