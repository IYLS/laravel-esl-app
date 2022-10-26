<div class="modal fade" id="add_{{ $type->underscore_name }}_exercise_modal" tabindex="-1" aria-labelledby="add_{{ $type->underscore_name }}_exercise_modal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update {{ $type->name}} activity</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('exercises.update', [$section->unit->id, $type, $exercise->id]) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input id="title" name="title" type="text" class="form-control" placeholder="Title" required value="{{ $exercise->title }}">
                    <br>
                    <input id="description" name="description" type="text" class="form-control" placeholder="(Optional) Description" value="{{ $exercise->description }}">
                    <br>
                    <textarea id="instructions" name="instructions" class="mce-editor" placeholder="(Optional) Instructions">{!! $exercise->instructions !!}</textarea>
                    <br>
                    <textarea id="translated_instructions" name="translated_instructions" class="mce-editor" placeholder="(Optional) Translated instructions">{!! $exercise->translated_instructions !!}</textarea>
                    <br>
                    <select id="section" name="section" class="form-select">
                        @foreach($sections as $section)
                            <option value="{{ $section->id }}" @if($section->id == $exercise->section->id) selected @endif>{{ $section->name }}</option>
                        @endforeach
                    </select>
                    <input type="text" class="form-control mt-1" placeholder="(Optional) Additional Information" name="extra_info" placeholder="{{ $exercise->extra_info }}">
                    <p class="text-info"><small>(Optional) Enter here any relevant information about the exercise. e.g. An example of how to complete the exercise.</small></p>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>