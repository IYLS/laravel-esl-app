{{-- Contenido del formulario Add Exercise (cargado por AJAX) --}}
@php $modal_suffix = $type->underscore_name . '_' . $section_id; @endphp
<form enctype="multipart/form-data" action="{{ route('exercises.store', [$section->unit->id, $type, $section_id]) }}" method="POST">
    @csrf
    <input type="hidden" name="category" value="{{ $category }}">
    <input id="title_{{ $modal_suffix }}" name="title" type="text" class="form-control" placeholder="Title">
    <br>
    <input id="description_{{ $modal_suffix }}" name="description" type="text" class="form-control" placeholder="(Optional) Description">
    <br>
    <textarea id="instructions_{{ $modal_suffix }}" name="instructions" class="form-control mce-editor-lazy" rows="4" placeholder="(Optional) Instructions" data-mce-lazy></textarea>
    <br>
    <input id="translated_instructions_{{ $modal_suffix }}" name="translated_instructions" type="text" class="form-control" placeholder="(Optional) Translated instructions">
    @if($type->underscore_name == "multiple_choice")
        <br>
        <select id="subtype_{{ $modal_suffix }}" name="subtype" class="form-select" required>
            <option value="" selected disabled>Select a subtype</option>
            <option value="1">Predicting</option>
            <option value="2">What do you hear?</option>
            <option value="3">Evaluating Statements</option>
            <option value="4">Multiple choice</option>
        </select>
        <br>
        <div class="mb-3">
            <label for="image_{{ $modal_suffix }}" class="form-label">(Optional) Select image file</label>
            <input class="form-control" type="file" name="image" id="image_{{ $modal_suffix }}" accept="image/*">
        </div>
    @elseif($type->underscore_name == "fill_in_the_gaps")
        <br>
        <select id="subtype_{{ $modal_suffix }}" name="subtype" class="form-select" required>
            <option value="" selected disabled>Select a subtype</option>
            <option value="1">Dictation cloze</option>
            <option value="2">Vocabulary practice</option>
        </select>
    @else
        <input type="text" value="1" name="subtype" hidden>
    @endif
    @include('modals.exercises._forum_create_fields', ['suffix' => $modal_suffix])
    <input id="extra_info_{{ $modal_suffix }}" type="text" class="form-control mt-1" placeholder="(Optional) Additional Information" name="extra_info">
    <p class="text-info"><small>(Optional) Enter here any relevant information about the exercise. e.g. An example of how to complete the exercise.</small></p>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save</button>
    </div>
</form>
