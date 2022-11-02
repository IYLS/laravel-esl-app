<!-- Multiple choice modal -->
<div class="modal fade" id="{{ $modal_id }}" tabindex="-1" aria-labelledby="{{ $modal_id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Set questions order</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('questions.positions') }}" method="POST">
                    @csrf
                    @forelse($questions->sortBy('position') as $question)
                        <div class="row">
                            <div class="col-8">
                                <p>{{ $question->statement }}: </p>
                            </div>
                            <div class="col-4">
                                <select class="form-select" name="positions[{{ $question->id }}]" id="position">
                                    @foreach($questions as $q)
                                        @php $index = $loop->index + 1; @endphp
                                        <option value="{{ $index }}" @if($question->position == $index) selected @endif>{{ $index }}</option>
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