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
                    @forelse($section->exercises->sortBy('position') as $exercise)
                        <div class="row">
                            <div class="col-8">
                                <p>{{ $exercise->title }}: </p>
                            </div>
                            <div class="col-4">
                                <select class="form-select" name="positions[{{ $exercise->id }}]" id="position">
                                    @foreach($section->exercises as $e)
                                        @php $index = $loop->index + 1; @endphp
                                        <option value="{{ $index }}" @if($index == $exercise->position) selected @endif>{{ $index }}</option>
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