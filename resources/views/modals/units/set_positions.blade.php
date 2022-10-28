<!-- Multiple choice modal -->
<div class="modal fade" id="{{ $modal_id }}" tabindex="-1" aria-labelledby="{{ $modal_id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Set units order</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('units.positions') }}" method="POST">
                    @csrf
                    @forelse($units as $unit)
                        <div class="row">
                            <div class="col-8">
                                <p>{{ $unit->title }}: </p>
                            </div>
                            <div class="col-4">
                                <select class="form-select" name="positions[{{ $unit->id }}]" id="position">
                                    @foreach($units as $u)
                                        @php 
                                        $current_position = 0;
                                        if(isset($unit->position)) {
                                            $current_position = $unit->position;
                                        } else {
                                            $current_position = 1;
                                        }
                                        @endphp
                                        <option value="{{ $loop->index + 1 }}" @if($loop->index + 1 == $current_position) selected @endif>{{ $loop->index + 1 }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    @empty
                    @endforelse
                    <br>
                    <button class="btn btn-primary" type="submit">
                        Save
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>