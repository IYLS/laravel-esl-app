<!-- Multiple choice modal -->
<div class="modal fade" id="{{ $modal_id }}" tabindex="-1" aria-labelledby="{{ $modal_id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Set exercises positions</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h4>Positions for {{ $section->name }} section</h4>
                <form method="POST" action="{{ route('sections.positions', "$section->unit_id") }}" method="POST">
                    @csrf
                    @forelse($section->exercises as $exercise)
                        <div class="row">
                            <div class="col-8">
                                <p>{{ $exercise->title }}: </p>
                            </div>
                            <div class="col-4">
                                <select class="form-select" name="positions[{{ $exercise->id }}]" id="position">
                                    @php 
                                    $current_position = 0;
                                    if(isset($exercise->position)) {
                                        $current_position = $exercise->position;
                                    } else {
                                        $current_position = 1;
                                    }
                                    @endphp

                                    @foreach($section->exercises as $e)
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