<div class="tab-pane fade exercise-pane @if($loop->index == 0) show active @endif" id="{{ $e->exerciseType->underscore_name . $e->id }}" role="tabpanel" aria-labelledby="{{ $e->exerciseType->underscore_name . $e->id }}-tab">
    <div class="container">
        <h4>{{ $e->title }}</h4>
        @isset($e->extra_info) <p class="text-info"><i class="mdi mdi-information-outline text-info"></i> &nbsp; {{ $e->extra_info }}</p> @endisset
        <p class="text-secondary">{{ $e->description }}</p>
        @isset($e->instructions) <div class="text-dark">{!! $e->instructions !!}</div> @endisset
        @isset($e->translated_instructions) <div class="text-secondary">{!! $e->translated_instructions !!}</div> @endisset
        <div class="row">
            @foreach($e->questions->sortBy('position') as $question)
                <div class="col-12 col-md-6 mt-1 mb-1 text-center">
                    <p>{{ $question->statement }}</p>
                    <img src="{{ asset('esl/public/storage/files/'.$question->image_name) }}" class="img-fluid col-6" alt="img">
                    <audio controls class="col-6">
                        <source src="{{ asset('esl/public/storage/files/'.$question->audio_name) }}" type="audio/mpeg">
                    </audio> 
                </div>
            @endforeach
        </div>
    </div>
</div>