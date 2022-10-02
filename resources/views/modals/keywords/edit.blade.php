<!-- Modal -->
<div class="modal fade" id="editKeywordModal-{{ $keyword->id}}" tabindex="-1" aria-labelledby="editKeywordModal-{{ $keyword->id}}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editKeywordModal">Edit Keyword</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('keywords.update', [$unit_id, $keyword->id]) }}" method="POST">
                    @csrf
                    <input id="word" name="word" type="text" class="form-control" placeholder="Enter keyword" value="{{ $keyword->keyword }}">
                    <br>
                    <input id="description" name="description" type="text" class="form-control" placeholder="Enter description" value="{{ $keyword->description }}">
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>