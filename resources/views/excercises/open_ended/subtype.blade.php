<div class="tab-pane fade show active" id="{{ $e->excerciseType->underscore_name . $e->id }}" role="tabpanel" aria-labelledby="{{ $e->excerciseType->underscore_name . $e->id }}-tab">
    <div class="container">
        <h4>{{ $e->title }}</h4>
        <p class="text-secondary">{{ $e->description }}</p>
        @forelse($e->questions as $question)
        <div class="mb-3">
            <p>{{ $loop->index + 1 . ". " . $question->statement }}</p>
            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" placeholder="Enter the Answer here"></textarea>
        </div>
        @empty
        <div>
            <p class="text-secondary">Empty</p>
        </div>
        @endforelse
    </div>
</div>