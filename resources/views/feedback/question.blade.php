@if(isset($feedbacks) and count($feedbacks) > 0)
    <div class="m-1 p-1 border border-success feedback question-feedback" hidden>

        {{-- Show on Check if correct response --}}
        @if($feedbacks->where('feedback_type_id', 2)->first() != null)
            <p class="show-on-correct" hidden>{{ $feedbacks->where('feedback_type_id', 2)->first()->message  }}</p>
        @endif

        @if($feedbacks->where('feedback_type_id', 3)->first() != null)
            <audio controls class="col-12" hidden class="show-on-incorrect">
                <source src="{{ asset('esl/public/storage/files/'.$feedbacks->where('feedback_type_id', 3)->first()->audio_name) }}" type="audio/mpeg">
            </audio>
        @endif

        @if($feedbacks->where('feedback_type_id', 5) != null)
            @foreach($feedbacks->where('feedback_type_id', 5) as $feedback)
                <p hidden class="show-on-incorrect">{{ $feedback->message }}</p>
            @endforeach
        @endif

        @if($feedbacks->where('feedback_type_id', 6)->first() != null)
            <p hidden class="show-on-incorrect">{{ $feedbacks->where('feedback_type_id', 6)->first()->message }}</p>
        @endif

        @if($feedbacks->where('feedback_type_id', 7)->first() != null))
            <p hidden class="show-on-incorrect">{{ $feedbacks->where('feedback_type_id', 7)->first()->message }}</p>
        @endif
    
    </div>
@endif