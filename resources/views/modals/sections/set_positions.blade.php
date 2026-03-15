<!-- Multiple choice modal -->
<div class="modal fade" id="{{ $modal_id }}" tabindex="-1" aria-labelledby="{{ $modal_id }}" aria-hidden="true" data-bs-focus="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Set sections positions</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h4>Positions for {{ $unit->title }} unit sections</h4>
                <form method="POST" action="{{ route('sections.positions', "$unit->id") }}" method="POST">
                    @csrf
                    @forelse($unit->sections->sortBy('position') as $section)
                        <div class="row">
                            <div class="col-8">
                                <p>{{ $section->name }}: </p>
                            </div>
                            <div class="col-4">
                                <select class="form-select" name="positions[{{ $section->id }}]" id="position">
                                    @foreach($unit->sections as $section)
                                        @php $index = $loop->index + 1; @endphp
                                        <option value="{{ $index }}" @if($index == $section->position) selected @endif>{{ $index }}</option>
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