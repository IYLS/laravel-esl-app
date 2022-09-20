<div class="tab-pane fade show active" id="{{ $e->exerciseType->underscore_name . $e->id }}" role="tabpanel" aria-labelledby="{{ $e->exerciseType->underscore_name . $e->id }}-tab">
    <div class="container">
        <h4>{{ $e->title }}</h4>
        <p class="text-secondary">{{ $e->description }}</p>
        @forelse($e->questions as $question)
        <div class="border rounded p-4 mt-3 mb-3 shadow">
            <p>{{ $loop->index + 1 . ". " . $question->statement }}</p>
            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" placeholder="Enter the Answer here"></textarea>
            @include('feedback.question')
        </div>
        @empty
        <div>
            <p class="text-secondary">Empty</p>
        </div>
        @endforelse

        @include('feedback.exercise')

        <button class="btn btn-sm btn-primary" onclick="showFeedback()">
            Check
        </button>
    </div>
</div>