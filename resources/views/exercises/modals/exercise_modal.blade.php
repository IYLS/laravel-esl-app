<!-- Multiple choice modal -->
<div class="modal fade" id="add_{{ $type->underscore_name }}_exercise_modal" tabindex="-1" aria-labelledby="add_{{ $type->underscore_name }}_exercise_modal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">New {{ $type->name}} activity</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('exercises.store', [$section->unit->id, $type, $section->id]) }}" method="POST">
                    @csrf
                    <input id="title" name="title" type="text" class="form-control" placeholder="Title">
                    <br>
                    <input id="description" name="description" type="text" class="form-control" placeholder="Description">
                    @if($type->underscore_name == "multiple_choice")
                        <br>
                        <select id="type" name="type" class="form-select">
                            <option value="" selected disabled>Select a subtype</option>
                            <option value="1">Predicting</option>
                            <option value="2">What do you hear?</option>
                            <option value="3">Evaluating Statements</option>
                            <option value="4">Multiple choice</option>
                        </select>
                    @elseif($type->underscore_name == "fill_in_the_gaps")
                        <br>
                        <select id="type" name="type" class="form-select">
                            <option value="" selected disabled>Select a subtype</option>
                            <option value="1">Dictation cloze</option>
                            <option value="2">Vocabulary practice</option>
                        </select>
                    @endif
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>