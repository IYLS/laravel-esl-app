<!-- Multiple choice modal -->
<div class="modal fade" id="add_meta_{{ $underscore_type }}_exercise_modal" tabindex="-1" aria-labelledby="add_meta_{{ $underscore_type }}_exercise_modal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">New {{ $type }} activity</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @php
                    $type_id = 0;
                    if($underscore_type == 'multiple_choice') 
                    {
                        $type_id = 2;
                    }
                    else if($underscore_type == 'drag_and_drop') 
                    {
                        $type_id = 1;
                    }
                    else if($underscore_type == 'open_ended') 
                    {
                        $type_id = 4;
                    }
                    else if($underscore_type == 'form') 
                    {
                        $type_id = 6;
                    };
                @endphp
                <form action="{{ route('exercises.store', [$section->unit->id, $type_id, $section->id]) }}" method="POST">
                    @csrf
                    <input id="title" name="title" type="text" class="form-control" placeholder="Title">
                    <br>
                    <input id="description" name="description" type="text" class="form-control" placeholder="Description">
                    @if($type_id == 4)
                        <br>
                        <select id="subtype" name="subtype" class="form-select">
                            <option value="" selected disabled>Select a subtype</option>
                            <option value="99">Simple</option>
                            <option value="991">Table style</option>
                        </select>
                    @endif
                    <input type="text" class="form-control mt-1" placeholder="Additional information" name="extra_info">
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