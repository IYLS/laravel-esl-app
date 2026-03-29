{{-- Contenido del formulario Add Metacognition (cargado por AJAX) --}}
@php
    $type_id = 0;
    if($underscore_type == 'multiple_choice') { $type_id = 2; }
    else if($underscore_type == 'drag_and_drop') { $type_id = 1; }
    else if($underscore_type == 'open_ended') { $type_id = 4; }
    else if($underscore_type == 'form') { $type_id = 6; }
@endphp
<form @if($type_id == 2) enctype="multipart/form-data" @endif action="{{ route('exercises.store', [$section->unit->id, $type_id, $section->id]) }}" method="POST">
    @csrf
    <input id="title" name="title" type="text" class="form-control" placeholder="Title" required>
    <br>
    <input id="description" name="description" type="text" class="form-control mb-1" placeholder="(Optional) Description">
    @if($type_id == 2)
        <input class="form-control" type="file" name="video" id="video" accept="video/*" class="mt-1 mb-1">
    @endif
    @if($type_id == 4)
        <br>
        <select id="subtype" name="subtype" class="form-select" required>
            <option value="" selected disabled>Select a subtype</option>
            <option value="99">Simple</option>
            <option value="991">Table style</option>
        </select>
    @endif
    @include('modals.exercises._forum_create_fields', ['suffix' => 'meta_form_' . $section->id . '_' . $underscore_type])
    <input type="text" class="form-control mt-1" placeholder="(Optional) Additional Information" name="extra_info">
    <p class="text-info"><small>(Optional) Enter here any relevant information about the exercise. e.g. An example of how to complete the exercise.</small></p>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save</button>
    </div>
</form>
