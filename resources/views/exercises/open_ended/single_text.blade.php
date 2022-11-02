@include('layouts.tracking_complete')
<div class="tab-pane fade show active" id="{{ $e->exerciseType->underscore_name . $e->id }}" role="tabpanel" aria-labelledby="{{ $e->exerciseType->underscore_name . $e->id }}-tab">
    <div class="container">
        <h4>{{ $e->title }}</h4>
        @isset($e->extra_info) <p class="text-info"><i class="mdi mdi-information-outline text-info"></i> &nbsp; {{ $e->extra_info }}</p> @endisset
        <p class="text-secondary">{{ $e->description }}</p>
        @isset($e->instructions) {!! $e->instructions !!} @endisset
        @isset($e->translated_instructions) <p>{!! $e->translated_instructions !!}</p> @endisset
        <form action="{{ route('tracking.store', ["$e->id", "$user->id"]) }}" method="POST" id="open_ended_form_{{ $e->id }}" onsubmit="return getResponseData({{ json_encode($e->questions) }}, {{ json_encode($e) }}, 'open_ended')">
            @csrf
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
            @include('layouts.tracking_buttons', ['tracking' => $e->tracking, 'questions' => $e->questions, 'exercise_id' => $e->id, 'subtype' => $e->subtype])
        </form>
    </div>
</div>