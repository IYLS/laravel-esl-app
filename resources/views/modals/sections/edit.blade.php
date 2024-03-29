<!-- Modal -->
<div class="modal fade" id="editSectionModal-{{ $section->id}}" tabindex="-1" aria-labelledby="editSectionModal-{{ $section->id}}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editSectionModal">Edit Section</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('sections.update', [$unit_id, $section->id]) }}" method="POST">
                    @csrf
                    <input id="name" name="name" type="text" class="form-control" placeholder="Enter section title" value="{{ $section->name }}" required>
                    <br>
                    <input id="instructions" name="instructions" type="text" class="form-control" placeholder="Enter section info. e.g. context, instructions, etc." value="{{ $section->instructions }}">
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>