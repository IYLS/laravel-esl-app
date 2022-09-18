<div class="tab-pane fade" id="{{ $e->excerciseType->underscore_name . $e->id }}" role="tabpanel" aria-labelledby="{{ $e->excerciseType->underscore_name . $e->id }}-tab">
    <div class="container">
        <h4>{{ $e->title }}</h4>
        <p class="text-secondary">{{ $e->description }}</p>
        <div class="row">
        @foreach($e->questions as $question)
        <div class="col-5 mt-1 text-center">
            <p>{{ $question->title }}</p>
            <img src="{{ asset('storage/files/'.$question->image_name) }}" class="img-fluid col-6" alt="img">
            <audio controls class="col-6">
                <source src="{{ asset('storage/files/'.$question->audio_name) }}" type="audio/mpeg">
            </audio> 
        </div>
        @endforeach
        </div>
    </div>
</div>