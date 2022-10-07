<div class="tab-pane fade show active" id="{{ $e->exerciseType->underscore_name . $e->id }}" role="tabpanel" aria-labelledby="{{ $e->exerciseType->underscore_name . $e->id }}-tab">
    <div class="container">
        <h4>{{ $e->title }}</h4>
        @isset($e->extra_info) <p class="text-info"><i class="mdi mdi-information-outline text-info"></i> &nbsp; {{ $e->extra_info }}</p> @endisset
        <p class="text-secondary">{{ $e->description }}</p>
        <form action="">
            @forelse($e->questions as $question)
                <div class="border rounded p-4 mt-3 mb-3 shadow">
                    <p>{{ $loop->index + 1 . ". " . $question->statement }}</p>
                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" placeholder="Enter the Answer here"></textarea>
                    @if($e->subtype != '99')
                        @include('feedback.question', ['feedbacks' => $question->feedbacks])
                    @endif
                </div>
            @empty
                <div>
                    <p class="text-secondary">Empty</p>
                </div>
            @endforelse
        </form>

        @if($e->subtype != '99')
            @include('feedback.exercise')
        @endif

        @if ($e->subtype != 99 and $e->subtype != 991)
            <button class="btn btn-sm btn-primary" onclick="showFeedback()">
                Check
            </button>
        @endif

        <div class="m-2 mt-3">
            <button class="btn btn-sm btn-primary" type="submit">
                Submit
            </button>
        </div>
    </div>
</div>