<div class="tab-pane fade exercise-pane @if($loop->index == 0) show active @endif" id="{{ $e->exerciseType->underscore_name . $e->id }}" role="tabpanel" aria-labelledby="{{ $e->exerciseType->underscore_name . $e->id }}-tab">
    <form action="{{ route('tracking.store', ["$e->id", "$user->id"]) }}" method="POST" id="voice_recognition_form_{{ $e->id }}" onsubmit="return getResponseData({{ json_encode($e->questions) }}, {{ json_encode($e) }}, 'voice_recognition')">
        @csrf
        <div class="container">
            <h4>{{ $e->title }}</h4>
            @isset($e->extra_info) <p class="text-info"><span class="material-symbols-outlined text-info">info</span> &nbsp; {{ $e->extra_info }}</p> @endisset
            <p class="text-secondary">{{ $e->description }}</p>
            @isset($e->instructions) <div class="text-dark">{!! $e->instructions !!}</div> @endisset
            @isset($e->translated_instructions) <div class="text-secondary">{!! $e->translated_instructions !!}</div> @endisset
            <div class="row">
                @foreach($e->questions->sortBy('position') as $question)
                    <div class="col-12 col-md-6 mt-1 mb-1 text-center">
                        <p>{{ $question->statement }}</p>
                        <img src="{{ asset('storage/files/'.$question->image_name) }}" class="img-fluid col-6" alt="img">
                        <audio controls class="col-6">
                            <source src="{{ asset('storage/files/'.$question->audio_name) }}" type="audio/mpeg">
                        </audio> 
                    </div>
                @endforeach
            </div>
        </div>
        @include('layouts.tracking.tracking_buttons', ['exercise_id' => $e->id, 'type' => 'voice_recognition'])
    </form>
</div>