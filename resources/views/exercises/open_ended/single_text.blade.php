@forelse($e->questions->sortBy('position') as $question)
    <div class="border rounded p-4 mt-3 mb-3 shadow">
        {!! $question->statement  !!}
        <textarea class="form-control" name="answer-{{ $question->id }}" rows="3" placeholder="Enter the Answer here"></textarea>
        @if($e->subtype != '99')
            @include('feedback.question', ['feedbacks' => $question->feedbacks])
        @endif
    </div>
@empty
    <div>
        <p class="text-secondary">Empty</p>
    </div>
@endforelse